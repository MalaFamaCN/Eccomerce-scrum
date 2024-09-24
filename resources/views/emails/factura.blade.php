<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Document</title>

</head>
<body>

 <h2>Pago recibido con éxito</h2>
 <h3>Sus productos estan siendo preparados para luego enviarlos</h3>

 <p>Estimado/a {{ $user['name'] }} su pago fue recibido con éxito. </p>
 <p>El pedido con el N°{{ $user['num_pedido'] }}, esta siendo preparado por nuestro personal, puede consultar el estado del pedido desde su panel, en la seccion "Mis Compras".  </p>
 <p>Fecha de creación del pedido {{ $user['fecha'] }}.</p>
 <p>Fecha de recepcion del pago {{ $user['fecha_pago'] }}.</p>

 <footer style="font-size: small;
 color: #929292; "> Este correo fue generado automaticamente. No conteste este correo. </footer> 
</body>
</html>
