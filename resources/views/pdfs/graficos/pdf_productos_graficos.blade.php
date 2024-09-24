<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <title>Reporte ChartJs</title>
</head>
<body>
    <div class="container-fluid">
        <img class="img-fluid" src="https://quickchart.io/chart?c={{ $data }}">
    </div>
</body>
</html>
