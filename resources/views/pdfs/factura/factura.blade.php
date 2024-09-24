<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura</title>
    <link rel="stylesheet" href="{{public_path('css/styleFactura.css')}}" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{public_path('css/logo.png')}}">
      </div>
      <h1>Factura de Compra</h1>
      <div id="company" class="clearfix">
        <div>FECHA FACTURA: {{$fechaActual->format('d/m/Y')}}</div>
        <div>ESMARTY ECOMMERCE</div>
        <div>ALVARADO 951<br /> SALTA 4400, ARG</div>
        <div>(54) 387-780450</div>
        <div><a href="mailto:esmartyecommerce@gmail.com">esmartyecommerce@gmail.com</a></div>
      </div>
      <div id="project">
        <div><span>PEDIDO N°: {{$pedido->num_pedido}}</span></div>
        <div><span>FECHA PEDIDO: {{$pedido->created_at->format('d/m/Y')}}</span></div>
        <div><span>CLIENTE: {{$pedido->nombre . " " . $pedido->apellido}}</span></div>
        <div><span>DNI: {{$pedido->dni}}</span></div>
        <div><span>DIRECCIÓN: {{$pedido->direccion}} CP: {{$pedido->codigo_postal}}</span></div>
        <div><span>EMAIL:<a href="mailto:{{$pedido->correo}}">{{$pedido->correo}}</a></span></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service"><b>CODIGO</b></th>
            <th class="desc"><b>PRODUCTO</b></th>
            <th><b>PRECIO</b></th>
            <th><b>CANTIDAD</b></th>
            <th><b>TOTAL</b></th>
          </tr>
        </thead>
        <tbody>
          @php
              $total = 0;
          @endphp
          @foreach($carrito as $item)
          <tr>
            <td class="service">{{$item->productos->codigo_producto}}</td>
            <td class="desc">{{$item->productos->nombre}}</td>
            <td class="unit">${{$item->subtotal}}</td>
            <td class="qty">{{$item->cant_producto}}</td>
            <td class="total">${{$item->cant_producto * $item->subtotal}}</td>
          </tr>

          @php($total += $item->cant_producto * $item->subtotal)
          @endforeach
          

          <tr>
            <td colspan="4" class="grand gran total"><B>TOTAL FACTURA:</B></td>
            <td class="grand total"><B>${{$total}}</B></td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>AVISOS:</div>
        <div class="notice">DOCUMENTO NO VALIDO COMO FACTURA</div>
      </div>
    </main>
    <footer>
      Gracias por comprar en Esmarty, donde tu compra es Smart! 
    </footer>
  </body>
</html>