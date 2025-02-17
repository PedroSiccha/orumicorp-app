<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-bs-toggle="dropdown" class="dropdown-toggle" href="{{ url('/dashboard') }}">
                        <img alt="image" class="rounded" src="{{ asset('img/logo/logo_horizontal_ab.png') }}" width="90%" height="90%" />
                    </a>
                </div>
                <div class="logo-element">
                    <img alt="image" class="rounded-circle" src="{{asset('img/logo/basic_logo.png')}}"
                        width="50%" height="50%" />
                </div>
            </li>
            @foreach ($menuItems as $menuItem)
                @if ($menuItem['can'])
                    <li class="{{ Request::is($menuItem['route']) ? 'active' : '' }}">
                        <a href="{{ $menuItem['url'] }}">
                            <i class="{{ $menuItem['icon'] }}"></i>
                            <span class="nav-label">{{ $menuItem['label'] }}</span>
                            {{-- Notificación --}}
                            @if ($menuItem['notification'])
                                <span class="badge badge-warning float-right">{{ $menuItem['notification'] }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

    </div>
</nav>
