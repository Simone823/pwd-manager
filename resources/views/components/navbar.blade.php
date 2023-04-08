<nav id="navbar" class="navbar navbar-dark navbar-expand-lg bg-dark shadow-md position-fixed top-0 w-100">
    <div class="container align-items-center">

        {{-- nav brand --}}
        <a class="navbar-brand p-0 me-0 me-lg-5" href="{{ url('/') }}">
            {{-- logo large  --}}
            <figure class="logo-large m-0 d-none d-sm-block">
                <img src="{{ asset('assets/img/icon-site/icon-large-svg.svg') }}" alt="{{ config('app.name') . ' logo' }}">
            </figure>

            {{-- logo small mobile --}}
            <figure class="logo-small m-0 b-block d-sm-none">
                <img src="{{ asset('assets/img/icon-site/icon-small-svg.svg') }}" alt="{{ config('app.name') . ' logo' }}">
            </figure>
        </a>

        {{-- btn mobile menu --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- list link menu --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link link-violet @if (Route::is('home')) active @endif" href="{{ url('/') }}" alt="Dashboard">
                        Dashboard
                    </a>
                </li>
            </ul>

            {{-- btn dropdown profile --}}
            <div class="dropdown">
                <button class="btn btn-violet dropdown-toggle fw-semibold shadow px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->username}}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Esci
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>
