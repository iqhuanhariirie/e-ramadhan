<?php

namespace App\Http\Livewire\PublicHome;

use App\Models\Book;
use Livewire\Component;

class WeeklyFinancialSummary extends Component
{
    public $startWeek;
    public $todayDayDate;
    public $currentBalance = 0;
    public $startWeekBalance = 0;
    public $currentWeekIncomeTotal = 0;
    public $currentWeekSpendingTotal = 0;
    public $startBalance = 0;
    
    public $lastBudget = 0;
    public $book; // Add this line

    public function render()
    {
        return view('livewire.public_home.weekly_financial_summary');
    }

    public function index()
    {
        $books = Book::where('status_id', Book::STATUS_ACTIVE)
            ->where('report_visibility_code', Book::REPORT_VISIBILITY_PUBLIC)
            ->get();

        return view('public_reports.index', compact('books'));
    }

    public function mount()
    {
        $this->startWeek = today()->startOfWeek();
        $this->today = today();
        $this->book = auth()->activeBook();
        $defaultBook = Book::find(config('masjid.default_book_id'));
        if (is_null($defaultBook)) {
            return;
        }
        $currentWeekTransactions = $defaultBook->transactions()
            ->whereBetween('date', [$this->startWeek->format('Y-m-d'), $this->today->format('Y-m-d')])->get();
        $this->currentWeekIncomeTotal = $currentWeekTransactions->where('in_out', 1)->sum('amount');
        $this->currentWeekSpendingTotal = $currentWeekTransactions->where('in_out', 0)->sum('amount');
        $endOfLastWeekDate = today()->startOfWeek()->subDay()->format('Y-m-d');
        $this->startBalance = auth()->activeBook()->budget;
        // $this->lastBudget = auth()->activeBook()->getCurrentBudget();
        $this->startWeekBalance = $defaultBook->getBalance($endOfLastWeekDate);
        $this->currentBalance = ($this->startWeekBalance + $this->startBalance) + $this->currentWeekIncomeTotal - $this->currentWeekSpendingTotal;
        
    }
}
