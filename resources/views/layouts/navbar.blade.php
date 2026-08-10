<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

    <div class="container-fluid">

        <a
            class="navbar-brand fw-bold"
            href="{{ route('home') }}">

            🚗 SOULAMI CAR

        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div
            class="collapse navbar-collapse"
            id="navbar">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">

                        Accueil

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"
                        href="{{ route('clients.index') }}">

                        Clients

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                        href="{{ route('vehicles.index') }}">

                        Véhicules

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('contracts.*') ? 'active' : '' }}"
                        href="{{ route('contracts.index') }}">

                        Contrats

                    </a>

                </li>

            </ul>

            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown">

                        @auth
                            {{ auth()->user()->name }}
                        @endauth

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('dashboard') }}">

                                Dashboard

                            </a>

                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>

                            <form
                                action="{{ route('logout') }}"
                                method="POST">

                                @csrf

                                <button
                                    class="dropdown-item">

                                    Déconnexion

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>