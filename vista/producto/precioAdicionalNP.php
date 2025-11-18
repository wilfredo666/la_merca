<!-- Modal completo e independiente para precios adicionales de producto nuevo -->
<div class="modal fade" id="modalPreciosNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="modalPreciosNuevoProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalPreciosNuevoProductoLabel">
          <i class="fas fa-tags"></i> Precios Adicionales para Producto Nuevo
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <!-- Formulario para agregar nuevo precio -->
        <form id="formPreciosAdicionalesNP">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="conceptoNP">Concepto</label>
              <input type="text" class="form-control" name="concepto" id="conceptoNP" placeholder="Ej. Mayorista">
            </div>
            <div class="form-group col-md-4">
              <label for="precioAdicionalNP">Precio</label>
              <input type="number" class="form-control" name="precioAdicional" id="precioAdicionalNP" placeholder="0.00">
            </div>
            <div class="form-group col-md-2">
              <label for="estadoNP">Estado</label>
              <select class="form-control" name="estado" id="estadoNP">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>
        </form>

        <!-- Tabla de precios existentes -->
        <table class="table table-sm table-bordered">
          <thead class="thead-light">
            <tr>
              <th>Concepto</th>
              <th>Precio</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaPreciosProductoNP">
            <!-- Se llena dinámicamente con JS -->
          </tbody>
        </table>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="agregarPrecioAdicionalNP()">Agregar</button>
      </div>
    </div>
  </div>
</div>

<style>
/* Estilos específicos para el modal de precios adicionales */
#modalPreciosNuevoProducto .modal-dialog {
  max-width: 900px;
}

#modalPreciosNuevoProducto .card-outline.card-info {
  border: 1px solid #17a2b8;
}

#modalPreciosNuevoProducto .badge-primary {
  background-color: #007bff;
}

#modalPreciosNuevoProducto .alert-info {
  border-left: 4px solid #17a2b8;
}
</style>