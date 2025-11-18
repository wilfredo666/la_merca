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

  // Agregar precios adicionales del carrito si existen
  if (preciosAdicionalesNP.length > 0) {
    formData.append("preciosCarrito", JSON.stringify(preciosAdicionalesNP));
  }

  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrRegProducto",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data == "ok") {
       // Limpiar carrito de precios adicionales después del registro exitoso
        preciosAdicionalesNP = [];

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
          text: 'Error de registro!!!',
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


/*=============================================
 Precios Adicionales en edicion de producto
 ============================================*/

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

function MCatalogoProductos(){
  $("#modal-lg").modal("show");

  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/producto/MCatalogoProductos.php",
    data: obj,
    success: function (data) {
      $("#content-lg").html(data)
    }
  })
}

/*=============================================
 Precios Adicionales en nuevo producto
 ============================================*/

function precioAdicionalNP() {
  // Cargar el modal independiente si no existe
  if ($("#modalPreciosNuevoProducto").length === 0) {
    $.ajax({
      type: "POST",
      url: "vista/producto/precioAdicionalNP.php",
      success: function (data) {
        // Agregar el modal al body
        $("body").append(data);

        // Mostrar el modal después de agregarlo
        $("#modalPreciosNuevoProducto").modal("show");

        // Cargar precios del carrito
        setTimeout(() => {
          mostrarCarritoPreciosNP();
        }, 200);
      }
    });
  } else {
    // Si ya existe, simplemente mostrarlo
    $("#modalPreciosNuevoProducto").modal("show");
    mostrarCarritoPreciosNP();
  }
}

//carrito de precios adicionales en nuevo producto
var preciosAdicionalesNP = [];

function agregarPrecioAdicionalNP() {
  var concepto = $("#conceptoNP").val().trim();
  var precio = parseFloat($("#precioAdicionalNP").val());
  var estado = $("#estadoNP").val();

  // Validaciones
  if (concepto === "") {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'El concepto es requerido.'
    });
    return;
  }

  if (isNaN(precio) || precio <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'El precio debe ser mayor a 0.'
    });
    return;
  }

  // Verificar si ya existe el concepto
  const conceptoExiste = preciosAdicionalesNP.some(item => item.concepto.toLowerCase() === concepto.toLowerCase());

  if (conceptoExiste) {
    Swal.fire({
      icon: 'warning',
      title: 'Advertencia',
      text: 'Ya existe un precio con ese concepto.'
    });
    return;
  }

  // Agregar nuevo precio al carrito
  var nuevoPrecio = {
    id: Date.now(), // ID temporal único
    concepto: concepto,
    precio: precio.toFixed(2),
    estado: estado
  };

  preciosAdicionalesNP.push(nuevoPrecio);

  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Precio Adicional Agregado',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
  });

  // Limpiar formulario y actualizar vista
  $("#formPreciosAdicionalesNP")[0].reset();
  mostrarCarritoPreciosNP();
}

function mostrarCarritoPreciosNP() {
  let tabla = document.getElementById("tablaPreciosProductoNP");
  tabla.innerHTML = "";

  preciosAdicionalesNP.forEach(precio => {
    let fila = `<tr>
      <td>${precio.concepto}</td>
      <td>${precio.precio}</td>
      <td>
        <span class="badge ${precio.estado == 1 ? 'badge-success' : 'badge-danger'}">
          ${precio.estado == 1 ? 'Activo' : 'Inactivo'}
        </span>
      </td>
      <td>
        <button class="btn btn-sm btn-secondary" onclick="editarPrecioNP(${precio.id})"><i class="fas fa-edit"></i></button>
        <button class="btn btn-sm btn-danger" onclick="eliminarPrecioDelCarritoNP(${precio.id})"><i class="fas fa-trash"></i></button>
      </td>
    </tr>`;
    tabla.innerHTML += fila;
  });
}

function eliminarPrecioDelCarritoNP(id) {
  Swal.fire({
    title: '¿Eliminar este precio?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Filtrar el precio a eliminar
      preciosAdicionalesNP = preciosAdicionalesNP.filter(precio => precio.id !== id);

      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Precio eliminado',
        showConfirmButton: false,
        timer: 2000
      });

      mostrarCarritoPreciosNP();
    }
  });
}

function editarPrecioNP(id) {
  // Encontrar el precio en el carrito
  const precio = preciosAdicionalesNP.find(item => item.id === id);

  if (precio) {
    // Cargar datos en el formulario
    $("#conceptoNP").val(precio.concepto);
    $("#precioAdicionalNP").val(precio.precio);
    $("#estadoNP").val(precio.estado);

    // Eliminar el precio del carrito para que se pueda actualizar
    preciosAdicionalesNP = preciosAdicionalesNP.filter(item => item.id !== id);
    mostrarCarritoPreciosNP();
  }
}

function verPreciosAdicionales(idProducto) {
  const panel = document.getElementById('panelPreciosAdicionales');
  const boton = document.getElementById('verPreciosAdicionales');
  const icono = boton.querySelector('i');

  if (panel.style.display === 'none' || panel.style.display === '') {
    // Cargar y mostrar precios adicionales
    $.ajax({
      type: "POST",
      url: "controlador/productoControlador.php?ctrPreciosAdicionales",
      data: { idProducto: idProducto },
      dataType: "json",
      success: function(data) {
        let html = '';
        if (data && data.length > 0) {
          data.forEach(function(precio) {
            html += `
              <tr>
                <td class="text-center">${precio.concepto}</td>
                <td class="text-center font-weight-bold text-info">${parseFloat(precio.precio).toFixed(2)} Bs.</td>
              </tr>
            `;
          });
        } else {
          html = `
            <tr>
              <td colspan="2" class="text-center text-muted py-3">
                <i class="fas fa-info-circle mr-1"></i>
                No hay precios adicionales registrados
              </td>
            </tr>
          `;
        }

        document.getElementById('listaPreciosAdicionales').innerHTML = html;
        panel.style.display = 'block';
        icono.className = 'fas fa-chevron-up';
        boton.title = 'Ocultar precios adicionales';
      },
      error: function() {
        alert("Error al cargar los precios adicionales");
      }
    });
  } else {
    // Ocultar panel
    panel.style.display = 'none';
    icono.className = 'fas fa-list';
    boton.title = 'Ver precios adicionales';
  }
}