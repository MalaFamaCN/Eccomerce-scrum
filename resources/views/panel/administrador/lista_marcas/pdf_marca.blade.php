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
    <h3 class="text-center"> Marca de {{ auth()->user()->name }}</h3>
    <table class="table table-striped w-100">
        <thead class="bg-primary text-center text-white">
            <tr>
                <th scope="col" class="text-uppercase">Descripcion</th>
             
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($marcas as $marca)
                <tr>
                    <td>{{ $marca->descripcion }}</td>
                    
                    
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
