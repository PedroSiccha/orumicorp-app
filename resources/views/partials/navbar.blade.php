<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li><a id="dateMenu"></a></li>
        <li><a id="clockMenu"></a></li>

        {{-- Botón de ruleta --}}
        @if ($rouletteSpin > 0)
            <li>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal5">
                    Ruleta {{ $rouletteSpin }}
                </button>
            </li>
        @endif

        {{-- Dropdown usuario --}}
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <img alt="Usuario" class="rounded-circle"
                    src="{{ $dataUser->img ? asset($dataUser->img) : asset('img/logo/basic_logo.png') }}"
                    style="width: 40px; height: auto;" />
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a class="dropdown-item" href="{{ route('perfilUsuario', ['id' => auth()->id()]) }}">Perfil</a></li>
                <li><a class="dropdown-item" href="#">Manuales</a></li>
                <li><a class="dropdown-item" href="#">Correos</a></li>
                <li class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
