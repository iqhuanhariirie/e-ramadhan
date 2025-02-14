@extends('layouts.reports')

@section('subtitle', __('report.finance_categorized'))

@section('content-report')



<div class="page-header my-0">
    <h1 class="page-title mb-4">
        @if (isset(auth()->activeBook()->report_titles['finance_categorized']))
            {{ auth()->activeBook()->report_titles['finance_categorized'] }}
        @else
            {{ __('report.finance_categorized') }}
        @endif

       
    </h1>
    <div class="page-options d-flex">
        {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
        {{ Form::label('date_range', __('report.view_date_range_label'), ['class' => 'control-label mr-1']) }}
        {{ Form::text('start_date', $startDate->format('Y-m-d'), ['class' => 'date-select form-control mr-1', 'style' => 'width:100px']) }}
        {{ Form::text('end_date', $endDate->format('Y-m-d'), ['class' => 'date-select form-control mr-1', 'style' => 'width:100px']) }}
        <div class="form-group mt-4 mt-sm-0">
            {{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info mr-1']) }}
            {{ link_to_route('reports.finance.categorized', __('app.reset'), [], ['class' => 'btn btn-secondary mr-1']) }}
            {{ link_to_route('reports.finance.categorized_pdf', __('report.export_pdf'), ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')], ['class' => 'btn btn-secondary mr-1']) }}
        </div>
        <div class="form-group">
            @livewire('prev-week-button', ['routeName' => 'reports.finance.categorized', 'buttonClass' => 'btn btn-secondary mr-1'])
            @livewire('next-week-button', ['routeName' => 'reports.finance.categorized', 'buttonClass' => 'btn btn-secondary'])
        </div>
        {{ Form::close() }}
    </div>
</div>

<div class="page-header mt-0 mb-2">
    <h2 class="page-title">{{ __('transaction.income') }}</h2>
</div>

@if ($groupedTransactions->has(1) && !$groupedTransactions[1]->where('category_id', null)->isEmpty())
    <h4 class="mt-0 text-danger">~{{ __('transaction.no_category') }}~</h4>
    <div class="card table-responsive">
        @include('reports.finance._internal_content_categorized', [
            'hasGroupedTransactions' => $groupedTransactions->has(1),
            'transactions' => $groupedTransactions[1]->where('category_id', null),
            'categoryName' => __('transaction.no_category'),
        ])
    </div>
@endif

@foreach($incomeCategories->sortBy('id')->values() as $key => $incomeCategory)
<h4 class="mt-0">{{ $incomeCategory->name }}</h4>
<div class="card table-responsive">
    @include('reports.finance._internal_content_categorized', [
        'hasGroupedTransactions' => $groupedTransactions->has(1),
        'transactions' => $groupedTransactions[1]->where('category_id', $incomeCategory->id),
        'categoryName' => $incomeCategory->name,
    ])
</div>
@endforeach

<div class="page-header mt-0 mb-2">
    <h2 class="page-title">{{ __('transaction.spending') }}</h2>
</div>

@if ($groupedTransactions->has(0) && !$groupedTransactions[0]->where('category_id', null)->isEmpty())
    <h4 class="mt-0 text-danger">~{{ __('transaction.no_category') }}~</h4>
    <div class="card table-responsive">
        @include('reports.finance._internal_content_categorized', [
            'hasGroupedTransactions' => $groupedTransactions->has(0),
            'transactions' => $groupedTransactions[0]->where('category_id', null),
            'categoryName' => __('transaction.no_category'),
        ])
    </div>
@endif

@foreach($spendingCategories->sortBy('id')->values() as $key => $spendingCategory)
<h4 class="mt-0">{{ $spendingCategory->name }}</h4>
<div class="card table-responsive">
    @include('reports.finance._internal_content_categorized', [
        'hasGroupedTransactions' => $groupedTransactions->has(0),
        'transactions' => $groupedTransactions[0]->where('category_id', $spendingCategory->id),
        'categoryName' => $spendingCategory->name,
    ])
</div>
@endforeach
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function () {
    $('#reportModal').modal({
        show: true,
        backdrop: 'static',
    });
    $('.date-select').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false,
        dayOfWeekStart: 1,
        scrollMonth: false,
    });
})();
</script>
@endpush
