<div class="card table-responsive-sm">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th class="text-center">{{ __('app.table_no') }}</th>
                <th class="col-1">{{ __('time.day_name') }}</th>
                <th class="text-center col-2">{{ __('time.date') }}</th>
                <th class="col-3">{{ __('event.time') }}</th>
                <th class="col-4">{{ __('event.event_name') }}</th>
                <th class="text-center col-2">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($events[$audienceCode]))
                @foreach($events[$audienceCode] as $key => $event)
                <tr>
                    <td class="text-center">{{ 1 + $key }}</td>
                    <td>{{ $event->day_name }}</td>
                    <td class="text-center">{{ $event->full_date }}</td>
                    <td>
                        {{ $event->time_text ? $event->time_text.', ' : '' }}
                        {{ $event->time }}
                    </td>
                    <td>{{ $event->event_name }}</td>
                    <td class="text-center">
                        @can('view', $event)
                            {{ link_to_route(
                                'events.show',
                                __('app.show'),
                                [$event],
                                ['id' => 'show-event-' . $event->id]
                            ) }}
                        @endcan
                    </td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="7">{{ __('event.public_empty') }}</td></tr>
            @endif
        </tbody>
    </table>
</div>
