<?php
require "../../controlador/categoriaControlador.php";
require "../../modelo/categoriaModelo.php";

$id = $_GET["id"];
$categoria = ControladorCategoria::ctrInfoCategoria($id);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Categoria</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormEditCategoria">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Descripción de la Categoría</label>
      <input type="text" class="form-control" id="desCategoria" name="desCategoria" value="<?php echo $categoria["descripcion_cat"]; ?>">
      <input type="hidden" name="idCategoria" id="idCategoria" value="<?php echo $id; ?>">
    </div>
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <!-- <button type="button" class="btn btn-primary" onclick="EditCategoria()">Guardar</button> -->
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </div>
</form>

<script>
  $(function(){
    $.validator.setDefaults({
      
      submitHandler:function(){
        EditCategoria()
      }
    })
    $(document).ready(function(){
      $("#FormEditCategoria").validate({
      rules:{
        desCategoria:{
          required:true,
        }       
      },
      errorElement:'span',
      errorPlacement:function(error, element){
        error.addClass('invalid-feedback')
        element.closest('.form-group').append(error)
      },

      highlight: function(element, errorClass, validClass){
        $(element).addClass('is-invalid')
        /* .is-invalid */
      },

      unhighlight: function(element, errorClass, validClass){
        $(element).removeClass('is-invalid')
      }

    })
    })

  })

</script>