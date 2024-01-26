<nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm">
    <div class="container">
        <div class="navbar-header">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('home') }}">
                @guest
                    {{ config('app.name', 'Laravel') }}
                @else
                    {{ auth()->user()->name }}
                @endguest
            </a>
        </div>
        <a class="d-block d-sm-none {{ in_array(Request::segment(1), [null]) ? 'text-primary strong' : 'text-dark' }}" href="{{ url('/') }}">
            <i class="fe fe-home"></i> {{ __('app.public_home') }}
        </a>
        @auth
            @if (auth()->activeBook())
                @include ('layouts._top_nav_active_book')
            @endif
        @endauth

        <!-- Right Side Of Navbar -->
        <div class="nav navbar-nav ml-auto d-none d-sm-block">
            <a class="xs-navbar mr-4" href="{{ url('/') }}">
                <i class="fe fe-home h3 d-inline d-lg-none"></i>
                <span class="d-none d-lg-inline"><i class="fe fe-home"></i> {{ __('app.public_home') }}</span>
            </a>
            <!-- Authentication Links -->
            <a class="xs-navbar mr-4" href="{{ route('transactions.index') }}" title="{{ __('transaction.transaction') }}">
                <i class="fe fe-repeat h3 d-inline d-lg-none"></i>
                <span class="d-none d-lg-inline"><i class="fe fe-repeat"></i> {{ __('transaction.transaction') }}</span>
            </a>
            
            @can('view-any', new App\Models\Lecturing)
                <a class="xs-navbar mr-4" href="{{ route('lecturings.index') }}" title="{{ __('lecturing.lecturing') }}">
                    <i class="fe fe-book-open h3 d-inline d-lg-none"></i>
                    <span class="d-none d-lg-inline"><i class="fe fe-book-open"></i> {{ __('lecturing.lecturing') }}</span>
                </a>
            @endcan
            @can('view-any', new App\Models\Event)
                <a class="xs-navbar mr-4" href="{{ route('events.index') }}" title="{{ __('event.event') }}">
                    <i class="fe fe-book-open h3 d-inline d-lg-none"></i>
                    <span class="d-none d-lg-inline"><i class="fe fe-book-open"></i> {{ __('event.event') }}</span>
                </a>
            @endcan
            <a class="xs-navbar mr-4" href="{{ route('reports.index') }}" title="{{ __('report.report') }}">
                <i class="fe fe-bar-chart-2 h3 d-inline d-lg-none"></i>
                <span class="d-none d-lg-inline"><i class="fe fe-bar-chart-2"></i> {{ __('report.report') }}</span>
            </a>
            <a class="xs-navbar mr-4" href="{{ route('profile.show') }}" title="{{ __('settings.settings') }}">
                <i class="fe fe-settings h3 d-inline d-lg-none"></i>
                <span class="d-none d-lg-inline"><i class="fe fe-settings"></i> {{ __('settings.settings') }}</span>
            </a>
            <a class="xs-navbar mr-4" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                 <i class="fe fe-log-out h3 d-inline d-lg-none"></i>
                <i class="fe fe-log-out d-none d-lg-inline"></i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                <input type="submit" value="{{ __('auth.logout') }}" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</nav>