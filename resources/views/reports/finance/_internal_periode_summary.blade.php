@php
    $currentMonthIncome = $groupedTransactions->has(1) ? $groupedTransactions[1]->sum('amount') : 0;
    $currentMonthSpending = $groupedTransactions->has(0) ? $groupedTransactions[0]->sum('amount') : 0;
    $currentMonthBalance = $lastMonthBalance + $currentMonthIncome - $currentMonthSpending; 
    $budgetDiff = auth()->activeBook()->budget + $currentMonthBalance;
@endphp
<div class="card table-responsive">
    <table class="table table-sm table-bordered mb-0">
        <tr>
            <td class="col-xs-2 text-center">{{ __('report.current_all_time_budget') }}</td>
            <td class="col-xs-2 text-center text-success">{{ __('report.current_periode_income_total') }}</td>
            <td class="col-xs-2 text-center text-red">{{ __('report.current_periode_spending_total') }}</td>
            <td class="col-xs-2 text-center">{{ __('report.current_net_income') }}</td>
            <td class="col-xs-2 text-center strong text-blue">
                @if ($budgetDiff > 0)
                    {{ __('report.current_periode_budget_remaining') }}
                @else
                    {{ __('report.current_periode_budget_excess') }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ format_number(auth()->activeBook()->budget) }}</td>
            <td class="text-center lead text-success" style="border-top: none;">{{ format_number($lastMonthBalance + $currentMonthIncome) }}</td>
            <td class="text-center lead text-red" style="border-top: none;">{{ format_number($currentMonthSpending) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ format_number($currentMonthBalance) }}</td>
            <td class="text-center lead strong text-blue" style="border-top: none;">
                {{ format_number(abs($budgetDiff)) }}
            </td>
        </tr>
    </table>
</div>
