@extends('layouts.guest')

@section('title', __('lecturing.list'))

@section('content')
@include('public_schedules._nav')

@foreach ($audienceCodes as $audienceCode => $audience)
    @if (isset($lecturings[$audienceCode]))
        <div class="page-header my-4">
            <h2 class="page-title">{{ __('lecturing.audience_'.$audienceCode) }}</h2>
        </div>
        @foreach($lecturings[$audienceCode] as $lecturing)
            @include('public_schedules._single_'.$audienceCode)
        @endforeach
    @endif
@endforeach

@if ($lecturings->isEmpty())
    <p class="my-4">
        {{ __('lecturing.empty') }}
        {{ in_array(Request::segment(2), [null, 'today']) ? __('time.today').'.' : '' }}
        {{ in_array(Request::segment(2), ['tomorrow']) ? __('time.tomorrow').'.' : '' }}
        {{ Request::segment(2) == 'this_week' ? __('time.this_week').'.' : '' }}
        {{ Request::segment(2) == 'next_week' ? __('time.next_week').'.' : '' }}
    </p>
@endif

@endsection
