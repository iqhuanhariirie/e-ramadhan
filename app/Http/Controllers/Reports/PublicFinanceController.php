<?php

namespace App\Http\Controllers\Reports;

use App\Models\BankAccountBalance;
use App\Models\Book;
use App\Transaction;
use Carbon\Carbon;
use Facades\App\Helpers\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PublicFinanceController extends FinanceController
{
    public function index()
    {
        $books = Book::where('status_id', Book::STATUS_ACTIVE)
            ->where('report_visibility_code', Book::REPORT_VISIBILITY_PUBLIC)
            ->get();

        return view('public_reports.index', compact('books'));
    }

    public function summary(Request $request)
    {
        $startDate = $this->getStartDate($request);
        $endDate = $this->getEndDate($request);
        $book = auth()->activeBook();

        $groupedTransactions = $this->getTansactionsByDateRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'))->groupBy('in_out');
        $incomeCategories = isset($groupedTransactions[1]) ? $groupedTransactions[1]->pluck('category')->unique()->filter() : collect([]);
        $spendingCategories = isset($groupedTransactions[0]) ? $groupedTransactions[0]->pluck('category')->unique()->filter() : collect([]);
        $lastMonthDate = $startDate->clone()->subDay();
        $currentMonthEndDate = $endDate->clone();
        if ($startDate->format('Y-m') == Carbon::now()->format('Y-m')) {
            $currentMonthEndDate = Carbon::now();
        }
        // $lastBankAccountBalanceOfTheMonth = $this->getLastBankAccountBalance($currentMonthEndDate);
        $lastMonthBalance = auth()->activeBook()->getBalance($lastMonthDate->format('Y-m-d'));
        $lastBudget = auth()->activeBook()->getCurrentBudget();

        $reportPeriode = $book->report_periode_code;
        $showBudgetSummary = $this->determineBudgetSummaryVisibility($request, $book);
        // $currentBalance = $startBalance + $currentIncomeTotal - $currentSpendingTotal;

        return view('public_reports.finance.'.$reportPeriode.'.summary', compact(
            'startDate', 'endDate', 'groupedTransactions', 'incomeCategories',
            'spendingCategories', 'lastMonthDate',
            'lastMonthBalance', 'currentMonthEndDate', 'reportPeriode', 'showBudgetSummary', 'lastBudget'
        ));
    }

    public function categorized(Request $request)
    {
        $startDate = $this->getStartDate($request);
        $endDate = $this->getEndDate($request);
        $book = auth()->activeBook();

        $groupedTransactions = $this->getTansactionsByDateRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'))->groupBy('in_out');
        $incomeCategories = isset($groupedTransactions[1]) ? $groupedTransactions[1]->pluck('category')->unique()->filter() : collect([]);
        $spendingCategories = isset($groupedTransactions[0]) ? $groupedTransactions[0]->pluck('category')->unique()->filter() : collect([]);
        $currentMonthEndDate = $endDate->clone();

        $reportPeriode = $book->report_periode_code;

        return view('public_reports.finance.'.$reportPeriode.'.categorized', compact(
            'startDate', 'endDate', 'currentMonthEndDate', 'reportPeriode',
            'groupedTransactions', 'incomeCategories', 'spendingCategories'
        ));
    }

    public function detailed(Request $request)
    {
        $startDate = $this->getStartDate($request);
        $endDate = $this->getEndDate($request);
        $book = auth()->activeBook();

        $groupedTransactions = $this->getWeeklyGroupedTransactions($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
        $currentMonthEndDate = $endDate->clone();

        $reportPeriode = $book->report_periode_code;

        return view('public_reports.finance.'.$reportPeriode.'.detailed', compact(
            'startDate', 'endDate', 'groupedTransactions', 'currentMonthEndDate', 'reportPeriode'
        ));
    }

    private function getWeeklyGroupedTransactions(string $startDate, string $endDate): Collection
    {
        $lastMonthDate = Carbon::parse($startDate)->subDay();

        $transactions = $this->getTansactionsByDateRange($startDate, $endDate);
        $groupedTransactions = collect([]);
        $lastWeekDate = null;

        $dateRangePerWeek = get_date_range_per_week($startDate, $endDate, auth()->activeBook()->start_week_day_code);
        foreach ($dateRangePerWeek as $weekNumber => $weekDates) {
            $weekTransactions = $transactions->filter(function ($transaction) use ($weekDates) {
                return in_array($transaction->date, $weekDates);
            });
            $lastWeekDate = $lastWeekDate ?: $lastMonthDate;
            if (!$weekTransactions->isEmpty()) {
                $firstBalance = new Transaction([
                    'date' => null,
                    'description' => 'Saldo per '.$lastWeekDate->isoFormat('D MMMM Y'),
                    'in_out' => 1,
                    'amount' => auth()->activeBook()->getBalance($lastWeekDate->format('Y-m-d')),
                ]);
                $firstBalance->is_strong = 1;
                $weekTransactions->prepend($firstBalance);
                $groupedTransactions->put($weekNumber, $weekTransactions->groupBy('day_name'));
                $lastWeekDate = Carbon::parse($weekTransactions->last()->date);
            }
        }

        return collect($groupedTransactions);
    }

    // private function getLastBankAccountBalance(Carbon $currentMonthEndDate): BankAccountBalance
    // {
    //     $activeBookBankAccount = auth()->activeBook()->bankAccount;
    //     if (is_null($activeBookBankAccount)) {
    //         return new BankAccountBalance([
    //             'date' => $currentMonthEndDate->format('Y-m-d'),
    //             'amount' => 0,
    //         ]);
    //     }

    //     $currentMonthBalance = $activeBookBankAccount->balances()
    //         ->where('date', '<=', $currentMonthEndDate->format('Y-m-d'))
    //         ->orderBy('date', 'desc')
    //         ->first();

    //     if (is_null($currentMonthBalance)) {
    //         return new BankAccountBalance([
    //             'date' => $currentMonthEndDate->format('Y-m-d'),
    //             'amount' => 0,
    //         ]);
    //     }

    //     return $currentMonthBalance;
    // }

    // to inform the views (including css style) to show the letterhead only if masjid name and address not empty
    private function showLetterhead(): bool
    {
        return Setting::get('masjid_name', config('masjid.name')) && Setting::get('masjid_address');
    }
}
