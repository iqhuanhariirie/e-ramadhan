<div class="card">
    <table class="table table-striped table-hover table-sm mb-0">
        <tbody>
            <tr>
                <td class="col-4">{!! config('event.emoji.event') !!} {{ __('event.event') }}</td>
                <td><strong>{{ $event->day_name }}, {{ $event->time_text }}</strong></td>
            </tr>
            <tr><td>{!! config('event.emoji.date') !!} {{ __('time.date') }}</td><td>{{ $event->full_date }}</td></tr>
            <tr><td>{!! config('event.emoji.time') !!} {{ __('event.time') }}</td><td>{{ $event->time }}</td></tr>
            <tr><td>{!! config('event.emoji.event') !!} {{ __('event.event_name') }}</td><td>{{ $event->event_name }}</td></tr>
            @if ($event->event_description)
                <tr><td>{!! config('event.emoji.event_description') !!} {{ __('event.event_description') }}</td><td>{{ $event->event_description }}</td></tr>
            @endif
        </tbody>
        <tfoot class="table">
            <tr>
                <td colspan="2" class="text-center">
                    @can('view', $event)
                        {{ link_to_route(
                            'events.show',
                            __('app.show'),
                            [$event],
                            ['id' => 'show-event-' . $event->id, 'class' => 'btn btn-primary']
                        ) }}
                    @endcan
                </td>
            </tr>
        </tfoot>
    </table>
</div>
