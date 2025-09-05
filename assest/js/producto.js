function MNuevoProducto() {
  $("#modal-lg").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/producto/FNuevoProducto.php",
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

function RegProducto() {

  var formData = new FormData($("#FormRegProducto")[0])

  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrRegProducto",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'El Producto ha sido registrado',
          timer: 1000
        })
        setTimeout(function () {
          location.reload()
        }, 1200)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Erro de registro!!!',
          showConfirmButton: false,
          timer: 1500
        })
      }
    }
  })


}

function MEditProducto(id) {
  $("#modal-lg").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/producto/FEditProducto.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

function EditProducto() {

  var formData = new FormData($("#FormEditProducto")[0])

  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrEditProducto",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'El producto ha sido actualizado',
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

function MVerProducto(id) {
  $("#modal-lg").modal("show")
  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/producto/MVerProducto.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
      /* console.log(data); */
    }
  })
}

function MEliProducto(id) {
  var obj = {
    id: id
  }

  Swal.fire({
    title: 'Esta seguro de eliminar este Producto?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/productoControlador.php?ctrEliProducto",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Producto eliminado',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'El producto no puede ser eliminado, porque tiene registros',
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })



    }
  })
}

function previsualizar() {
  let imagen = document.getElementById("ImgProducto").files[0]

  if (imagen["type"] != "image/png" && imagen["type"] != "image/jpeg" && imagen["type"] != "image/jpg") {
    $("#ImgProducto").val("")
    swal.fire({
      icon: "error",
      showConfirmButton: true,
      title: "La imagen debe ser formato PNG, JPG o JPEG"
    })
  } else if (imagen["size"] > 10000000) {
    $("#ImgProducto").val("")
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
      $(".previsualizar").attr("src", rutaImagen)

    })
  }
}

function precioAdicional(id) {
  $("#modal-lg").modal("show");

  $.ajax({
    type: "POST",
    url: "vista/producto/precioAdicional.php?id=" + id,
    success: function (data) {
      $("#content-lg").html(data);

      // Esperar a que el DOM se actualice antes de cargar precios
      setTimeout(() => {
        cargarPreciosProducto(id);
      }, 100); // 100ms suele ser suficiente
    }
  });
}
function guardarPrecioAdicional() {
  const formData = $("#formPreciosAdicionales").serialize();
  const idPrecio = $("#formPreciosAdicionales").data("idPrecio") || null;

  // Determinar si es edición o nuevo registro
  const url = idPrecio
    ? "controlador/productoControlador.php?ctrActualizarPrecio"
    : "controlador/productoControlador.php?ctrGuardarPrecio";

  // Si es edición, agregar el idPrecio al formData
  const finalData = idPrecio ? formData + `&idPrecio=${idPrecio}` : formData;

  $.ajax({
    type: "POST",
    url: url,
    data: finalData,
    dataType: "json",
    success: function (response) {
      if (response.status === "ok") {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: idPrecio ? 'Precio actualizado correctamente' : 'Precio registrado correctamente',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true
        });

        const idProducto = $("#formPreciosAdicionales input[name='idProducto']").val();
        cargarPreciosProducto(idProducto);
        $("#formPreciosAdicionales")[0].reset();
        $("#formPreciosAdicionales").removeData("idPrecio"); // limpiar modo edición
      }

      /* else if (response.status === "duplicado") {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'warning',
          title: 'Ya existe un precio con ese concepto',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true
        });
      } else {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Error al registrar el precio',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true
        });
      } */
    },
    error: function () {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Error de conexión con el servidor',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
      });
    }
  });
}

function cargarPreciosProducto(idProducto) {
  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrListarPrecios",
    data: { idProducto: idProducto },
    dataType: "json",
    success: function (data) {
      let tabla = document.getElementById("tablaPreciosProducto");
      tabla.innerHTML = "";

      data.forEach(precio => {
        let fila = `<tr>
<td>${precio.concepto}</td>
<td>${precio.precio}</td>
<td>
  <span class="badge ${precio.estado == 1 ? 'badge-success' : 'badge-danger'}">
    ${precio.estado == 1 ? 'Activo' : 'Inactivo'}
  </span>
</td>
<td>
<button class="btn btn-sm btn-secondary" onclick="editarPrecio(${precio.id_precioproducto})"><i class="fas fa-edit"></i></button>
<button class="btn btn-sm btn-danger" onclick="eliminarPrecio(${precio.id_precioproducto})"><i class="fas fa-trash"></i></button>
</td>
</tr>`;
        tabla.innerHTML += fila;
      });
    }
  });
}

function eliminarPrecio(idPrecio) {
  Swal.fire({
    title: '¿Eliminar este precio?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "controlador/productoControlador.php?ctrEliminarPrecio",
        data: { idPrecio: idPrecio },
        success: function (response) {
          let res = JSON.parse(response);
          if (res.status === "ok") {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Precio eliminado',
              showConfirmButton: false,
              timer: 2000
            });

            let idProducto = $("#formPreciosAdicionales input[name='idProducto']").val();
            cargarPreciosProducto(idProducto);
          } else {
            Swal.fire('Error', 'No se pudo eliminar el precio.', 'error');
          }
        }
      });
    }
  });
}

function editarPrecio(idPrecio) {
  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrInfoPrecio",
    data: { idPrecio: idPrecio },
    dataType: "json",
    success: function (data) {
      // Cargar datos en el formulario
      $("#concepto").val(data.concepto);
      $("#precioAdicional").val(data.precio);
      $("#estado").val(data.estado);
      
      // Guardar el ID para saber que estamos editando
      $("#formPreciosAdicionales").data("idPrecio", idPrecio);
    }
  });
}
