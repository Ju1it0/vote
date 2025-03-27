@extends('layouts.admin')

@section('title', 'Crear Votante')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white">
        <h4 class="mb-0">Crear Votante</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.voters.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="document" class="form-label">Documento</label>
                    <input type="text" 
                           class="form-control @error('document') is-invalid @enderror" 
                           id="document" 
                           name="document" 
                           value="{{ old('document') }}" 
                           required>
                    @error('document')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="isCandidate" class="form-label">Tipo</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isCandidate" id="isVoter" value="0" {{ old('isCandidate', '0') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="isVoter">Votante</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isCandidate" id="isCandidate" value="1" {{ old('isCandidate') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="isCandidate">Candidato</label>
                    </div>
                    @error('isCandidate')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="lastname" class="form-label">Apellido</label>
                    <input type="text" 
                           class="form-control @error('lastname') is-invalid @enderror" 
                           id="lastname" 
                           name="lastname" 
                           value="{{ old('lastname') }}" 
                           required>
                    @error('lastname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="dob" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" 
                           class="form-control @error('dob') is-invalid @enderror" 
                           id="dob" 
                           name="dob" 
                           value="{{ old('dob') }}" 
                           required>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Sexo</label>
                    <select class="form-select @error('gender') is-invalid @enderror" 
                            id="gender" 
                            name="gender">
                        <option value="">Seleccione...</option>
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('gender') == 'O' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" 
                              name="address" 
                              rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.voters.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 