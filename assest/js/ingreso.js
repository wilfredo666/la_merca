function busProductoIngreso(){
  let codProducto = document.getElementById("codProducto").value

  var obj={
    codProducto:codProducto
  }

  $.ajax({
    type:"POST",
    url:"controlador/productoControlador.php?ctrBusProducto",
    data:obj,
    dataType:"json",
    success:function(data){

      document.getElementById("idProducto").value = data["id_producto"]
      document.getElementById("conceptoPro").value = data["nombre_producto"]
      document.getElementById("preUnitario").value = data["costo"]

    }
  })
}

//**** carrito de nota de ingreso ******
var arregloCarritoNI=[]
var totalCarritoNI = 0
var listaDetalleNI=document.getElementById("listaDetalleNI")
function agregarCarritoNI(){

  let idProducto = parseInt(document.getElementById("idProducto").value)
  let codProducto = document.getElementById("codProducto").value
  let conceptoPro = document.getElementById("conceptoPro").value
  let cantProducto = parseInt(document.getElementById("cantProducto").value)
  let preUnitario = parseFloat(document.getElementById("preUnitario").value)
  let preTotal = parseFloat(cantProducto * preUnitario)

  let objetoDetalle = {
    idProducto:idProducto,
    codigoProducto:codProducto,
    descripcion:conceptoPro,
    cantidad:cantProducto,
    precioUnitario:preUnitario,
    subtotal:preTotal
  }

  arregloCarritoNI.push(objetoDetalle)

  dibujarTablaCarritoNI()

  // borrar formulario carrito
  document.getElementById("codProducto").value=""
  document.getElementById("conceptoPro").value=""
  document.getElementById("cantProducto").value=0
  document.getElementById("preUnitario").value=""
}

function dibujarTablaCarritoNI(){
  listaDetalleNI.innerHTML = ""

  arregloCarritoNI.forEach(
    (detalle)=>{
      let fila=document.createElement("tr")

      fila.innerHTML='<td>'+detalle.descripcion+'</td>'+
        '<td>'+detalle.precioUnitario+'</td>'+
        '<td>'+detalle.cantidad+'</td>'+
        '<td>'+detalle.subtotal+'</td>'

      let tdEliminar = document.createElement("td")
      let botonEliminar = document.createElement("button")
      botonEliminar.classList.add("btn", "btn-danger", "btn-sm")
      botonEliminar.innerHTML="<i class='fas fa-trash'></i>"
      botonEliminar.onclick=()=>{
        eliminarCarrito(detalle.codigoProducto)
      }

      tdEliminar.appendChild(botonEliminar)
      fila.appendChild(tdEliminar)

      listaDetalleNI.appendChild(fila)
    })

  calcularTotal()
}

function eliminarCarrito(cod){
  arregloCarritoNI = arregloCarritoNI.filter((detalle)=>{
    if(cod!=detalle.codigoProducto){
      return detalle
    }
  })

  dibujarTablaCarritoNI()
  calcularTotal()
}

function calcularTotal(){
totalCarritoNI = 0
  for(var i=0; i<arregloCarritoNI.length; i++){
    totalCarritoNI = totalCarritoNI + parseFloat(arregloCarritoNI[i].subtotal)
  }
}

function RegNotaIngreso(){
  var formData = new FormData($("#FIngresoOtros")[0])
  formData.append("carritoNI", JSON.stringify(arregloCarritoNI));
  formData.append("totalNI", totalCarritoNI);


  $.ajax({
    type: "POST",
    url: "controlador/ingresoControlador.php?ctrRegNotaIngreso",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'Nota de Ingreso registrada',
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

function MVerNotaIngreso(id) {
  $("#modal-xl").modal("show")
  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/ingreso/MverNotaIngreso.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-xl").html(data)
    }
  })
}

function MEliNotaIngreso(id) {
  var obj = {
    id: id
  }

  Swal.fire({
    title: 'Esta seguro de eliminar este nota de ingreso?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/ingresoControlador.php?ctrEliNotaIngreso",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Nota de Ingreso eliminada',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'La Nota no puede ser eliminada',
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })



    }
  })
}
