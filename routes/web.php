<?php

use App\Mail\RegisterMailable;
use App\Models\DetallePedidos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaDeInicio;

//A la tienda solo pueden acceder los clientes
Route::middleware(['cliente'])->group(function () { //Todas estas rutas solo son accedibles por los clientes, si no es cliente, no puede entrar aqui
    Route::get('/', [PaginaDeInicio::class, 'MandarDatosPaginaInicio'])->name('MandarDatosPaginaInicio');
    Route::get('productos', [PaginaDeInicio::class, 'MandarDatosLista'])->name('productos');
    Route::get('productos/categoria/{categoria}', [PaginaDeInicio::class, 'MandarDatosCategoriaEspecifica'])->name('MandarDatosCategoriaEspecifica');
    Route::get('productos/detallesProducto/{producto}', [PaginaDeInicio::class, 'MandarDatosProductoEspecifico'])->name('MandarDatosProductoEspecifico');
    Route::get('productos/filtroPrecio', [PaginaDeInicio::class, 'filtrarPorPrecio'])->name('filtrarPorPrecio');
    Route::get('/resultados', [PaginaDeInicio::class, 'resultadosBusqueda'])->name('resultados-busqueda');

    //Rutas para el carrito de compras
    Route::get('/carritoCantidadItems', [App\Http\Controllers\DetallePedidosController::class, 'contarItemsCarrito'])->name('carrito.contarItemsCarrito');

    Route::get('/carrito', [App\Http\Controllers\DetallePedidosController::class, 'index'])->name('carrito.carrito');
    Route::get('/miCarrito', [App\Http\Controllers\DetallePedidosController::class, 'miCarrito'])->name('carrito.miCarrito');
    Route::get('/agregarProductos', [App\Http\Controllers\DetallePedidosController::class, 'testProductos'])->name('carrito.agregarProductos');
    Route::post('/miCarrito/quitarItem', [App\Http\Controllers\DetallePedidosController::class, 'quitarItem'])->name('carrito.quitarItem');
    Route::post('/miCarrito/actualizarCantidad', [App\Http\Controllers\DetallePedidosController::class, 'actualizarCantidad'])->name('carrito.actualizarCantidad');
    Route::post('/miCarrito/agregarAlCarrito', [App\Http\Controllers\DetallePedidosController::class, 'agregarAlCarrito'])->name('carrito.agregarAlCarrito');

    //Rutas para generar y pagar el pedido
    Route::post('/carrito/checkout', [App\Http\Controllers\PedidoController::class, 'checkout'])->name('carrito.checkout');
    Route::get('/carrito/checkout', [App\Http\Controllers\PedidoController::class, 'create'])->name('carrito.create');
    Route::any('/carrito/guardar', [App\Http\Controllers\PedidoController::class, 'store'])->name('pedido.store');
    Route::any('/pedido/pago', [App\Http\Controllers\PedidoController::class, 'pago'])->name('pedido.pago');
});


Auth::routes(
    ['verify' => true]
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['admin','verified'])->name('home');


Route::middleware(['verified'])->group(function () {
//Rutas para los switchs de los crud
Route::post('/categorias/cambiarEstado', [App\Http\Controllers\CategoriaController::class, 'cambiarEstado'])->name('cambiar.estado.categoria');
Route::post('/proveedores/cambiarEstado', [App\Http\Controllers\ProveedorController::class, 'cambiarEstado'])->name('cambiar.estado.proveedor');
Route::post('/productos/cambiarEstado', [App\Http\Controllers\ProductoController::class, 'cambiarEstado'])->name('cambiar.estado.producto');
Route::post('/marcas/cambiarEstado', [App\Http\Controllers\MarcaController::class, 'cambiarEstado'])->name('cambiar.estado.marcas');
Route::post('/metodosdepago/cambiarEstado', [App\Http\Controllers\MetodoDePagoController::class, 'cambiarEstado'])->name('cambiar.estado.metodosdepago');
Route::post('/users/cambiarEstado', [App\Http\Controllers\UserController::class, 'cambiarEstado'])->name('cambiar.estado.users');
});

