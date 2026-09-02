<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Valoración - Área de Apoyo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success py-3 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <i class="bi bi-shield-check fs-4"></i> Bienestar Aprendiz - Editar Registro
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('valoracion.historial.index') }}" class="btn btn-light text-success fw-bold btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Historial
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Modificar Valoración de Acompañamiento</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('valoracion.update', $valoracion->idProcesoaconmpaniamento) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre_aprendiz" class="form-label fw-bold">Nombre del Aprendiz</label>
                        <input type="text" class="form-control" id="nombre_aprendiz" name="nombre_aprendiz" value="{{ old('nombre_aprendiz', $valoracion->nombre_aprendiz) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ficha" class="form-label fw-bold">Ficha</label>
                        <select class="form-select" id="ficha" name="ficha" required>
                            <option value="">Seleccione una ficha</option>
                            @foreach($fichas as $f)
                                <option value="{{ $f->ficha }}" {{ $valoracion->ficha == $f->ficha ? 'selected' : '' }}>{{ $f->ficha }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_area" class="form-label fw-bold">Área</label>
                        <select class="form-select" id="nombre_area" name="nombre_area" required>
                            <option value="">Seleccione un área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->idarea }}" {{ $valoracion->idarea == $area->idarea ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idapoyoinstitucional" class="form-label fw-bold">Apoyo Institucional</label>
                        <select class="form-select" id="idapoyoinstitucional" name="idapoyoinstitucional" required>
                            <option value="">Seleccione apoyo</option>
                            @foreach($apoyos as $apoyo)
                                <option value="{{ $apoyo->idapoyoinstitucional }}" {{ $valoracion->idapoyoinstitucional == $apoyo->idapoyoinstitucional ? 'selected' : '' }}>{{ $apoyo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label fw-bold">Fecha de Atención</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ date('Y-m-d', strtotime($valoracion->fecha_inicio)) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="archivo_seguimiento" class="form-label fw-bold">Actualizar Archivo de Seguimiento (Opcional)</label>
                        <input type="file" class="form-control" id="archivo_seguimiento" name="archivo_seguimiento">
                        @if(!empty($valoracion->archivo))
                            <small class="text-muted mt-1 d-block">Ya cuenta con un archivo cargado previamente.</small>
                        @endif
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Actualizar Valoración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>