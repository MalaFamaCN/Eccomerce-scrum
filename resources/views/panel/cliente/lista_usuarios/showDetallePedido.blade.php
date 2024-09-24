<div class="modal fade" id="showDetallePedidoModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable container" role="document" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detalles del Pedido: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Contenido del modal --}}
                <div class="d-flex justify-content-between px-3">
                <h4 class="text-info"><strong>N° de Pedido:</strong> <span id="modal-num-pedido"></span></h4>
                <h4 class="text-info">Estado del Pedido: <span id="estadoPedido"></span>
                    
                </h4>
                </div>
                <div class="d-flex justify-content-between px-3">
                    <span>
                    <h5><strong>Nombre:</strong> <span id="modal-nombre"></span></h5>
                    <h5><strong>Apellido:</strong> <span id="modal-apellido"></span></h5>
                    <h5><strong>DNI:</strong> <span id="modal-dni"></span></h5>
                    <h5><strong>Dirección:</strong> <span id="modal-direccion"></span></h5>
                    </span>
                    <span>
                    <h5><strong>Codigo Postal:</strong> <span id="modal-codigopostal"></span></h5>
                    <h5><strong>E-mail:</strong> <span id="modal-email"></span></h5>
                    <h5><strong>Teléfono:</strong> <span id="modal-telefono"></span></h5>
                    <h5><strong>Total del pedido:</strong> $<span id="modal-total"></span></h5>
                    </span>
                </div>
            </div>
            <div class="modal-body">
            <table id="tabla_pedido" class="table shopping-summery table-striped text-center" style="width: 100%;">
                <thead class="table-dark">
                    <tr class="main-hading">
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody id="cart_item_list">
                    <td colspan="5" class="text-center">Cargando...</td>
                </tbody>
            </table>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <a href="" class="btn btn-danger" id="modal-urlfactura" target="_blank">  Factura  <i class="fas fa-file-pdf"> </i></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    
</div>

