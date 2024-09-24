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
    <h3 class="text-center"> Proveedor de {{ auth()->user()->name }}</h3>
    <table class="table table-striped w-100">
        <thead class="bg-primary text-center text-white">
            <tr>
                <th scope="col" class="text-uppercase">Nombre</th>
                <th scope="col" class="text-uppercase">Cuit</th>
                <th scope="col" class="text-uppercase">Razon Social</th>
                <th scope="col" class="text-uppercase">Direccion</th>
                <th scope="col" class="text-uppercase">Telefono</th>
                <th scope="col" class="text-uppercase">Email</th>
                
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($proveedor as $proveedorr)
                <tr>
                    <td>{{ $proveedorr->descripcion }}</td>
                    <td>{{ $proveedorr->cuit}}</td>
                    <td>{{ $proveedorr->razon_social}}</td>
                    <td>{{ $proveedorr->direccion}}</td>
                    <td>{{ $proveedorr->telefono}}</td>
                    <td>{{ $proveedorr->correo}}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
