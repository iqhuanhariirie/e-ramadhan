@extends('layouts.app')

@section('title', __('event.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span class="card-options">{{ $event->audience }}</span>
                {{ __('event.detail') }}
            </div>
            <table class="table table-sm">
                <tbody>
                    <tr><td>{!! config('event.emoji.date') !!} {{ __('time.date') }}</td><td><strong>{{ $event->day_name }}</strong>, {{ $event->full_date }}</td></tr>
                    <tr><td>{!! config('event.emoji.time') !!} {{ __('event.time') }}</td><td>{{ $event->time }}</td></tr>
                    <tr><td>{!! config('event.emoji.event_name') !!} {{ __('event.event_name') }}</td><td>{{ $event->event_name }}</td></tr>
                    <tr><td>{!! config('event.emoji.event_description') !!} {{ __('event.event_description') }}</td><td>{{ $event->event_description }}</td></tr>
                </tbody>
            </table>
            <div class="card-footer">
                @can('update', $event)
                    {{ link_to_route('events.edit', __('event.edit'), [$event], ['class' => 'btn btn-warning', 'id' => 'edit-event-'.$event->id]) }}
                @endcan
                {{ link_to_route('events.index', __('event.back_to_index'), [], ['class' => 'btn btn-link']) }}
            </div>
        </div>
    </div>
</div>
@endsection
