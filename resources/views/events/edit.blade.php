@extends('layouts.app')

@section('event_name', __('event.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $event)
        @can('delete', $event)
        <div class="card">
            <div class="card-header">{{ __('event.delete') }}</div>
            <div class="card-body">
                <label class="control-label text-primary">{{ __('event.event_name') }}</label>
                <p>{{ $event->event_name }}</p>
                <label class="control-label text-primary">{{ __('event.event_description') }}</label>
                <p>{{ $event->event_description }}</p>
                {!! $errors->first('event_id', '<span class="form-error small">:message</span>') !!}
            </div>
            <hr style="margin:0">
            <div class="card-body text-danger">{{ __('event.delete_confirm') }}</div>
            <div class="card-footer">
                {!! FormField::delete(
                ['route' => ['events.destroy', $event]],
                __('app.delete_confirm_button'),
                ['class' => 'btn btn-danger'],
                ['event_id' => $event->id]
                ) !!}
                {{ link_to_route('events.edit', __('app.cancel'), [$event], ['class' => 'btn btn-link']) }}
            </div>
        </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">
                <span class="card-options">{{ $event->audience }}</span>
                {{ __('event.edit') }}
            </div>
            {{ Form::model($event, ['route' => ['events.update', $event], 'method' => 'patch']) }}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('date', [
                        'required' => true,
                        'label' => __('event.date'),
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
                {!! FormField::textarea('event_description', ['required' => false, 'label' => __('event.event_description')]) !!}
            </div>
            <div class="card-footer">
                {{ Form::submit(__('event.update'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('events.show', __('app.cancel'), [$event], ['class' => 'btn btn-link']) }}
                @can('delete', $event)
                {{ link_to_route('events.edit', __('app.delete'), [$event, 'action' => 'delete'], ['class' => 'btn btn-danger float-right', 'id' => 'del-event-'.$event->id]) }}
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
    (function() {
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
    (function() {
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