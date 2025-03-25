@extends('layouts.admin')

@section('title', 'Listado de Votantes')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Listado de Votantes</h4>
        <a href="{{ route('admin.voters.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Agregar Votante
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Tipo</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voters as $voter)
                        <tr>
                            <td>{{ $voter->document }}</td>
                            <td>{{ $voter->name }}</td>
                            <td>{{ $voter->lastname }}</td>
                            <td>
                                <span class="badge bg-{{ $voter->isCandidate ? 'success' : 'info' }}">
                                    {{ $voter->isCandidate ? 'Candidato' : 'Votante' }}
                                </span>
                            </td>
                            <td>{{ $voter->dob->format('d/m/Y') }}</td>
                            <td>{{ $voter->phone ?? 'No especificado' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.voters.edit', $voter) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.voters.destroy', $voter) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este votante?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay votantes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $voters->links() }}
        </div>
    </div>
</div>
@endsection 