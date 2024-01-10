@extends('layouts.app')

@section('title', __('event.list'))

@section('content')
<div class="card">
    <div class="card-body">
        {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
            {{ Form::text('q', request('q'), ['class' => 'form-control mr-0 mr-sm-2', 'placeholder' => __('event.search_text')]) }}
            {{ Form::select('month', get_months(), $month, ['class' => 'form-control mr-0 mr-sm-2']) }}
            {{ Form::select('year', get_years(), $year, ['class' => 'form-control mr-0 mr-sm-2']) }}
            <div class="form-group mt-4 mt-sm-0">
                {{ Form::submit(__('app.submit'), ['class' => 'btn btn-primary mr-0 mr-sm-2']) }}
                {{ link_to_route('events.index', __('app.reset'), [], ['class' => 'btn btn-secondary mr-0 mr-sm-2']) }}
                @livewire('prev-month-button', ['routeName' => 'events.index', 'buttonClass' => 'btn btn-secondary mr-0 mr-sm-2'])
                @livewire('next-month-button', ['routeName' => 'events.index', 'buttonClass' => 'btn btn-secondary mr-0 mr-sm-2'])
            </div>
            <div class="form-group mt-0 mt-sm-0">
                @can('create', new App\Models\Event)
                    {{ link_to_route('events.create', __('event.create'), [], ['class' => 'btn btn-success mr-0 mr-sm-2']) }}
                @endcan
            </div>
        {{ Form::close() }}
    </div>
</div>

@foreach ($audienceCodes as $audienceCode => $audience)
    <div class="page-header mb-4">
        <h2 class="page-title">{{ __('event.audience_'.$audienceCode) }}</h2>
    </div>

    @desktop
        @include('events._'.$audienceCode)
    @elsedesktop
        @if (isset($events[$audienceCode]))
            @foreach($events[$audienceCode] as $event)
                @include('events._single_'.$audienceCode)
            @endforeach
        @else
            <p>{{ __('event.'.$audienceCode.'_empty') }}</p>
        @endif
    @enddesktop
@endforeach

@endsection
