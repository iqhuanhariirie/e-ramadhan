<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $this->authorize('view-any', new Book);

        $editableBook = null;
        $bookQuery = Book::orderBy('name');
        $books = $bookQuery->with('creator', 'bankAccount')->paginate(25);
        $bankAccounts = BankAccount::where('is_active', BankAccount::STATUS_ACTIVE)->pluck('name', 'id');

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableBook = Book::find(request('id'));
        }

        return view('books.index', compact('books', 'editableBook', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Book);

        $newBook = $request->validate([
            'name' => 'required|max:60',
            'description' => 'nullable|max:255',
            'budget' => ['nullable', 'numeric'],
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
        ]);
        $newBook['creator_id'] = auth()->id();

        Book::create($newBook);

        return redirect()->route('books.index');
    }

    public function show(Book $book)
    {
        $this->authorize('view', $book);
        $currentBalance = 0;
        $startBalance = 0;
        $currentIncomeTotal = 0;
        $currentSpendingTotal = 0;

        $currentTransactions = $book->transactions()
            ->withoutGlobalScope('forActiveBook')
            ->get();
        $currentIncomeTotal = $currentTransactions->where('in_out', 1)->sum('amount');
        $currentSpendingTotal = $currentTransactions->where('in_out', 0)->sum('amount');
        $endOfLastDate = today()->startOfWeek()->subDay()->format('d-m-Y');
        $startBalance = $book->getBalance($endOfLastDate);
        $currentBalance = $startBalance + $currentIncomeTotal - $currentSpendingTotal;

        return view('books.show', compact(
            'book', 'startBalance', 'currentBalance', 'currentIncomeTotal', 'currentSpendingTotal'
        ));
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        $bankAccounts = BankAccount::where('is_active', BankAccount::STATUS_ACTIVE)->pluck('name', 'id');

        return view('books.edit', compact('book', 'bankAccounts'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $bookData = $request->validate([
            'name' => 'required|max:60',
            'description' => 'nullable|max:255',
            'status_id' => ['required', Rule::in(Book::getConstants('STATUS'))],
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'report_visibility_code' => ['required', Rule::in(Book::getConstants('REPORT_VISIBILITY'))],
            'budget' => ['nullable', 'numeric'],
            'report_periode_code' => ['required', Rule::in(Book::getConstants('REPORT_PERIODE'))],
            'start_week_day_code' => ['required', 'string'],
        ]);
        $book->update($bookData);

        return redirect()->route('books.show', $book);
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        request()->validate([
            'book_id' => 'required',
        ]);

        DB::beginTransaction();
        $book->categories()->delete();
        $book->transactions()->delete();
        $isBookDeleted = $book->delete();
        DB::commit();

        if (request('book_id') == $book->id && $isBookDeleted) {
            return redirect()->route('books.index');
        }

        return back();
    }
}
