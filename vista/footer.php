<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; 2025 <a href="https://ekesoft.co">Ekesoft.com</a>.</strong> Derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="assest/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assest/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assest/dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="assest/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assest/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assest/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assest/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assest/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assest/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assest/plugins/jszip/jszip.min.js"></script>
<script src="assest/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assest/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assest/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assest/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assest/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- date-range-picker -->
<script src="assest/plugins/moment/moment.min.js"></script>
<script src="assest/plugins/daterangepicker/daterangepicker.js"></script>

<script src="assest/js/usuario.js"></script>
<script src="assest/js/personal.js"></script>
<script src="assest/js/proveedor.js"></script>
<script src="assest/js/almacen.js"></script>
<script src="assest/js/categoria.js"></script>
<script src="assest/js/producto.js"></script>
<script src="assest/js/cliente.js"></script>
<script src="assest/js/reporte.js"></script>
<script src="assest/js/salida.js"></script>
<script src="assest/js/ingreso.js"></script>

<!--===============
seccion de modals
=================-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content" id="content-default">

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="content-lg">

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content-xl">

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- jquery-validation -->
<script src="assest/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assest/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="assest/plugins/jquery-validation/localization/messages_es.js"></script>

<!-- SweetAlert2 -->
<script src="assest/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
  /*dataTable generico*/
  $(function() {
    $("#DataTable").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"],
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    }).buttons().container().appendTo('#DataTable_wrapper .col-md-6:eq(0)');
    $('#DataTable td').css('padding', '5px');
    //$('#DataTable td').css('text-align', 'center'); 
  });

  $(function() {
    $("#DataTable_producto").DataTable({
      "processing": true,
      ajax: {
        url: "vista/producto/ajaxProducto.php",
        dataSrc: "data"
      },
      columns:[
        {data: 'cod_producto'},
        {
          data: 'imagen_producto',
          render: function(data, type, row) {

            if(data==""){
              return `<img src="assest/dist/img/producto/product_default.png" alt="Imagen" style="width: 50px; height: auto;">`;
            }else{
              return `<img src="assest/dist/img/producto/${data}" alt="Imagen" style="width: 50px; height: auto;">`;
            }
          }
        },
        {data: 'nombre_producto'},
        {data: 'descripcion_prod'},
        {data: 'categoria'},
        {data: 'precio'},
        {data: 'stock'},
        { 
          data: 'id_producto',
          render: function(data, type, row) {
            return `<div class="btn-group">
<button class="btn btn-sm btn-info" onclick="MVerProducto(${row.id_producto})">
<i class="fas fa-eye"></i>
  </button>
<button class="btn btn-sm btn-secondary" onclick="MEditProducto(${row.id_producto})">
<i class="fas fa-edit"></i>
  </button>
<button class="btn btn-sm btn-danger" onclick="MEliProducto(${row.id_producto})">
<i class="fas fa-trash"></i>
  </button>
  </div>`;
          }
        }
      ],
      "paging": true,
      "ordering": false,
      "pageLength": 15,
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"],
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    }).buttons().container().appendTo('#DataTable_producto_wrapper .col-md-6:eq(0)');
    $('#DataTable_producto td').css('padding', '5px');

  });

</script>


<script>
  //validacion para la nota de venta
  $(function() {
    $.validator.setDefaults({

      submitHandler: function() {
        if(arregloCarrito.length === 0){
          $("<span id='tablaError' style='font-size:12px' class='text-danger'>Debe agregar al menos un detalle</span>")
            .appendTo("#listaDetalle");
          return false;
        }
        RegNotaVenta()
      }
    })
    $(document).ready(function() {
      $("#FormNotaVenta").validate({
        rules: {

          rsCliente: {
            required: true,
          }
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

  })

  // Validación para Nota de Ingreso
  $(function() {
    $("#FIngresoOtros").validate({
      rules: {
        conceptoNI: { required: true },
        almacen_destino: { required: true }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function() {
        if (arregloCarritoNI.length === 0) {
          if (!$("#tablaError").length) {
            $("<span id='tablaError' style='font-size:12px' class='text-danger'>Debe agregar al menos un detalle</span>")
              .appendTo("#listaDetalleNI");
          }
          return false;
        }
        RegNotaIngreso();
      }
    });
  });

  // Validación para Nota de Salida
  $(function() {
    $("#FSalidaOtros").validate({
      rules: {
        conceptoNS: { required: true },
        almacen_origen: { required: true }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function() {
        if (arregloCarritoNS.length === 0) {
          if (!$("#tablaError").length) {
            $("<span id='tablaError' style='font-size:12px' class='text-danger'>Debe agregar al menos un detalle</span>")
              .appendTo("#listaDetalleNS");
          }
          return false;
        }
        RegNotaSalida();
      }
    });
  });
  
    // Validación para Nota de Traspaso
  $(function() {
    $("#FNotaTraspaso").validate({
      rules: {
        almacen_origen: { required: true },
        almacen_destino: { required: true }
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function() {
        if (arregloCarritoTs.length === 0) {
          if (!$("#tablaError").length) {
            $("<span id='tablaError' style='font-size:12px' class='text-danger'>Debe agregar al menos un detalle</span>")
              .appendTo("#listaDetalleTs");
          }
          return false;
        }
        RegTraspaso();
      }
    });
  });


</script>

</body>
</html>
