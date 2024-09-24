<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <title>Reporte PDF</title>
</head>

<body>
    <h3 class="text-center"> Productos de {{ auth()->user()->name }}</h3>
    <table class="table table-striped w-100">
        <thead class="bg-primary text-center text-white">
            <tr>
                <th scope="col" class="text-uppercase">Codigo</th>
                <th scope="col" class="text-uppercase">Nombre</th>
                <th scope="col" class="text-uppercase">Usuario</th>
                <th scope="col" class="text-uppercase">Tipo Modificacion</th>
                <th scope="col" class="text-uppercase">Cantidad</th>
                <th scope="col" class="text-uppercase">Fecha</th>
                
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($productoo as $producto)
                <tr>
                    <td>{{ $producto->codigo_producto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->email }}</td>
                    <td>{{ $producto->tipo_modif }}</td>
                    <td>{{ $producto->cantidad_modif }}</td>
                    <td>{{ $producto->created_at }}</td>
                    
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
