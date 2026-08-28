<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SPRAS SENA</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center">

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 bg-dark bg-gradient text-white p-5 d-none d-lg-flex flex-column justify-content-between position-relative">
                            <div>
                                <div class="mb-4">
                                    <span class="badge bg-success text-uppercase px-3 py-2 rounded-pill fw-bold">Sistema Institucional</span>
                                </div>
                                <h2 class="fw-bold display-6 mb-3">SPRAS</h2>
                                <p class="text-white-50 fs-6">Sistema para la Prevención y Retención del Aprendiz SENA.</p>
                            </div>

                            <div class="my-4 text-center d-flex justify-content-center">
                                <div class="bg-white p-3 rounded-4 shadow-sm d-inline-flex align-items-center justify-content-center" style="width: 110px; height: 110px;">
                                <img src="{{ asset('Logosena.jpg') }}" alt="Logo SENA" class="img-fluid object-fit-contain" style="max-height: 80px;">
                                </div>
                            </div>

                            <div class="border-top border-secondary border-opacity-50 pt-3">
                                <p class="small text-white-50 mb-0">
                                    <i class="bi bi-shield-check me-1 text-success"></i> Acceso seguro para instructores, profesionales y comités.
                                </p>
                            </div>
                        </div>

                        <!-- Columna Derecha: Formulario de Login -->
                        <div class="col-lg-7 p-4 p-md-5 bg-white">
                            
                            <!-- Header Móvil del Logo -->
                            <div class="d-lg-none text-center mb-4">
                                <span class="badge bg-success text-uppercase px-3 py-2 rounded-pill fw-bold mb-2">SPRAS SENA</span>
                                <h3 class="fw-bold text-dark">Iniciar Sesión</h3>
                            </div>

                            <div class="d-none d-lg-block mb-4">
                                <h3 class="fw-bold text-dark mb-1">Bienvenido de nuevo</h3>
                                <p class="text-muted small">Ingrese sus credenciales para acceder a la plataforma.</p>
                            </div>

                            <!-- Formulario Principal -->
                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <!-- Rol / Tipo de Usuario -->
                                <div class="mb-3">
                                    <label for="rol" class="form-label fw-semibold text-secondary small">TIPO DE USUARIO (ROL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-secondary border-success-subtle"><i class="bi bi-person-badge"></i></span>
                                        <select name="rol" id="rol" class="form-select border-success-subtle" required>
                                            <option value="" disabled selected>Seleccione su rol institucional...</option>
                                            <option value="instructor">Instructor</option>
                                            <option value="profesional">Área de apoyo</option>
                                            <option value="academico">Comité académico</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Documento de Identidad -->
                                <div class="mb-3">
                                    <label for="documento" class="form-label fw-semibold text-secondary small">DOCUMENTO DE IDENTIDAD</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-secondary border-success-subtle"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" class="form-control border-success-subtle" id="documento" name="documento" required placeholder="Número de documento">
                                    </div>
                                </div>
                                
                                <!-- Contraseña -->
                                <div class="mb-4">
                                    <label for="contrasena" class="form-label fw-semibold text-secondary small">CONTRASEÑA</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-secondary border-success-subtle"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control border-success-subtle" id="contrasena" name="contrasena" required placeholder="••••••••">
                                    </div>
                                </div>
                                
                                <!-- Botón de Enviar -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm" name="btn_enviar">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Ingresar a la Plataforma
                                    </button>
                                </div>
                                
                                <!-- Enlace de Registro -->
                                <div class="text-center pt-3 border-top">
                                    <span class="text-muted small">¿Aún no tienes una cuenta registrada?</span><br>
                                    <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none small">
                                        Regístrate aquí como nuevo usuario <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>