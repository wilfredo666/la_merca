function MNuevoUsuario() {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/usuario/FNuevoUsuario.php",
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}

function RegUsuario() {
  let passUsuario = document.getElementById("passUsuario").value
  let passUsuario2 = document.getElementById("passUsuario2").value

  if (passUsuario == passUsuario2) {

    var formData = new FormData($("#FormRegUsuario")[0])

    $.ajax({
      type: "POST",
      url: "controlador/usuarioControlador.php?ctrRegUsuario",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data == "ok") {
          Swal.fire({
            icon: 'success',
            showConfirmButton: false,
            title: 'El usuario ha sido registrado',
            timer: 1000
          })
          setTimeout(function () {
            location.reload()
          }, 1200)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'El usuario ya esta en uso',
            showConfirmButton: false,
            timer: 1500
          })
        }
      }
    })
  } else {
    document.getElementById("error-pass").innerHTML = "Los campos de contraseña no coinciden"
  }
}

function MEditUsuario(id) {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/usuario/FEditUsuario.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}

function EditUsuario() {
  let passUsuario = document.getElementById("passUsuario").value
  let passUsuario2 = document.getElementById("passUsuario2").value

  if (passUsuario == passUsuario2) {

    var formData = new FormData($("#FormEditUsuario")[0])

    $.ajax({
      type: "POST",
      url: "controlador/usuarioControlador.php?ctrEditUsuario",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data == "ok") {
          Swal.fire({
            icon: 'success',
            showConfirmButton: false,
            title: 'El usuario ha sido actualizado',
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
  } else {
    document.getElementById("error-pass").innerHTML = "Los campos de contraseña no coinciden"
  }

}

function MVerUsuario(id) {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/usuario/MVerUsuario.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}


function MEliUsuario(id) {
  var obj = {
    id: id
  }

  Swal.fire({
    title: '¿Esta seguro de eliminar este usuario?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/usuarioControlador.php?ctrEliUsuario",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Usuario eliminado',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'El usuario no puede ser eliminado, porque es un usuario activo',
              showConfirmButton: false,
              timer: 1900
            })
          }
        }
      })

    }
  })
}


$(document).on('click', '.estadoUsuario', function (e) {
  e.preventDefault();

  let $this = $(this);
  let est = $this.data('est');
  let id = $this.data('id');

  // Cambias el valor antes de enviarlo
  if (est == 1) {
    est = 0
  } else {
    est = 1
  }

  var obj = {
    est: est,
    id: id
  }

  $.ajax({
    type: "POST",
    url: "controlador/usuarioControlador.php?ctrCambioEstado",
    data: obj,
    success: function (data) {

      if (data === "ok" && est == 0) {
        $this.html('Inactivo')
          .removeClass('bg-success')
          .addClass('bg-danger')
          .data('est', 1); // actualizar el estado
      } else {
        $this.html('Activo')
          .removeClass('bg-danger')
          .addClass('bg-success')
          .data('est', 0); // actualizar el estado
      }
    }
  })

});

//permisos
function actualizarPermiso(idUsuario, idPermiso) {
  var obj = {
    idUsuario: idUsuario,
    idPermiso: idPermiso
  }

  $.ajax({
    type: "POST",
    url: "controlador/usuarioControlador.php?ctrActualizarPermiso",
    data: obj,
    success: function (data) {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      if (data === "ok") {

        Toast.fire({
          icon: 'success',
          title: 'Permiso actualizado correctamente.'
        })

      } else {
        // Mostrar toast de error

        Toast.fire({
          icon: 'error',
          title: 'No se puede cambiar el permiso.'
        })
      }
    },
    error: function () {
      // En caso de error en la solicitud AJAX
      toastr.error('Hubo un error al procesar la solicitud.');
    }
  });
}
