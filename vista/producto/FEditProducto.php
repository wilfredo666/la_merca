<?php
require "../../controlador/productoControlador.php";
require "../../modelo/productoModelo.php";

$id = $_GET["id"];
$producto = ControladorProducto::ctrInfoProducto($id);

?>

<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Producto</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<form action="" id="FormEditProducto" enctype="multipart/form-data">
  <div class="modal-body row">
    <div class="form-group col-md-4">
      <label for="">Cód. Producto</label>
      <input type="text" class="form-control" id="codProducto" name="codProducto" value="<?php echo $producto["cod_producto"];?>">
      <input type="hidden" name="idProducto" value="<?php echo $producto["id_producto"];?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Categoria</label>
      <select class="form-control select2bs4" name="categoriaProducto" id="categoriaProducto" value="<?php echo $producto["categoria"];?>">
        <option value="">Seleccionar</option>
        <?php
        require_once "../../controlador/categoriaControlador.php";
        require_once "../../modelo/categoriaModelo.php";
        $categoria = ControladorCategoria::ctrInfoCategorias();
        foreach ($categoria as $value) {
        ?>
        <option value="<?php echo $value["descripcion_cat"]; ?>" <?php if($producto["categoria"]==$value["descripcion_cat"]):?>selected<?php endif;?>><?php echo $value["descripcion_cat"]; ?></option>
        <?php
        }
        ?>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Unidad de Medida</label>
      <select class="form-control" name="unidad_medida" id="unidad_medida">
        <option value="">Seleccionar</option>
        <option value="UNIDAD" <?php if($producto["unidad_medida"]=="UNIDAD"):?>selected<?php endif;?>>Unidad</option>
        <option value="UNIDADES" <?php if($producto["unidad_medida"]=="UNIDADES"):?>selected<?php endif;?>>Unidades</option>
      </select>
    </div>

    <div class="form-group col-md-6">
      <label for="">Nombre del Producto</label>
      <input type="text" class="form-control" id="nomProducto" name="nomProducto" value="<?php echo $producto["nombre_producto"];?>">
    </div>
    <div class="form-group col-md-6">
      <label for="">Descripción</label>
      <input type="text" class="form-control" id="descProducto" name="descProducto" value="<?php echo $producto["descripcion_prod"];?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Costo Producto</label>
      <input type="number" class="form-control" id="costoProducto" name="costoProducto" placeholder="0.00" value="<?php echo $producto["costo"];?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Precio Producto</label>
      <div class="input-group">
        <input type="number" class="form-control" id="precioProducto" name="precioProducto" placeholder="0.00" value="<?php echo $producto["precio"];?>">
        <div class="input-group-append">
          <button type="button" class="btn btn-outline-info" onclick="precioAdicional(<?php echo $producto["id_producto"];?>)">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="form-group col-md-4">
      <label for="">Marca</label>
      <input class="form-control" type="text" name="marca" id="marca" value="<?php echo $producto["marca"];?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Estado</label>
      <select name="estadoProducto" id="estadoProducto" class="form-control">
        <option value="1" <?php if ($producto["disponible"] == 1) : ?> selected <?php endif; ?>>Disponible</option>
        <option value="0" <?php if ($producto["disponible"] == 0) : ?> selected <?php endif; ?>>No disponible</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="">Imagen del Producto</label>
      <input type="file" class="form-control" id="ImgProducto" name="ImgProducto" onchange="previsualizar()">
      <input type="hidden" class="form-control" name="ImgProductoActual" value="<?php echo $producto["imagen_producto"];?>">
    </div>

    <div class="form-group col-md-4" style="text-align: center;">
      <img src="assest/dist/img/producto/<?= $producto["imagen_producto"] ?: 'product_default.png'; ?>" class="img-thumbnail previsualizar" width="200">
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
        EditProducto()
      }
    })
    $(document).ready(function() {
      $("#FormEditProducto").validate({
        rules: {
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
        },

        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid')
        }

      })
    })

    // Inicializar Select2 para el campo categoría
    $('#categoriaProducto').select2({
      theme: 'bootstrap4',
      placeholder: 'Seleccione una categoría',
      width: '100%',
      language: {
        noResults: function() {
          return "No se encontraron resultados";
        },
        searching: function() {
          return "Buscando...";
        }
      }
    });

  })
</script>