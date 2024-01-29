<div class="list-group list-group-transparent list-group-horizontal-md mb-0 text-uppercase">
    <a href="{{ route('public_schedules.today', Request::all()) }}" class="list-group-item list-group-item-action {{ in_array(Request::segment(2), [null, 'today']) ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.today') }}
    </a>
    <a href="{{ route('public_schedules.tomorrow', Request::all()) }}" class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['tomorrow']) ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.tomorrow') }}
    </a>
    <a href="{{ route('public_schedules.this_week', Request::all()) }}" class="list-group-item list-group-item-action {{ Request::segment(2) == 'this_week' ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.this_week') }}
    </a>
    <a href="{{ route('public_schedules.next_week', Request::all()) }}" class="list-group-item list-group-item-action {{ Request::segment(2) == 'next_week' ? 'active' : '' }}">
        <span class="icon mr-2"><i class="fe fe-calendar"></i></span>{{ __('time.next_week') }}
    </a>
</div>
