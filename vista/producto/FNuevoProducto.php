<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Registrar nuevo Producto</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormRegProducto" enctype="multipart/form-data">
  <div class="modal-body row">
    <div class="form-group col-md-4">
      <label for="">Cód. Producto</label>
      <input type="text" class="form-control" id="codProducto" name="codProducto">
    </div>
        <div class="form-group col-md-4">
      <label for="">Categoria</label>
      <select class="form-control select2bs4" name="categoriaProducto" id="categoriaProducto">
        <option value="">Seleccionar</option>
        <?php
        require_once "../../controlador/categoriaControlador.php";
        require_once "../../modelo/categoriaModelo.php";
        $categoria = ControladorCategoria::ctrInfoCategorias();
        foreach ($categoria as $value) {
        ?>
        <option value="<?php echo $value["descripcion_cat"]; ?>"><?php echo $value["descripcion_cat"]; ?></option>
        <?php
        }
        ?>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Unidad de Medida</label>
      <select class="form-control" name="unidad_medida" id="unidad_medida">
        <option value="">Seleccionar</option>
        <option value="UNIDAD">Unidad</option>
        <option value="UNIDADES">Unidades</option>
      </select>
    </div>
    
    <div class="form-group col-md-6">
      <label for="">Nombre del Producto</label>
      <input type="text" class="form-control" id="nomProducto" name="nomProducto">
    </div>
    <div class="form-group col-md-6">
      <label for="">Descripción</label>
      <input type="text" class="form-control" id="descProducto" name="descProducto">
    </div>
    <div class="form-group col-md-4">
      <label for="">Costo Producto</label>
      <input type="number" class="form-control" id="costoProducto" name="costoProducto" placeholder="0.00">
    </div>
    <div class="form-group col-md-4">
      <label for="">Precio Producto</label>
      <input type="number" class="form-control" id="precioProducto" name="precioProducto" placeholder="0.00">
    </div>

    <div class="form-group col-md-4">
      <label for="">Marca</label>
      <input class="form-control" type="text" name="marca" id="marca">
    </div>

    <div class="form-group col-md-6">
      <label for="">Imagen del Producto</label>
      <input type="file" class="form-control" id="ImgProducto" name="ImgProducto" onchange="previsualizar()">
    </div>

    <div class="form-group col-md-6" style="text-align: center;">
      <img src="assest/dist/img/producto/product_default.png" class="img-thumbnail previsualizar" width="200">
    </div>
  </div>

  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
  </div>
</form>


<script>
  $(function() {
    $.validator.setDefaults({

      submitHandler: function() {
        RegProducto()
      }
    })
    $(document).ready(function() {
      $("#FormRegProducto").validate({
        rules: {
          codProducto: {
            required: true,
            minlength: 3
          },
          nomProducto: {
            required: true,
            minlength: 3
          },
          precioProducto: {
            required: true,
          },
          categoriaProducto:"required"
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback')
          element.closest('.form-group').append(error)
        },

        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid')
          /* .is-invalid */
        },

        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid')
        }

      })
    })

  })
</script>