<div class="list-group list-group-transparent list-group-horizontal-md mb-0 text-uppercase">
    <a href="{{ route('public_schedules_event.today', Request::all()) }}" class="list-group-item list-group-item-action {{ in_array(Request::segment(2), [null, 'harini']) ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.today') }}
    </a>
    <a href="{{ route('public_schedules_event.tomorrow', Request::all()) }}" class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['esok']) ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.tomorrow') }}
    </a>
    <a href="{{ route('public_schedules_event.this_week', Request::all()) }}" class="list-group-item list-group-item-action {{ Request::segment(2) == 'minggu_ini' ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.this_week') }}
    </a>
    <a href="{{ route('public_schedules_event.next_week', Request::all()) }}" class="list-group-item list-group-item-action {{ Request::segment(2) == 'minggu_depan' ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.next_week') }}
    </a>
</div>