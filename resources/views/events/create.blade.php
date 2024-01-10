@extends('layouts.app')

@section('event_name', __('event.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('event.create') }}</div>
            {{ Form::open(['route' => 'events.store']) }}
            <div class="card-body">
                {!! FormField::radios('audience_code', $audienceCodes, [
                    'required' => true,
                    'label' => __('event.audience'),
                    'value' => old('audience_code', App\Models\Event::AUDIENCE_PUBLIC),
                ]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date', [
                            'required' => true,
                            'label' => __('event.date'),
                            'value' => old('date', date('Y-m-d')),
                            'class' => 'date-select',
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">{!! FormField::text('start_time', ['required' => true, 'label' => __('event.start_time'), 'placeholder' => '19:00']) !!}</div>
                            <div class="col-6">{!! FormField::text('end_time', ['label' => __('event.end_time'), 'placeholder' => '19:40']) !!}</div>
                        </div>
                    </div>
                </div>
                {!! FormField::text('event_name', ['required' => true, 'label' => __('event.event_name')]) !!}
                {!! FormField::textarea('event_description', ['label' => __('event.event_description')]) !!}
            </div>
            <div class="card-footer">
                {{ Form::submit(__('app.create'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('events.index', __('app.cancel'), [], ['class' => 'btn btn-link']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
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
        scrollMonth: false,
    });
})();
</script>
@endpush
