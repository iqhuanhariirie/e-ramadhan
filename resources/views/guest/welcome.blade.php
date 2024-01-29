@extends('layouts.guest')

@section('title', __('app.welcome'))

@section('content')
    <div class="jumbotron p-5 mb-0 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">
                @yield('title'),<br> {{ config('masjid.name') }}
            </h1>
            <p class="lead my-3">
                <a class="btn btn-lg btn-primary mr-3" href="{{ route('public_reports.index') }}"
                    role="button">{{ __('report.view_report') }}</a>
                <a class="btn btn-lg btn-secondary mr-3" href="{{ route('public_schedules.index') }}"
                    role="button">{{ __('lecturing.lecturing') }}</a>
                <a class="btn btn-lg btn-warning" href="{{ route('public_schedules_event.index') }}"
                    role="button">{{ __('event.event') }}</a>
            </p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">{{ __('report.finance_summary_in_weeks') }}</h3>
                </div>
                <div class="card-body">
                    @livewire('public-home.weekly-financial-summary')
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">{{ __('lecturing.dashboard_title') }}</h3>
                </div>
                <div class="card-body">
                    @livewire('public-home.daily-lecturings', ['date' => today(), 'dayTitle' => 'today'])
                    @livewire('public-home.daily-lecturings', ['date' => today()->addDay(), 'dayTitle' => 'tomorrow'])
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h3 class="card-title">{{ __('event.dashboard_title') }}</h3>
                </div>
                <div class="card-body">
                    @livewire('public-home.daily-events', ['date' => today(), 'dayTitle' => 'today'])
                    @livewire('public-home.daily-events', ['date' => today()->addDay(), 'dayTitle' => 'tomorrow'])
                </div>
            </div>
        </div>
    </div>

@endsection
