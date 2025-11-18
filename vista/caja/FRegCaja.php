<?php
session_start();
require_once "../../controlador/cajaControlador.php";
require_once "../../modelo/cajaModelo.php";
?>

<div class="modal-header">
  <h4 class="modal-title">Nuevo Movimiento de Caja</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">
  <form id="FormRegCaja">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="tipo">Tipo de Movimiento</label>
          <select class="form-control" id="tipo" name="tipo" required>
            <option value="">Seleccione...</option>
            <option value="ingreso">Ingreso</option>
            <option value="salida">Salida</option>
          </select>
        </div>
      </div>
      
      <div class="col-sm-6">
        <div class="form-group">
          <label for="cantidad">Cantidad (Bs.)</label>
          <input type="number" step="0.01" min="0.01" class="form-control" id="cantidad" name="cantidad" required>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="concepto">Concepto</label>
      <input type="text" class="form-control" id="concepto" name="concepto" maxlength="50" required>
      <small class="form-text text-muted">Máximo 50 caracteres</small>
    </div>

    <div class="form-group">
      <label for="descripcion">Descripción (Opcional)</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="200"></textarea>
      <small class="form-text text-muted">Máximo 200 caracteres</small>
    </div>

    <!-- Campos ocultos para el ID del usuario + id almacen (debe ser llenado desde la sesión) -->
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['idUsuario']; ?>">
    <input type="hidden" name="id_almacen" value="<?php echo $_SESSION['idAlmacen']; ?>">

  </form>
</div>

<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary" onclick="RegCaja()">Guardar</button>
</div>

<script>
  // Validación del formulario
  $("#FormRegCaja").validate({
    rules: {
      tipo: {
        required: true
      },
      concepto: {
        required: true,
        maxlength: 50
      },
      cantidad: {
        required: true,
        min: 0.01
      },
      descripcion: {
        maxlength: 200
      }
    },
    messages: {
      tipo: {
        required: "Seleccione el tipo de movimiento"
      },
      concepto: {
        required: "Ingrese el concepto",
        maxlength: "El concepto no puede exceder 50 caracteres"
      },
      cantidad: {
        required: "Ingrese la cantidad",
        min: "La cantidad debe ser mayor a 0"
      },
      descripcion: {
        maxlength: "La descripción no puede exceder 200 caracteres"
      }
    }
  });

  // Preview del tipo de movimiento
  $("#tipo").change(function(){
    var tipo = $(this).val();
    if(tipo == "ingreso"){
      $("#cantidad").removeClass("border-danger").addClass("border-success");
    } else if(tipo == "salida"){
      $("#cantidad").removeClass("border-success").addClass("border-danger");
    } else {
      $("#cantidad").removeClass("border-success border-danger");
    }
  });
</script>