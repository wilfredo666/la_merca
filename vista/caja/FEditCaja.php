<?php
require_once "../../controlador/cajaControlador.php";
require_once "../../modelo/cajaModelo.php";

$id = $_GET["id"];
$caja = ControladorCaja::ctrInfoCaja($id);
?>

<div class="modal-header">
  <h4 class="modal-title">Editar Movimiento de Caja</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">
  <form id="FormEditCaja">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="tipo">Tipo de Movimiento</label>
          <select class="form-control" id="tipo" name="tipo" required>
            <option value="">Seleccione...</option>
            <option value="ingreso" <?php echo ($caja["tipo"] == "ingreso") ? "selected" : ""; ?>>Ingreso</option>
            <option value="salida" <?php echo ($caja["tipo"] == "salida") ? "selected" : ""; ?>>Salida</option>
          </select>
        </div>
      </div>
      
      <div class="col-sm-6">
        <div class="form-group">
          <label for="cantidad">Cantidad (Bs.)</label>
          <input type="number" step="0.01" min="0.01" class="form-control" id="cantidad" name="cantidad" 
                 value="<?php echo $caja['cantidad']; ?>" required>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="concepto">Concepto</label>
      <input type="text" class="form-control" id="concepto" name="concepto" maxlength="50" 
             value="<?php echo $caja['concepto']; ?>" required>
      <small class="form-text text-muted">Máximo 50 caracteres</small>
    </div>

    <div class="form-group">
      <label for="descripcion">Descripción (Opcional)</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="200"><?php echo $caja['descripcion']; ?></textarea>
      <small class="form-text text-muted">Máximo 200 caracteres</small>
    </div>

    <div class="form-group">
      <label for="estado">Estado</label>
      <select class="form-control" id="estado" name="estado" required>
        <option value="1" <?php echo ($caja["estado_caja"] == "1") ? "selected" : ""; ?>>Activo</option>
        <option value="0" <?php echo ($caja["estado_caja"] == "0") ? "selected" : ""; ?>>Inactivo</option>
      </select>
    </div>

    <!-- Información adicional -->
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Creado:</label>
          <p class="form-control-static"><?php echo date('d/m/Y H:i', strtotime($caja['create_at'])); ?></p>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Actualizado:</label>
          <p class="form-control-static"><?php echo date('d/m/Y H:i', strtotime($caja['update_at'])); ?></p>
        </div>
      </div>
    </div>

    <!-- Campos ocultos -->
    <input type="hidden" name="id_caja" value="<?php echo $caja['id_caja']; ?>">
  </form>
</div>

<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary" onclick="EditCaja()">Actualizar</button>
</div>

<script>
  // Validación del formulario
  $("#FormEditCaja").validate({
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
      },
      estado: {
        required: true
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
      },
      estado: {
        required: "Seleccione el estado"
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

  // Ejecutar el preview al cargar
  $("#tipo").trigger('change');
</script>