<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Instructor - SPRAS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <!-- Navbar Institucional SENA -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3 mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 fs-4" href="#">
                <i class="bi bi-shield-check"></i> SPRAS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
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
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="btn btn-light btn-sm fw-bold text-success d-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i> Generar Reporte
                    </a>
                    
                    <form class="d-flex" role="search" action="#" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                            <input class="form-control border-0 shadow-none ps-0" type="search" placeholder="Buscar aprendiz..." style="width: 170px;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container-fluid px-4">

        <!-- Banner de Bienvenida -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white p-4 rounded-4 shadow-sm border d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success-subtle text-success p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-hand-index-thumb-fill fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">¡Hola de nuevo, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0 small">Sistema para la Prevención y Retención del Aprendiz SENA.</p>
                        </div>
                    </div>
                    <a href="{{ route('aprendices.create') }}" class="btn btn-success fw-bold rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-person-plus-fill"></i> Crear Aprendiz
                    </a>
                </div
            </div>
        </div>

        <div class="row">
            <!-- Listado de Aprendices -->
            <div class="col-lg-8 col-xl-9 mb-4">
                <div class="card border-0 rounded-4 shadow-sm bg-white">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0 text-success">Mis Aprendices Asignados</h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Total: {{ count($aprendices) }}</span>
                    </div>
                    
                    <div class="card-body p-0 mt-2">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-uppercase text-secondary small">
                                    <tr>
                                        <th class="ps-4 py-3">Aprendiz</th>
                                        <th class="py-3">Apellido</th>
                                        <th class="py-3">Ficha / Programa</th>
                                        <th class="text-end pe-4 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($aprendices as $aprendiz)
                                        <tr>
                                            <td class="ps-4 fw-semibold text-dark">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                                        {{ strtoupper(substr($aprendiz->nombre, 0, 1)) }}
                                                    </div>
                                                    {{ $aprendiz->nombre }}
                                                </div>
                                            </td>
                                            <td class="text-secondary">{{ $aprendiz->apellido }}</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3">
                                                    <i class="bi bi-hash"></i>{{ $aprendiz->ficha }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-light border text-secondary rounded-2"><i class="bi bi-three-dots-vertical"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-5">
                                                <i class="bi bi-people display-6 d-block mb-2 text-secondary opacity-50"></i>
                                                No tienes aprendices asignados actualmente.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Perfil Instructor -->
            <div class="col-lg-4 col-xl-3 mb-4">
                <div class="card border-0 rounded-4 shadow-sm bg-white text-center p-3">
                    <div class="card-body">
                        
                        <!-- Avatar con icono por defecto -->
                        <div class="mx-auto bg-light text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm border border-2 border-white mb-3" style="width: 80px; height: 80px; font-size: 2.2rem;">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <h6 class="fw-bold mb-1 text-dark fs-5">{{ auth()->user()->name }} {{ auth()->user()->apellido ?? '' }}</h6>
                        <span class="badge bg-success px-3 py-2 rounded-pill mb-3">
                            {{ ucfirst(auth()->user()->role ?? 'Instructor SENA') }}
                        </span>

                        <hr class="my-3 opacity-25">

                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-light border btn-sm fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 rounded-3 text-secondary">
                                <i class="bi bi-journal-text"></i> Historial Aprendiz
                            </a>
                            
                            <form action="{{ route('logout') }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold py-2 w-100 d-flex align-items-center justify-content-center gap-2 rounded-3 mt-1">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>