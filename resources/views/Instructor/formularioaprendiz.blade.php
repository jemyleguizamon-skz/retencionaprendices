<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Aprendiz - SPRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="mb-3">
                    <a href="{{ route('login') }}" class="btn btn-light border text-secondary fw-semibold rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-arrow-left"></i> Volver al Panel
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-4 border-0 shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                            <strong class="text-danger">Por favor corrige los siguientes errores:</strong>
                        </div>
                        <ul class="mb-0 ps-4 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 rounded-4 shadow-sm bg-white">
                    <div class="card-header bg-success text-white p-4 rounded-top-4 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; font-size: 1.5rem;">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">Registrar Aprendiz en Ficha</h4>
                                <p class="mb-0 text-white-50 small">Ingresa la información institucional requerida</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('aprendices.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="id_programa" class="form-label fw-semibold text-dark small">Programa de Formación</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-journal-bookmark"></i></span>
                                        <select class="form-select border-start-0 ps-0 shadow-none" id="id_programa" name="id_programa" required>
                                            <option value="">-- Seleccione el Programa --</option>
                                            @foreach ($programas as $prog)
                                                <option value="{{ $prog->idPrograma_formacion }}" {{ old('id_programa') == $prog->idPrograma_formacion ? 'selected' : '' }}>
                                                    {{ $prog->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="id_instructor" class="form-label fw-semibold text-dark small">Instructor Responsable</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                                        <select name="id_instructor" id="id_instructor" class="form-select border-start-0 ps-0 shadow-none" required>
                                            <option value="">-- Seleccione el Instructor --</option>
                                            @foreach($instructores as $instructor)
                                                <option value="{{ $instructor->idInstructor }}" {{ old('id_instructor') == $instructor->idInstructor ? 'selected' : '' }}>
                                                    {{ $instructor->nombre }} {{ $instructor->apellido }} (Doc: {{ $instructor->documento }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-semibold text-dark small">Nombre del Aprendiz</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0 shadow-none" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ingrese nombres">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-semibold text-dark small">Apellido del Aprendiz</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0 shadow-none" id="apellido" name="apellido" value="{{ old('apellido') }}" required placeholder="Ingrese apellidos">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="ficha" class="form-label fw-semibold text-dark small">Número de Ficha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-hash"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0 shadow-none" id="ficha" name="ficha" value="{{ old('ficha') }}" required placeholder="Ej. 2558912">
                                    </div>
                                </div>

                            </div>

                            <div class="mt-4 pt-2">
                                <button type="submit" class="btn btn-success w-100 fw-bold py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-floppy-fill"></i> Guardar Registro
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>