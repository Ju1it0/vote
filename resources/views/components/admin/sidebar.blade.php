<!-- Sidebar -->
<div class="col-md-3 col-lg-2 px-0 sidebar">
    <div class="d-flex flex-column p-3">
        <h5 class="mb-3">Menú</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-graph-up"></i> Candidatos más votados
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.votes.*') ? 'active' : '' }}" href="{{ route('admin.votes.index') }}">
                    <i class="bi bi-list-check"></i> Listado de Votos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.voters.*') ? 'active' : '' }}" href="{{ route('admin.voters.index') }}">
                    <i class="bi bi-people"></i> Gestionar Votantes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.password') ? 'active' : '' }}" href="{{ route('admin.password') }}">
                    <i class="bi bi-key"></i> Cambiar Contraseña
                </a>
            </li>
        </ul>
    </div>
</div> 