<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Aprendices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-white">

    <div class="text-center mb-4 pb-2 border-bottom border-2 border-success">
        <h2 class="fw-bold text-success text-uppercase m-0">Centro de Formación SENA</h2>
        <p class="fw-bold text-secondary mb-1">Reporte de Acompañamiento de Aprendices</p>
        <p class="text-muted small m-0">Instructor a cargo: {{ Auth::user()->name }} | Fecha: {{ date('d/m/Y') }}</p>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success text-center">
            <tr>
                <th>Aprendiz</th>
                <th>Ficha</th>
                <th>Área</th>
                <th>Fecha Inicio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aprendices as $a)
            <tr>
                <td>{{ $a->nombre }} {{ $a->apellido }}</td>
                <td class="text-center">{{ $a->ficha }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($a->fecha_activacion)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No hay aprendices asignados a tu usuario.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>