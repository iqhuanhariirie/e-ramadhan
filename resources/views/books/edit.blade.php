@extends('layouts.app')

@section('title', __('book.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $book)
        @can('delete', $book)
            <div class="card">
                <div class="card-header">{{ __('book.delete') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label text-primary">{{ __('book.name') }}</label>
                            <p>{{ $book->name }}</p>
                            <label class="control-label text-primary">{{ __('book.description') }}</label>
                            <p>{{ $book->description }}</p>
                            
                            <label class="control-label text-primary">{{ __('book.budget') }}</label>
                            <p>{{ $book->budget }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-primary">{{ __('book.report_visibility') }}</label>
                            <p>{{ __('book.report_visibility_'.$book->report_visibility_code) }}</p>
                            
                            <label class="control-label text-primary">{{ __('report.start_week_day') }}</label>
                            <p>{{ __('time.days.'.$book->start_week_day_code) }}</p>
                        </div>
                    </div>
                    {!! $errors->first('book_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body bg-warning">
                    <div class="row">
                        <div class="col-1"><i class="fe fe-alert-circle"></i></div>
                        <div class="col-11">{!! __('book.delete_confirm') !!}</div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! FormField::delete(
                        ['route' => ['books.destroy', $book], 'onsubmit' => __('app.delete_confirm')],
                        __('app.delete_confirm_button'),
                        ['class' => 'btn btn-danger'],
                        ['book_id' => $book->id]
                    ) !!}
                    {{ link_to_route('books.edit', __('app.cancel'), [$book], ['class' => 'btn btn-link']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('book.edit') }}</div>
            {{ Form::model($book, ['route' => ['books.update', $book], 'method' => 'patch']) }}
            <div class="card-body">
                    {!! FormField::text('name', ['required' => true, 'label' => __('book.name')]) !!}
                    {!! FormField::textarea('description', ['label' => __('book.description')]) !!}
                    <div class="row">
                        
                        <div class="col-md-6">
                            {!! FormField::price('budget', [
                                'label' => __('book.budget'),
                                'type' => 'number',
                                'currency' => config('money.currency_code'),
                                'step' => number_step()
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::radios('status_id', [
                                App\Models\Book::STATUS_INACTIVE => __('book.status_inactive'),
                                App\Models\Book::STATUS_ACTIVE => __('app.active')
                            ], ['label' => __('app.status')]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::radios('report_visibility_code', [
                                App\Models\Book::REPORT_VISIBILITY_PUBLIC => __('category.report_visibility_public'),
                                App\Models\Book::REPORT_VISIBILITY_INTERNAL => __('category.report_visibility_internal')
                            ], ['label' => __('category.report_visibility')]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-6">
                            {!! FormField::select('report_periode_code', [
                                App\Models\Book::REPORT_PERIODE_IN_MONTHS => __('report.in_months'),
                                App\Models\Book::REPORT_PERIODE_IN_WEEKS => __('report.in_weeks'),
                                App\Models\Book::REPORT_PERIODE_ALL_TIME => __('report.all_time'),
                            ], ['label' => __('report.periode'), 'placeholder' => false]) !!}
                        </div> -->
                        <div class="col-md-6">
                            {!! FormField::select('start_week_day_code', [
                                'monday' => __('time.days.monday'),
                                'tuesday' => __('time.days.tuesday'),
                                'wednesday' => __('time.days.wednesday'),
                                'thursday' => __('time.days.thursday'),
                                'friday' => __('time.days.friday'),
                                'saturday' => __('time.days.saturday'),
                                'sunday' => __('time.days.sunday'),
                            ], ['label' => __('report.start_week_day'), 'placeholder' => false]) !!}
                        </div>
                    </div>
                </div>
            <div class="card-footer">
                {{ Form::submit(__('book.update'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('books.show', __('app.cancel'), [$book], ['class' => 'btn btn-link']) }}
                @can('delete', $book)
                    {{ link_to_route('books.edit', __('app.delete'), [$book, 'action' => 'delete'], ['class' => 'btn btn-danger float-right', 'id' => 'del-book-'.$book->id]) }}
                @endcan
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function () {
    $('.date-select').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false,
        dayOfWeekStart: 1,
        inline: true,
    });
})();
</script>
@endpush

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function () {
    $('.date-select').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false,
        dayOfWeekStart: 1,
        inline: true,
        scrollMonth: false,
    });
})();
</script>
@endpush
