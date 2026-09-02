<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Valoraciones - Área de Apoyo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success py-3 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <i class="bi bi-shield-check fs-4"></i> Bienestar Aprendiz
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('area_apoyo.inicio') }}" class="btn btn-light text-success fw-bold btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Registro
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 my-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-success text-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-journal-text me-2"></i> Mis Valoraciones Registradas</h5>
                
                <!-- Formulario de Búsqueda sin JavaScript -->
                <form method="GET" action="{{ route('valoracion.historial.index') }}" class="d-flex align-items-center gap-2 m-0">
                    <div class="input-group input-group-sm bg-white rounded overflow-hidden">
                        <input type="text" name="buscar" class="form-control border-0 shadow-none" placeholder="Buscar por aprendiz..." value="{{ request('buscar') }}">
                        <button class="btn btn-light text-success border-0 px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('buscar'))
                            <a href="{{ route('valoracion.historial.index') }}" class="btn btn-light text-danger border-0 px-2" title="Limpiar búsqueda">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                    <span class="badge bg-white text-success fw-bold px-3 py-2">{{ count($valoraciones) }} Registros</span>
                </form>
            </div>
            
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Aprendiz</th>
                                <th>Ficha</th>
                                <th>Área</th>
                                <th>Apoyo Institucional</th>
                                <th>Fecha Atención</th>
                                <th>Seguimiento (Archivo)</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($valoraciones as $val)
                                <tr>
                                    <td class="fw-bold">{{ $val->nombre_aprendiz }}</td>
                                    <td><span class="badge bg-secondary"># {{ $val->ficha }}</span></td>
                                    <td>{{ $val->area_nombre }}</td>
                                    <td>{{ $val->apoyo_nombre ?? 'N/A' }}</td>
                                    <td>{{ $val->fecha_inicio }}</td>
                                    <td>
                                        @if(!empty($val->archivo))
                                            <a href="{{ asset('storage/' . $val->archivo) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-file-earmark-arrow-down-fill"></i> Ver Documento
                                            </a>
                                        @else
                                            <span class="text-muted small">Sin archivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('valoracion.edit', $val->idProcesoaconmpaniamento) }}" class="btn btn-sm btn-primary" title="Editar valoración">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No se encontraron registros coincidentes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>