/*==================
formulario de ventas
===================*/
function busCliente(){
  let nitCliente = document.getElementById("nitCliente").value

  var obj={
    nitCliente:nitCliente
  }

  $.ajax({
    type:"POST",
    url:"controlador/clienteControlador.php?ctrBusCliente",
    data:obj,
    dataType:"json",
    success:function(data){

      document.getElementById("rsCliente").value = data["razon_social_cliente"]
      document.getElementById("idCliente").value = data["id_cliente"]

      //hacer que se le de un valor al numero factura
      numFactura()
    }
  })
}

function numFactura(){
  var obj=""

  $.ajax({
    type:"POST",
    url:"controlador/salidaControlador.php?ctrNumFactura",
    data:obj,
    success:function(data){
      document.getElementById("numFactura").value = data

    }
  })
}

function busProducto(){
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
      document.getElementById("uniMedida").value = data["unidad_medida"]
      document.getElementById("preUnitario").value = data["precio"]

    }
  })
}

//calculo precio
function calcularPrePro(){
  let cantProducto = parseInt(document.getElementById("cantProducto").value)
  let preUnitario = parseFloat(document.getElementById("preUnitario").value)

  let preProducto = preUnitario * cantProducto

  document.getElementById("preTotal").value = preProducto.toFixed(2)

}

//**** carrito ******
var arregloCarrito=[]
var listaDetalle=document.getElementById("listaDetalle")
function agregarCarrito(){

  let idProducto = document.getElementById("idProducto").value
  let codProducto = document.getElementById("codProducto").value
  let conceptoPro = document.getElementById("conceptoPro").value
  let cantProducto = parseInt(document.getElementById("cantProducto").value)
  let uniMedida = document.getElementById("uniMedida").value
  let preUnitario = parseFloat(document.getElementById("preUnitario").value)
  let preTotal = parseFloat(document.getElementById("preTotal").value)

  let objetoDetalle = {
    idProducto:idProducto,
    codigoProducto:codProducto,
    descripcion:conceptoPro,
    cantidad:cantProducto,
    uniMedida:uniMedida,
    precioUnitario:preUnitario,
    subtotal:preTotal
  }

  arregloCarrito.push(objetoDetalle)

  dibujarTablaCarrito()

  // borrar formulario carrito
  document.getElementById("codProducto").value=""
  document.getElementById("conceptoPro").value=""
  document.getElementById("cantProducto").value=0
  document.getElementById("uniMedida").value=""

  document.getElementById("preUnitario").value=""
  document.getElementById("preTotal").value="0.00"
}

function dibujarTablaCarrito(){
  listaDetalle.innerHTML = ""

  arregloCarrito.forEach(
    (detalle)=>{
      let fila=document.createElement("tr")

      fila.innerHTML='<td>'+detalle.descripcion+'</td>'+
        '<td>'+detalle.cantidad+'</td>'+
        '<td>'+detalle.uniMedida+'</td>'+
        '<td>'+detalle.precioUnitario+'</td>'+
        '<td>'+detalle.subtotal+'</td>'

      let tdEliminar = document.createElement("td")
      let botonEliminar = document.createElement("button")
      botonEliminar.classList.add("btn", "btn-danger")
      botonEliminar.innerHTML="Eliminar"
      botonEliminar.onclick=()=>{
        eliminarCarrito(detalle.codigoProducto)
      }

      tdEliminar.appendChild(botonEliminar)
      fila.appendChild(tdEliminar)

      listaDetalle.appendChild(fila)
    })

  calcularTotal()
}

function eliminarCarrito(cod){
  arregloCarrito = arregloCarrito.filter((detalle)=>{
    if(cod!=detalle.codigoProducto){
      return detalle
    }
  })

  dibujarTablaCarrito()
  calcularTotal()
}

function calcularTotal(){
  let totalCarrito = 0

  for(var i=0; i<arregloCarrito.length; i++){
    totalCarrito = totalCarrito + parseFloat(arregloCarrito[i].subtotal)
  }

  document.getElementById("totVenta").innerHTML = totalCarrito

}

function RegNotaVenta(){
  var formData = new FormData($("#FormNotaVenta")[0])
  formData.append("carritoVenta", JSON.stringify(arregloCarrito));
  formData.append("totVenta", $("#totVenta").html());


  $.ajax({
    type: "POST",
    url: "controlador/salidaControlador.php?ctrRegNotaVenta",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'Venta registrada',
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

function MVerNotaVenta(id) {
  $("#modal-xl").modal("show")
  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/venta/notaVenta.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-xl").html(data)
    }
  })
}