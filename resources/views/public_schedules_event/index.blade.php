@extends('layouts.guest')

@section('title', __('event.list'))

@section('content')
@include('public_schedules_event._nav')

@foreach ($audienceCodes as $audienceCode => $audience)
    @if (isset($events[$audienceCode]))
        <div class="page-header my-4">
            <h2 class="page-title">{{ __('event.audience_'.$audienceCode) }}</h2>
        </div>
        @foreach($events[$audienceCode] as $event)
            @include('public_schedules_event._single_'.$audienceCode)
        @endforeach
    @endif
@endforeach

@if ($events->isEmpty())
    <p class="my-4">
        {{ __('event.empty') }}
        {{ in_array(Request::segment(2), [null, 'harini']) ? __('time.today').'.' : '' }}
        {{ in_array(Request::segment(2), ['esok']) ? __('time.tomorrow').'.' : '' }}
        {{ Request::segment(2) == 'minggu_ini' ? __('time.this_week').'.' : '' }}
        {{ Request::segment(2) == 'minggu_depan' ? __('time.next_week').'.' : '' }}
    </p>
@endif

@endsection
