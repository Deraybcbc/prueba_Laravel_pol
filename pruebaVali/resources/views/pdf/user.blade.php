<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #3498db; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Información del Usuario</h1>
<p><strong>Nombre:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>

<h2>Roles</h2>
<table>
    <tr>
        <th>Datos del usuario</th>
    </tr>
    @foreach ($user->roles as $role)
        <tr>
            <td>{{ $role->address }}</td>
            <td>{{ $role->phone }}</td>
            <td>{{ $role->city }}</td>
            <td>{{ $role->type }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
