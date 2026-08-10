<div class="bg-dark text-white vh-100 p-3">

    <h4 class="text-center mb-4">
        🚗 SOULAMI CAR
    </h4>

    <ul class="nav nav-pills flex-column">

        <li class="nav-item mb-2">
            <a href="{{ route('home') }}"
               class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                Accueil
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('clients.index') }}"
               class="nav-link text-white {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Clients
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('vehicles.index') }}"
               class="nav-link text-white {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i>
                Véhicules
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('contracts.index') }}"
               class="nav-link text-white {{ request()->routeIs('contracts.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                Contrats
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
               class="nav-link text-white">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>

        <hr>

        <li class="nav-item">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button class="btn btn-danger w-100">

                    Déconnexion

                </button>

            </form>

        </li>

    </ul>

</div>