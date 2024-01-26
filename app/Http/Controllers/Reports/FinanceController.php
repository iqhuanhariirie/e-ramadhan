<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected function determineBudgetSummaryVisibility(Request $request, Book $book): bool
    {
        if (!$book->budget) {
            return false;
        }

        if ($book->report_periode_code == Book::REPORT_PERIODE_IN_MONTHS) {
            $startDate = $this->getStartDate($request)->format('d-m-Y');
            $endDate = $this->getEndDate($request)->format('d-m-Y');
            $expextedStartDate = Carbon::now()->startOfMonth()->format('d-m-Y');
            $expextedEndDate = Carbon::now()->endOfMonth()->format('d-m-Y');

            return $expextedStartDate == $startDate && $expextedEndDate == $endDate;
        }

        if ($book->report_periode_code == Book::REPORT_PERIODE_IN_WEEKS) {
            $startDate = $this->getStartDate($request)->format('d-m-Y');
            $endDate = $this->getEndDate($request)->format('d-m-Y');
            $startDayInteger = constant('\Carbon\Carbon::'.strtoupper($book->start_week_day_code));
            $expextedStartDate = Carbon::now()->startOfWeek($startDayInteger)->format('d-m-Y');
            $endDayInteger = constant('\Carbon\Carbon::'.strtoupper($book->start_week_day_code));
            $expextedEndDate = Carbon::now()->endOfWeek($endDayInteger)->subDay()->format('d-m-Y');

            return $expextedStartDate == $startDate && $expextedEndDate == $endDate;
        }

        if ($book->report_periode_code == Book::REPORT_PERIODE_ALL_TIME) {
            return true;
        }

        return false;
    }

    protected function getStartDate(Request $request): Carbon
    {
        $book = auth()->activeBook();
        if (in_array($book->report_periode_code, ['all_time'])) {
            if ($request->has('start_date')) {
                return Carbon::parse($request->get('start_date'));
            } else {
                $firstTransaction = $book->transactions()->first();
                if (is_null($firstTransaction)) {
                    return Carbon::now()->subDays(30);
                }

                return Carbon::parse($firstTransaction->date);
            }
        }
        if (in_array($book->report_periode_code, ['in_weeks'])) {
            if ($request->has('start_date')) {
                return Carbon::parse($request->get('start_date'));
            } else {
                $startDayInteger = constant('\Carbon\Carbon::'.strtoupper($book->start_week_day_code));
                return Carbon::now()->startOfWeek($startDayInteger);
            }
        }

        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $yearMonth = $this->getYearMonth();

        return Carbon::parse($yearMonth.'-01');
    }

    protected function getEndDate(Request $request): Carbon
    {
        $book = auth()->activeBook();
        if (in_array($book->report_periode_code, ['in_weeks'])) {
            if ($request->has('end_date')) {
                return Carbon::parse($request->get('end_date'));
            } else {
                $endDayInteger = constant('\Carbon\Carbon::'.strtoupper($book->start_week_day_code));
                return Carbon::now()->endOfWeek($endDayInteger)->subDay();
            }
        }
        if ($request->has('end_date')) {
            return Carbon::parse($request->get('end_date'));
        }

        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $yearMonth = $this->getYearMonth();

        return Carbon::parse($yearMonth.'-01')->endOfMonth();
    }
}
