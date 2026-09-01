<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Área de Apoyo - Valoraciones</title>

    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar / Encabezado superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success py-3 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <i class="bi bi-shield-check fs-4"></i> Bienestar Aprendiz
            </a>

            <div class="d-flex align-items-center gap-3">
                <span class="text-white d-flex align-items-center gap-2 bg-white bg-opacity-25 px-3 py-1 rounded-pill">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->nombre ?? Auth::user()->name ?? 'Profesional de Apoyo' }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container-fluid px-4 my-4">

        <!-- Mensajes de Alerta/Éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Banner de Bienvenida -->
        <div class="bg-dark text-white rounded-3 p-4 mb-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Módulo de Atención y Valoración</h3>
                <p class="text-secondary mb-0">Registra y realiza el seguimiento a los aprendices en el área de bienestar institucional.</p>
            </div>
            <div>
                <a href="{{ route('comite.inicio') }}" class="btn btn-light fw-bold px-4 py-2 shadow-sm text-dark">
                    <i class="bi bi-table me-2 text-success"></i> Ver Mis Valoraciones
                </a>
            </div>
        </div>

        <div class="row justify-content-center">

            <!-- Formulario de Registro de Valoración -->
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm rounded-3">

                    <div class="card-header bg-success text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="bi bi-clipboard-plus-fill"></i> Registrar Nueva Valoración
                        </h5>
                        <span class="badge bg-white text-success fw-semibold px-3 py-2 rounded-pill">Formulario de Ingreso</span>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('valoracion.historial.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nombre Aprendiz -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nombre Completo del Aprendiz</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="nombre_aprendiz" placeholder="Ingrese el nombre completo del aprendiz" value="{{ old('nombre_aprendiz') }}" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <!-- Ficha -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ficha de Formación</label>
                                    <select class="form-select" name="ficha" required>
                                        <option value="">-- Seleccione la Ficha --</option>
                                        @foreach ($fichas as $ficha)
                                            <option value="{{ $ficha->ficha }}">Ficha: {{ $ficha->ficha }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Área de Apoyo -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Área de Apoyo / Remisión</label>
                                    <select class="form-select" name="nombre_area" required>
                                        <option value="">-- Seleccione el Área --</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->idarea }}">{{ $area->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <!-- Apoyo Institucional -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Apoyo Institucional</label>
                                    <select class="form-select" name="idapoyoinstitucional" required>
                                        <option value="">-- Seleccione el Apoyo --</option>
                                        @foreach ($apoyos as $apoyo)
                                            <option value="{{ $apoyo->idapoyoinstitucional }}">
                                                {{ $apoyo->nombre ?? $apoyo->nombre_apoyo ?? 'Apoyo Disponible' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Fecha -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha de Atención</label>
                                    <input type="date" class="form-control" name="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <!-- Archivo de Seguimiento -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Adjuntar Archivo de Seguimiento del Aprendiz</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-file-earmark-arrow-up"></i></span>
                                    <input type="file" class="form-control" name="archivo_seguimiento" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                                </div>
                                <div class="form-text">Formatos permitidos: PDF, Word (DOC/DOCX) o Imágenes (PNG/JPG).</div>
                            </div>

                            <!-- Botón de Envío -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm text-uppercase">
                                    <i class="bi bi-save2 me-2"></i> Guardar Valoración
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>