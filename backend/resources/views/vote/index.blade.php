<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Votación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Formulario de Votación</h4>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('vote.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="document" class="form-label">Número de Cédula</label>
                                <input type="text" 
                                       class="form-control @error('document') is-invalid @enderror" 
                                       id="document" 
                                       name="document" 
                                       value="{{ old('document') }}" 
                                       required>
                                @error('document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="candidate_id" class="form-label">Candidato</label>
                                <select class="form-select @error('candidate_id') is-invalid @enderror" 
                                        id="candidate_id" 
                                        name="candidate_id" 
                                        required>
                                    <option value="">Seleccione un candidato</option>
                                    @foreach($candidates as $candidate)
                                        <option value="{{ $candidate->id }}" {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>
                                            {{ $candidate->name }} {{ $candidate->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('candidate_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Votar</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="d-grid">
                            <a href="{{ route('login') }}" class="btn btn-secondary">Gestionar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 