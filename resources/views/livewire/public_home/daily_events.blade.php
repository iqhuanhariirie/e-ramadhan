<div class="page-header">
    <h3 class="page-title">{{ __('event.public_schedule_event') }} {{ __('time.'.$this->dayTitle) }}</h3>
    <div class="page-options d-flex">
        @if (!$events->isEmpty())
            <a class="btn btn-sm btn-success" href="{{ route('public_schedules_event.'.$this->dayTitle) }} "role="button">{{ __('app.show') }}</a>
        @endif
    </div>
</div>
@forelse($events as $index => $event)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('event.audience_' . $event->audience_code) }}
            </h3>
        </div>
        <table class="table table-sm mb-0">
            <tbody>
                <tr>
                    <td>{!! config('event.emoji.time') !!} {{ __('event.start_time') }}</td>
                    <td>{{ $event->start_time}}
                    </td>
                </tr>
                <tr>
                        <td class="col-4">{!! config('event.emoji.event') !!} {{ __('event.event') }}</td>
                        <td><strong>{{ $event->event_name}}</strong>
                        </td>
                    </tr>
                <tr>
                    <td>{!! config('event.emoji.event') !!} {{ __('event.event_description') }}</td>
                    <td>{{ $event->event_description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@empty
    <p>{{ __('event.empty') }} {{ __('time.'.$this->dayTitle) }}.</p>
@endforelse
