<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - SPRAS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <div class="container my-5 d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        
        <div class="card border-0 rounded-4 shadow-sm bg-white" style="max-width: 520px; width: 100%;">
            
            <!-- Header Institucional -->
            <div class="card-header bg-success text-white text-center py-4 rounded-top-4 border-0">
                <div class="bg-white text-success rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <h4 class="m-0 fw-bold">Registro de Usuario</h4>
                <p class="mb-0 text-white-50 small">Crea una cuenta en el sistema SPRAS</p>
            </div>

            <div class="card-body p-4 p-md-5">

                <!-- Alertas de Errores Generales -->
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i>
                            <strong class="text-danger small">Por favor corrige los campos indicados:</strong>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Nombre y Apellido en 2 Columnas -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small mb-1">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 shadow-none @error('nombre') is-invalid @enderror" 
                                    name="nombre" value="{{ old('nombre') }}" required placeholder="Tu nombre">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small mb-1">Apellido</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0 shadow-none @error('apellido') is-invalid @enderror" 
                                    name="apellido" value="{{ old('apellido') }}" required placeholder="Tu apellido">
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Documento -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small mb-1">Documento de Identidad</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 shadow-none @error('documento') is-invalid @enderror" 
                                name="documento" value="{{ old('documento') }}" required placeholder="Número de documento">
                            @error('documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small mb-1">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 shadow-none @error('contrasena') is-invalid @enderror" 
                                name="contrasena" required placeholder="Crea una contraseña">
                            @error('contrasena')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small mb-1">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 shadow-none" 
                                name="contrasena_confirmation" required placeholder="Repite tu contraseña">
                        </div>
                    </div>

                    <!-- Rol y Estado en 2 Columnas -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold text-dark small mb-1">Rol de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-briefcase"></i></span>
                                <select name="rol" class="form-select border-start-0 ps-0 shadow-none @error('rol') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    <option value="instructor" {{ old('rol') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                                    <option value="profesional" {{ old('rol') == 'profesional' ? 'selected' : '' }}>Área de apoyo</option>
                                    <option value="comite" {{ old('rol') == 'comite' ? 'selected' : '' }}>Comité académico</option>
                                </select>
                                @error('rol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold text-dark small mb-1">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-toggle-on"></i></span>
                                <select class="form-select border-start-0 ps-0 shadow-none @error('estado') is-invalid @enderror" name="estado" required>
                                    <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botón Enviar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-check-circle-fill"></i> Registrar Cuenta
                        </button>
                    </div>

                    <!-- Enlace a Login -->
                    <div class="text-center mt-4 pt-2">
                        <a href="{{ route('login') }}" class="text-success text-decoration-none small fw-semibold d-inline-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left-short fs-5"></i> ¿Ya tienes cuenta? Inicia sesión
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>