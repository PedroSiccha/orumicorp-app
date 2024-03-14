<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Reporte de Asistencias</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha de Asistencia</th>
                <th>Nombre del Agente</th>
                <th>Hora de Ingreso</th>
                <th>Hora de Break</th>
                <th>Vuelta de Break</th>
                <th>Hora de Salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assistances as $assistance)
                <tr>
                    <td>{{ $assistance->date }}</td>
                    <td>{{ $assistance->name }} {{ $assistance->lastname }}</td>
                    <td>{{ $assistance->IN }}</td>
                    <td>{{ $assistance->INBREAK }}</td>
                    <td>{{ $assistance->OUTBREAK }}</td>
                    <td>{{ $assistance->OUT }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
