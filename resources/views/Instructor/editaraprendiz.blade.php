<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aprendiz - SPRAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="mb-3">
                    <a href="{{ route('instructor.inicio') }}" class="btn btn-light border text-secondary fw-semibold rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-arrow-left"></i> Volver al Panel
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-3">
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 rounded-4 shadow-sm bg-white">
                    <div class="card-header bg-warning text-dark p-4 rounded-top-4 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; font-size: 1.5rem;">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold">Editar Aprendiz</h4>
                                <p class="mb-0 text-dark-50 small">Corrige los datos o el archivo asignado al aprendiz</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('aprendices.update', $aprendiz->idAprendiz) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-semibold text-dark small">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $aprendiz->nombre) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-semibold text-dark small">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $aprendiz->apellido) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="id_programa" class="form-label fw-semibold text-dark small">Programa de Formación</label>
                                    <select class="form-select" id="id_programa" name="id_programa" required>
                                        @foreach ($programas as $prog)
                                            <option value="{{ $prog->idPrograma_formacion }}" {{ old('id_programa', $aprendiz->id_programa) == $prog->idPrograma_formacion ? 'selected' : '' }}>
                                                {{ $prog->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="ficha" class="form-label fw-semibold text-dark small">Número de Ficha</label>
                                    <input type="text" class="form-control" id="ficha" name="ficha" value="{{ old('ficha', $aprendiz->ficha) }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="archivo" class="form-label fw-semibold text-dark small">Reemplazar Archivo Adjunto (Opcional)</label>
                                    <input type="file" class="form-control" id="archivo" name="archivo">
                                    @if($aprendiz->archivo)
                                        <small class="text-muted d-block mt-1">Archivo actual: <strong>{{ basename($aprendiz->archivo) }}</strong></small>
                                    @endif
                                </div>

                            </div>

                            <div class="mt-4 pt-2">
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-floppy-fill"></i> Actualizar Registro
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>