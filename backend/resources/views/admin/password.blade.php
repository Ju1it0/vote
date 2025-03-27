@extends('layouts.admin')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white">
        <h4 class="mb-0">Cambiar Contraseña</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST" id="passwordForm">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <input type="password" 
                       class="form-control @error('current_password') is-invalid @enderror" 
                       id="current_password" 
                       name="current_password" 
                       required>
                @error('current_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            </div>
        </form>
    </div>
</div>
@endsection 