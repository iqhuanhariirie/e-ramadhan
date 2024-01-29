<table class="table table-sm card-table table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">{{ __('app.table_no') }}</th>
            <th>{{ __('transaction.transaction') }}</th>
            <th class="text-right">{{ __('transaction.income') }}</th>
            <th class="text-right">{{ __('transaction.spending') }}</th>
            <th class="text-right">{{ __('transaction.balance') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($lastMonthBalance || auth()->activeBook()->budget)
            <tr><td colspan="5">{{ __('transaction.balance') }}</td></tr>
        @endif
        @if (auth()->activeBook()->budget)
            <tr>
                <td class="text-center">1</td>
                <td>Baki pada {{ Carbon\Carbon::parse($lastBankAccountBalanceOfTheMonth->date)->isoFormat('D MMMM Y') }} di BANK</td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right text-nowrap">{{ format_number($lastBankAccountBalanceOfTheMonth->amount) }}</td>
            </tr>
        @endif
        @if ($lastMonthBalance)
            <tr>
                <td class="text-center">
                    {{ auth()->activeBook()->budget ? '2' : '1' }}
                </td>
                <td>Sisa baki mengikut {{ $lastMonthDate->isoFormat('D MMMM Y') }}</td>
                <td class="text-right text-nowrap">{{ format_number($lastMonthBalance) }}</td>
                <td class="text-right text-nowrap">-</td>
                <td class="text-center text-nowrap">&nbsp;</td>
            </tr>
        @endif
        <tr><td colspan="5">{{ __('transaction.income') }}</td></tr>
        @php
            $key = 0;
        @endphp
        @foreach($incomeCategories->sortBy('id')->values() as $key => $incomeCategory)
        <tr>
            <td class="text-center">{{ ++$key }}</td>
            <td>{{ $incomeCategory->name }}</td>
            <td class="text-right text-nowrap">
                @if ($groupedTransactions->has(1))
                    {{ format_number($groupedTransactions[1]->where('category_id', $incomeCategory->id)->sum('amount')) }}
                @else
                    0
                @endif
            </td>
            <td class="text-right text-nowrap">-</td>
            <td class="text-center text-nowrap">&nbsp;</td>
        </tr>
        @endforeach
        @if ($groupedTransactions->has(1))
            @foreach($groupedTransactions[1]->where('category_id', null) as $transaction)
            <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td>{{ $transaction->description }}</td>
                <td class="text-right text-nowrap">{{ format_number($transaction->amount) }}</td>
                <td class="text-right text-nowrap">-</td>
                <td class="text-center text-nowrap">&nbsp;</td>
            </tr>
            @endforeach
        @endif
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr><td colspan="5">{{ __('transaction.spending') }}</td></tr>
        @foreach($spendingCategories->sortBy('id')->values() as $key => $spendingCategory)
        <tr>
            <td class="text-center">{{ ++$key }}</td>
            <td>{{ $spendingCategory->name }}</td>
            <td class="text-right text-nowrap">-</td>
            <td class="text-right text-nowrap">
                @if ($groupedTransactions->has(0))
                    {{ format_number($groupedTransactions[0]->where('category_id', $spendingCategory->id)->sum('amount')) }}
                @else
                    0
                @endif
            </td>
            <td class="text-center text-nowrap">&nbsp;</td>
        </tr>
        @endforeach
        @if ($groupedTransactions->has(0))
            @foreach($groupedTransactions[0]->where('category_id', null) as $transaction)
            <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td>{{ $transaction->description }}</td>
                <td class="text-right text-nowrap">-</td>
                <td class="text-right text-nowrap">{{ format_number($transaction->amount) }}</td>
                <td class="text-center text-nowrap">&nbsp;</td>
            </tr>
            @endforeach
        @endif
        <tr><td colspan="5">&nbsp;</td></tr>
    </tbody>
    @if (!$groupedTransactions->isEmpty())
    <tfoot>
        <tr class="strong">
            <td>&nbsp;</td>
            <td class="text-center">
                {{ auth()->activeBook()->budget ? 'Selisih' : '' }} baki {{ $currentMonthEndDate->isoFormat('D MMMM Y') }}
            </td>
            <td class="text-right">
                @php
                    $currentMonthIncome = $groupedTransactions->has(1) ? $groupedTransactions[1]->sum('amount') : 0;
                @endphp
                {{ format_number($lastMonthBalance + $currentMonthIncome) }}
            </td>
            <td class="text-right">
                @php
                    $currentMonthSpending = $groupedTransactions->has(0) ? $groupedTransactions[0]->sum('amount') : 0;
                @endphp
                {{ format_number($currentMonthSpending) }}
            </td>
            <td class="text-right">
                @php
                    $currentMonthBalance = $lastMonthBalance + $currentMonthIncome - $currentMonthSpending;
                @endphp
                {{ format_number($currentMonthBalance) }}
            </td>
        </tr>
        @if (auth()->activeBook()->budget)
        <tr class="strong">
            <td>&nbsp;</td>
            <td class="text-center">Jumlah baki per {{ $currentMonthEndDate->isoFormat('D MMMM Y') }}</td>
            <td class="text-right">-</td>
            <td class="text-right">-</td>
            <td class="text-right">
                {{ format_number($currentMonthBalance + $lastBankAccountBalanceOfTheMonth->amount) }}
            </td>
        </tr>
        @endif
    </tfoot>
    @endif
</table>
