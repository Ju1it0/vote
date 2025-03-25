<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Votos - Sistema de Votación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .nav-link {
            color: #333;
        }
        .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .top-candidate {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Votación</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <h5 class="mb-3">Menú</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-graph-up"></i> Candidatos más votados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('votes.index') }}">
                                <i class="bi bi-list-check"></i> Listado de Votos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="col-md-9 col-lg-10 px-4 py-3">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Listado de Votos</h4>
                    </div>
                    <div class="card-body">
                        @if($topCandidate)
                            <div class="top-candidate">
                                <h5 class="mb-2">Candidato Ganador</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Nombre:</strong> {{ $topCandidate->name }} {{ $topCandidate->lastname }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Documento:</strong> {{ $topCandidate->document }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Votos:</strong> {{ $topCandidate->vote_count }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Votante</th>
                                        <th>Candidato</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($votes as $vote)
                                        <tr>
                                            <td>{{ $vote->date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $vote->voter->name }} {{ $vote->voter->lastname }}</td>
                                            <td>{{ $vote->candidate->name }} {{ $vote->candidate->lastname }}</td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#voteModal"
                                                        onclick="loadVoteDetails({{ $vote->id }})">
                                                    Ver Detalle
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No hay votos registrados</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $votes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalle -->
    <div class="modal fade" id="voteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle del Voto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="voteDetails">
                        <!-- Aquí se cargarán los detalles del voto -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadVoteDetails(voteId) {
            fetch(`/votes/${voteId}`)
                .then(response => response.json())
                .then(vote => {
                    const details = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Información del Votante</h6>
                                <p><strong>Nombre:</strong> ${vote.voter.name} ${vote.voter.lastname}</p>
                                <p><strong>Documento:</strong> ${vote.voter.document}</p>
                                <p><strong>Fecha de Nacimiento:</strong> ${new Date(vote.voter.dob).toLocaleDateString()}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Información del Candidato</h6>
                                <p><strong>Nombre:</strong> ${vote.candidate.name} ${vote.candidate.lastname}</p>
                                <p><strong>Documento:</strong> ${vote.candidate.document}</p>
                                <p><strong>Fecha de Nacimiento:</strong> ${new Date(vote.candidate.dob).toLocaleDateString()}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="mb-3">Información del Voto</h6>
                                <p><strong>Fecha y Hora:</strong> ${new Date(vote.date).toLocaleString()}</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('voteDetails').innerHTML = details;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('voteDetails').innerHTML = '<div class="alert alert-danger">Error al cargar los detalles del voto</div>';
                });
        }
    </script>
</body>
</html>
