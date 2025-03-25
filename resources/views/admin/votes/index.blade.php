@extends('layouts.admin')

@section('title', 'Listado de Votos')

@section('content')
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
@endsection

@push('styles')
<style>
    .top-candidate {
        background-color: #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function loadVoteDetails(voteId) {
        fetch(`/admin/votes/${voteId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
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
                document.getElementById('voteDetails').innerHTML = `
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">Error al cargar los detalles</h6>
                        <p class="mb-0">No se pudo cargar la información del voto. Por favor, intente nuevamente.</p>
                    </div>
                `;
            });
    }
</script>
@endpush
