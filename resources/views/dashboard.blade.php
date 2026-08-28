<!-- 1. TABLA DE APRENDICES -->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="table-success text-success fw-bold">
                <tr>
                    <th class="ps-4">Nombre</th>
                    <th>Apellido</th>
                    <th class="pe-4">Ficha</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @forelse ($aprendices as $aprendiz)
                    <tr>
                        <td class="ps-4">{{ $aprendiz->nombre }}</td>
                        <td>{{ $aprendiz->apellido }}</td>
                        <td class="pe-4">
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                {{ $aprendiz->ficha }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            No tienes aprendices asignados en este momento.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 2. TARJETA LATERAL (SESIÓN ACTIVA) -->
<!-- Esta parte va dentro de la columna derecha (<div class="col-lg-3 col-md-4 mb-4">) -->
<div class="card shadow-sm border-0 border-top border-success border-4 text-center">
    <div class="card-body pt-4">
        <div class="mb-3">
            <img class="rounded-circle border p-1 border-success-subtle" src="{{ asset('img/usuario.png') }}" alt="User Image" style="width: 90px; height: 90px; object-fit: cover;">
        </div>
        
        <p class="text-muted small mb-1 fw-bold text-uppercase tracking-wider">Sesión Activa</p>
        
        <!-- Nombre y Apellido -->
        <div class="px-2 py-2 bg-light rounded border border-success-subtle mb-3">
            <p class="m-0 fw-bold text-dark small">
                {{ auth()->user()->nombre }} {{ auth()->user()->apellido ?? '' }}
            </p>
        </div>

        <!-- Rol -->
        <span class="badge bg-success px-3 py-2 mb-3">
            {{ ucfirst(auth()->user()->rol ?? 'Instructor') }}
        </span>
        
        <div class="d-grid gap-2">
            <a href="#" class="btn btn-outline-success btn-sm fw-bold">Historial Aprendiz</a>
            
            <!-- Formulario para Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm fw-bold w-100">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>