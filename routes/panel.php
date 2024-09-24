<?php


use App\Exports\HistorialStockExport;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetodoDePagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrecioController;

use App\Http\Controllers\VentaController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Test\PreConditionFinished;
//Rutas del panel para editar perfil
Route::middleware(['verified'])->group(function () {
	Route::get('/usuario/editar', [ClienteController::class, 'editar'])->name('cliente.editar');
	Route::put('/usuario/actualizar/{cliente}', [ClienteController::class, 'actualizar'])->name('cliente.actualizar');
});

//Rutas del panel del cliente
Route::middleware(['cliente', 'verified'])->group(function () {
	//Rutas del perfil del cliente 
	Route::resource('/cliente', ClienteController::class)->names('cliente');
	Route::resource('/pedidos', PedidoController::class)->names('pedidos');
	Route::post('/pedidos/cancelarPedido/{pedido}', [PedidoController::class, 'cancelarPedido'])->name('pedidos.cancelarPedido');
});

//Ruta para ver detalles del pedido
Route::get('/pedidos/itemsPedido/{pedido}', [PedidoController::class, 'itemsPedido'])->middleware(['verified'])->name('pedidos.itemsPedido');

//Rutas del panel del almacen
Route::middleware(['almacen', 'verified'])->group(function () {
	//Rutas de los CRUD basicos
	Route::resource('/proveedores', ProveedorController::class)->names('proveedor');
	//Rutas del stock
	Route::resource('/stock', StockController::class)->names('stock');
	Route::get('/historico-stock', [StockController::class, 'historicoVista'])->name('stock.historico');
	Route::get('/showDetalle', [StockController::class, 'showDetalle'])->name('stock.showDetalle');
	//Rutas para preparar pedidos
	Route::get('/preparacion', [PedidoController::class, 'pedidosPagados'])->name('pedidosPagados');
	Route::get('/enviados', [PedidoController::class, 'pedidosEnviados'])->name('pedidosEnviados');
	Route::get('/preparar-pedido/{id}', [PedidoController::class, 'prepararPedido'])->name('prepararPedido');
	Route::post('/guardar-numero/{id}', [PedidoController::class, 'guardarNumero'])->name('guardarNumero');

	Route::get('exportar-historial-excel', [StockController::class, 'exportarHistorialExcel'])->name('exportar-historial-excel');
	Route::get('exportar-historial-pdf', [StockController::class, 'exportarHistorialPDF'])->name('exportar-historial-pdf');
	Route::get('exportar-proveedor-excel', [ProveedorController::class, 'exportarProveedorExcel'])->name('exportar-proveedor-excel');
	Route::get('exportar-proveedor-pdf', [ProveedorController::class, 'exportarProveedorPDF'])->name('exportar-proveedor-pdf');
	Route::get('exportar-stock-excel', [StockController::class, 'exportarStockExcel'])->name('exportar-stock-excel');
	Route::get('exportar-stock-pdf', [StockController::class, 'exportarStockPDF'])->name('exportar-stock-pdf');
});

//Rutas del panel del vendedor
Route::middleware(['vendedor', 'verified'])->group(function () {
	//Rutas de los CRUD basicos
	Route::resource('/productos', ProductoController::class)->names('producto');
	Route::resource('/marcas', MarcaController::class)->names('marca');
	Route::resource('/categorias', CategoriaController::class)->names('categoria');
	Route::get('/actualizarPrecio', [PrecioController::class, ''])->name('stock.showDetalle');
	Route::resource('/precios', PrecioController::class)->names('precio');
	Route::post('/precios/actualizar-lote', [PrecioController::class, 'updateProveedor'])->name('precio.actualizarProveedor');
	Route::post('/precios/actualizar2-lote', [PrecioController::class, 'updateCategoria'])->name('precio.actualizarCategoria');
	Route::post('/precios/actualizar3-lote', [PrecioController::class, 'updateMarca'])->name('precio.actualizarMarca');
	Route::get('exportar-precios-excel', [PrecioController::class, 'exportarPreciosExcel'])->name('exportar-precios-excel');
	Route::get('exportar-precios-pdf', [PrecioController::class, 'exportarPreciosPDF'])->name('exportar-precios-pdf');
	Route::get('exportar-productos-excel', [ProductoController::class, 'exportarProductosExcel'])->name('exportar-productos-excel');
	Route::get('exportar-productos-pdf', [ProductoController::class, 'exportarProductosPDF'])->name('exportar-productos-pdf');
	Route::get('exportar-marca-excel', [MarcaController::class, 'exportarMarcaExcel'])->name('exportar-marca-excel');
	Route::get('exportar-marca-pdf', [MarcaController::class, 'exportarMarcaPDF'])->name('exportar-marca-pdf');
	Route::get('exportar-categoria-excel', [CategoriaController::class, 'exportarCategoriaExcel'])->name('exportar-categoria-excel');
	Route::get('exportar-categoria-pdf', [CategoriaController::class, 'exportarCategoriaPDF'])->name('exportar-categoria-pdf');
});


//Rutas del panel del cajero
Route::middleware(['cajero', 'verified'])->group(function () {
	//Rutas de las cajas
	Route::get('/ventas', [VentaController::class, 'index'])->name('venta.index');
	Route::get('/ventas/venta-diaria', [VentaController::class, 'ventasDiarias'])->name('venta.ventasDiarias');
	Route::get('/ventas/exportarExcel', [VentaController::class, 'exportarExcel'])->name('venta.exportarExcel');
	Route::get('/ventas/venta-mensual', [VentaController::class, 'ventasMensuales'])->name('venta.ventasMensuales');
});

//Rutas del panel del admin 
Route::middleware(['admin', 'verified'])->group(function () {
	Route::resource('/metodosdepago', MetodoDePagoController::class)->names('metodosdepago');
	Route::resource('/users', UserController::class)->names('user');
	Route::get('/home', [ProductoController::class, 'graficosProductosxCategoria'])->name('graficos-productos');
	Route::post('exportar-graficos-pdf', [ProductoController::class, 'exportarGraficosPDF'])->name('exportar-graficos-pdf');
});

Route::get('/', function () {
	return view('panel.index');
})->middleware(['verified','redirigir'])->name('Welcome');


/* Route::get('/', function () {
	redirect()->away('/');
})->middleware(['verified'])->name('pagina'); */