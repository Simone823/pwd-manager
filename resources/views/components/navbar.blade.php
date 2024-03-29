<nav id="navbar" class="navbar navbar-dark navbar-expand-lg bg-dark shadow-md position-sticky top-0 w-100">
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
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 py-4 py-lg-0 gap-4">
                <li class="nav-item">
                    <a class="nav-link link-light-gray @if (Route::is('home') || Route::is('home.search-accounts')) active fw-bold @endif" href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                @if (Auth::user()->hasPermission('categories-view'))
                    <li class="nav-item">
                        <a class="nav-link link-light-gray @if (Route::is('categories.*')) active fw-bold @endif" href="{{ route('categories.index') }}">
                            Categorie
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('clients-view'))    
                    <li class="nav-item">
                        <a class="nav-link link-light-gray @if (Route::is('clients.*')) active fw-bold @endif" href="{{ route('clients.index') }}">
                            Clienti
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('accounts-view'))    
                    <li class="nav-item">
                        <a class="nav-link link-light-gray @if (Route::is('accounts.*')) active fw-bold @endif" href="{{ route('accounts.index') }}">
                            Account
                        </a>
                    </li>
                @endif
            </ul>

            {{-- btn dropdown profile --}}
            <div class="dropdown">
                <button class="btn btn-orange dropdown-toggle fw-semibold shadow px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->name}} {{Auth::user()->surname}}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <a class="dropdown-item @if (Route::is('profiles.*')) active @endif" href="{{route('profiles.show', Auth::id())}}">
                            <i class="fa-solid fa-user-pen me-1"></i>
                            Profilo
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li>
                            <a class="dropdown-item @if (Route::is('admin.permissions.*')) active @endif" href="{{route('admin.permissions.index')}}">
                                <i class="fa-solid fa-briefcase me-1"></i>
                                Permessi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item @if (Route::is('admin.roles.*')) active @endif" href="{{route('admin.roles.index')}}">
                                <i class="fa-solid fa-medal me-1"></i>
                                Ruoli
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item @if (Route::is('admin.users.*')) active @endif" href="{{route('admin.users.index')}}">
                                <i class="fa-solid fa-user me-1"></i>
                                Utenti
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item @if (Route::is('admin.log-activities.*')) active @endif" href="{{route('admin.log-activities.index')}}">
                                <i class="fa-solid fa-list me-1"></i>
                                Log Attività
                            </a>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>
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
