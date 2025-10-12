<div class="modal-header bg-info text-white">
    <h5 class="modal-title" id="modalPreciosLabel"> <i class="fas fa-list-alt" style="font-size: 20px;"></i> Catalogo de Productos</h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="get" action="vista/producto/ImpCatalogo.php" target="_blank">
    <div class="modal-body">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="concepto">Seleccionar la categoria a imprimir</label>
            </div>
            <div class="form-group col-md-6">
                <select class="form-control select2bs4" name="categoriaProducto" id="categoriaProducto" required>
                    <option value="">Seleccionar</option>
                    <option value="todos" class="text-primary fw-bold">Todos</option>
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

        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Imprimir</button>
    </div>
</form>
</div>