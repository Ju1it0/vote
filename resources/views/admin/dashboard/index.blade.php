@extends('layouts.admin')

@section('title', 'Candidatos más votados')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white">
        <h4 class="mb-0">Candidatos más votados</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCandidates as $index => $candidate)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $candidate->name }} {{ $candidate->lastname }}</td>
                            <td>{{ $candidate->document }}</td>
                            <td>{{ $candidate->vote_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay candidatos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $topCandidates->links() }}
        </div>
    </div>
</div>
@endsection 