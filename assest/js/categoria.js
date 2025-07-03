function MNuevoCategoria() {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/categoria/FNuevoCategoria.php",
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}

function RegCategoria() {

  var formData = new FormData($("#FormRegCategoria")[0])

  $.ajax({
    type: "POST",
    url: "controlador/categoriaControlador.php?ctrRegistrarCategoria",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'La Categoria ha sido registrada',
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
function MEditCategoria(id) {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/categoria/FEditCategoria.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}

function EditCategoria() {
  var formData = new FormData($("#FormEditCategoria")[0])

  $.ajax({
    type: "POST",
    url: "controlador/categoriaControlador.php?ctrEditCategoria",
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
          title: 'La Categoría ha sido actualizado',
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


function MVerCategoria(id) {
  $("#modal-default").modal("show")

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/Categoria/MVerCategoria.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-default").html(data)
    }
  })
}

function MEliCategoria(id) {
  var obj = {
    id: id
  }

  Swal.fire({
    title: '¿Esta seguro de eliminar esta Categoria?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/categoriaControlador.php?ctrEliCategoria",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Categoria eliminada',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'La Categoria no puede ser eliminado, porque esta en uso',
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })

    }
  })
}

function ComprobarCategoria() {
  let loginCategoria = document.getElementById("loginCategoria").value
  var obj = {
    login: loginCategoria
  }
  $.ajax({
    type: "POST",
    data: obj,
    url: "controlador/CategoriaControlador.php?ctrBusCategoria",
    success: function (data) {
      if (data == "1") {
        $("#error-login").addClass("text-danger")
        document.getElementById("error-login").innerHTML = "Categoria en uso, intente con otro"
        $("#guardar").attr("disabled", true)
      } else {
        document.getElementById("error-login").innerHTML = ""
        $("#guardar").removeAttr("disabled")
      }
    }

  })
}