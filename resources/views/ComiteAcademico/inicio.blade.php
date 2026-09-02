<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento General - Bienestar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4 py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 fs-4" href="#">
                <i class="bi bi-shield-check"></i> SPRAS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center gap-1" href="{{ route('login') }}">
                            <i class="bi bi-house-door-fill"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" href="#">
                            <i class="bi bi-bell-fill"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled d-flex align-items-center gap-1" aria-disabled="true">
                            <i class="bi bi-calendar-event"></i> Calendario
                        </a>
                    </li>
                </ul>
                
                <!-- Formulario de Búsqueda Funcional -->
                <form class="d-flex" role="search" action="{{ route('comite.inicio') }}" method="GET">
                    <div class="input-group bg-white rounded overflow-hidden">
                        <span class="input-group-text bg-white border-0 text-muted ps-2"><i class="bi bi-search"></i></span>
                        <input class="form-control border-0 shadow-none ps-0" type="search" name="buscar" placeholder="Buscar aprendiz..." value="{{ request('buscar') }}" style="width: 170px;">
                        @if(request('buscar'))
                            <a href="{{ route('comite.inicio') }}" class="btn btn-link text-danger text-decoration-none d-flex align-items-center px-2" title="Limpiar">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container-fluid px-4">
        
        <div class="card border-0 rounded-4 shadow-sm bg-white mb-5">
            
            <!-- Encabezado de la Tarjeta -->
            <div class="card-header bg-success text-white fw-bold py-3 px-4 rounded-top-4 border-0 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center gap-2 fs-5">
                    <i class="bi bi-people-fill"></i> Seguimiento General de Aprendices Remitidos
                </span>
                <div class="d-flex gap-2">
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light text-success fw-bold rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm">
                            <i class="bi bi-arrow-left"></i> Volver a Registro
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Tabla de Datos -->
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover text-nowrap">
                    <thead class="table-light text-uppercase text-secondary small">
                        <tr>
                            <th class="ps-4 py-3">Aprendiz</th>
                            <th class="py-3">Ficha</th>
                            <th class="py-3">Área de Apoyo</th>
                            <th class="py-3">Profesional</th> 
                            <th class="py-3">Fecha</th>
                            <th class="pe-4 py-3">Seguimiento (Archivo)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($seguimientos as $fila)
                            <tr>
                                <td class="ps-4 fw-semibold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">
                                            {{ strtoupper(substr($fila->nombre_aprendiz ?? 'A', 0, 1)) }}
                                        </div>
                                        {{ $fila->nombre_aprendiz }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3">
                                        <i class="bi bi-hash"></i>{{ $fila->ficha }}
                                    </span>
                                </td>
                                <td class="text-secondary">{{ $fila->nombre_area ?? 'Sin área' }}</td>
                                <td class="text-secondary fw-medium">
                                    {{ $fila->nombre_profesional ?? 'Sin Profesional Asignado' }}
                                </td>
                                <td class="text-secondary">{{ $fila->fecha_inicio }}</td>
                                <td class="pe-4">
                                    @if(!empty($fila->archivo))
                                        <a href="{{ asset('storage/' . $fila->archivo) }}" target="_blank" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-file-earmark-arrow-down-fill"></i> Ver Documento
                                        </a>
                                    @else
                                        <span class="text-muted small">Sin archivo</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-folder-x display-6 d-block mb-2 text-secondary opacity-50"></i>
                                    No se encontraron registros de seguimiento actualmente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>