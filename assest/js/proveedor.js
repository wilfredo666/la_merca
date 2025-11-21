function MNuevoProveedor() {
  $("#modal-lg").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/proveedor/FNuevoProveedor.php",
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

function RegProveedor() {

  var formData = new FormData($("#FormRegProveedor")[0])

  $.ajax({
    type: "POST",
    url: "controlador/proveedorControlador.php?ctrRegProveedor",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'El Proveedor ha sido registrado',
          timer: 1000
        })
        setTimeout(function () {
          location.reload()
        }, 1200)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Error de registro!',
          showConfirmButton: false,
          timer: 1500
        })
      }
    }
  })
}

function MEditProveedor(id) {
  $("#modal-lg").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/proveedor/FEditProveedor.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

function EditProveedor() {
  var formData = new FormData($("#FormEditProveedor")[0])
  $.ajax({
    type: "POST",
    url: "controlador/proveedorControlador.php?ctrEditProveedor",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      /* console.log(data) */
      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'El Proveedor ha sido actualizado',
          timer: 1000
        })
        setTimeout(function () {
          location.reload()
        }, 1200)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'No se ha podido actualizar!!!',
          showConfirmButton: false,
          timer: 1500
        })
      }
    }
  })
}

function MVerProveedor(id) {
  $("#modal-lg").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/proveedor/MVerProveedor.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

function MEliProveedor(id) {
  var obj = {
    id: id
  }
  Swal.fire({
    title: '¿Esta seguro de eliminar este Proveedor?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/proveedorControlador.php?ctrEliProveedor",
        success: function (data) {
          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Proveedor eliminado',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'El Proveedor no puede ser eliminado debido a estar activo o en uso',
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })

    }
  })
}

function previsualizarUP(){
    let imagen = document.getElementById("ubiProveedor").files[0]

  if (imagen["type"] != "image/png" && imagen["type"] != "image/jpeg" && imagen["type"] != "image/jpg") {
    $("#ubiProveedor").val("")
    swal.fire({
      icon: "error",
      showConfirmButton: true,
      title: "La imagen debe ser formato PNG, JPG o JPEG"
    })
  } else if (imagen["size"] > 10000000) {
    $("#ubiProveedor").val("")
    Swal.fire({
      icon: "error",
      showConfirmButton: true,
      title: "La imagen no debe superior a 10MB"
    })

  } else {
    let datosImagen = new FileReader
    datosImagen.readAsDataURL(imagen)

    $(datosImagen).on("load", function (event) {
      let rutaImagen = event.target.result
      $(".previsualizarIP").attr("src", rutaImagen)

    })
  }
}

/*=============================================
Funciones para el kardex por proveedor
==============================================*/
$(document).ready(function() {

  // Date Range Picker para Kardex Proveedor
  $('#daterange-kardex-proveedor').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD',
      separator: ' - ',
      applyLabel: 'Aplicar',
      cancelLabel: 'Cancelar',
      fromLabel: 'Desde',
      toLabel: 'Hasta',
      customRangeLabel: 'Personalizado',
      weekLabel: 'S',
      daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      firstDay: 1
    },
    opens: 'center',
    autoUpdateInput: false
  });

  // Evento aplicar rango de fechas
  $('#daterange-kardex-proveedor').on('apply.daterangepicker', function(ev, picker) {
    $(this).find('span').html(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    $('#fechaInicialKardexProveedor').val(picker.startDate.format('YYYY-MM-DD'));
    $('#fechaFinalKardexProveedor').val(picker.endDate.format('YYYY-MM-DD'));
    //cargarKardexProveedor();
  });

  // Evento cancelar rango de fechas
  $('#daterange-kardex-proveedor').on('cancel.daterangepicker', function(ev, picker) {
    $(this).find('span').html('Seleccionar fecha');
    $('#fechaInicialKardexProveedor').val('');
    $('#fechaFinalKardexProveedor').val('');
    cargarKardexProveedor();
  });

  // Evento click para el botón Buscar
  $('#btnBuscarProveedor').on('click', function() {
    cargarKardexProveedor();
  });

});

function cargarKardexProveedor() {
  var id_proveedor = $('#filtroProveedor').val();
  var fecha_inicial = $('#fechaInicialKardexProveedor').val();
  var fecha_final = $('#fechaFinalKardexProveedor').val();
  $.ajax({
    type: "POST",
    url: "controlador/proveedorControlador.php?ctrKardexProveedor",
    data: {
      id_proveedor: id_proveedor,
      fecha_inicial: fecha_inicial,
      fecha_final: fecha_final
    },
    dataType: "json",
    success: function(response) {
      // Limpiar el cuerpo de la tabla antes de agregar nuevos datos
      $('#cuerpoKardexProveedor').empty();
      // Recorrer la respuesta y agregar filas a la tabla
      response.forEach(function(item) {
        var fila = '<tr>' +
          '<td>' + item.create_at + '</td>' +
          '<td>' + item.nombre_empresa + '</td>' +
          '<td>' + item.codigo_oi + '</td>' +
          '<td>' + item.total_oi + '</td>' +
          '<td>' + item.nombre_almacen +' - '+ item.descripcion + '</td>' +
          //boton para detalle
          
          '<td>' +
            '<button class="btn btn-sm btn-info" onclick="MVerNotaIngreso(' + item.id_otros_ingresos + ')">' +
                 '<i class="fas fa-eye"></i>' +
              '</button>' +'</td>' +
          '</tr>';
        $('#cuerpoKardexProveedor').append(fila);
      });
    },
    error: function() {
      tablaKardexProveedor.clear().draw();
    }
  });
}