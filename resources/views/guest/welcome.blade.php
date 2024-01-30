@extends('layouts.guest')

@section('title', __('app.welcome'))

@section('content')
    <div class="jumbotron p-6 mb-0 text-white rounded bg-dark">
        <div class="col-md-3 px-0">
            <h1 class="display-4 font-italic">
                @yield('title'),{{ config('masjid.name') }}
            </h1>
            <p class="lead my-3">
                <a class="btn btn-lg btn-primary mr-3" href="{{ route('public_reports.index') }}"
                    role="button">{{ __('report.view_report') }}</a>
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
