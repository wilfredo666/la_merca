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
      //numFactura()
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
      
      // Verificar si se encontró el producto
      if (data && data["id_producto"]) {
        
        document.getElementById("idProducto").value = data["id_producto"]
        document.getElementById("conceptoPro").value = data["nombre_producto"]
        document.getElementById("preUnitario").value = data["precio"]
        document.getElementById("cantProducto").value=1
        document.getElementById("stock").value=data["stock"]
        document.getElementById("categoria").value = data["categoria"] || ''
        document.getElementById("imagen").value = data["imagen_producto"] || ''
        
        // Validar stock antes de permitir agregar al carrito
        let stock = parseInt(data["stock"]) || 0;
        
        if (stock >= 1) {
          // Stock disponible - permitir agregar al carrito automáticamente
          agregarCarrito();
        } else {
          // No hay stock - mostrar alert y limpiar campos
          Swal.fire({
            icon: 'warning',
            title: 'Stock Insuficiente',
            text: `El producto "${data["nombre_producto"]}" no tiene stock disponible.`,
            confirmButtonText: 'Entendido'
          });
          
          // Limpiar campos del producto
          limpiarCamposProducto();
        }
        
      } else {
        // Producto no encontrado
        Swal.fire({
          icon: 'error',
          title: 'Producto No Encontrado',
          text: `No se encontró un producto con el código "${codProducto}".`,
          confirmButtonText: 'Entendido'
        });
        
        // Limpiar campos del producto
        limpiarCamposProducto();
      }

    },
    error: function() {
      // Error en la petición AJAX
      Swal.fire({
        icon: 'error',
        title: 'Error de Conexión',
        text: 'No se pudo conectar con el servidor. Intente nuevamente.',
        confirmButtonText: 'Entendido'
      });
      
      // Limpiar campos del producto
      limpiarCamposProducto();
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

// Función para limpiar campos del producto cuando no hay stock
function limpiarCamposProducto() {
  document.getElementById("codProducto").value = "";
  document.getElementById("idProducto").value = "";
  document.getElementById("conceptoPro").value = "";
  document.getElementById("preUnitario").value = "";
  document.getElementById("cantProducto").value = 0;
  document.getElementById("preTotal").value = "0.00";
  document.getElementById("stock").value = "";
  document.getElementById("categoria").value = "";
  document.getElementById("imagen").value = "";
}

//**** carrito nota de venta ******
var arregloCarrito=[]
var listaDetalle=document.getElementById("listaDetalle")
function agregarCarrito() {
  let stock = parseInt(document.getElementById("stock").value) || 0;

  let idProducto = document.getElementById("idProducto").value;
  let codProducto = document.getElementById("codProducto").value;
  let conceptoPro = document.getElementById("conceptoPro").value;
  let cantProducto = parseInt(document.getElementById("cantProducto").value);
  let preUnitario = parseFloat(document.getElementById("preUnitario").value);
  let categoria = document.getElementById("categoria").value || "";
  let imagen = document.getElementById("imagen").value || "";

  // 🔁 Obtener precios disponibles desde el backend
  $.ajax({
    type: "POST",
    url: "controlador/productoControlador.php?ctrListarPrecios",
    data: { idProducto: idProducto },
    dataType: "json",
    success: function (precios) {
      
      let preciosArray = [];
      if (precios && Array.isArray(precios)) {
        preciosArray = precios.map(p => ({
          precio: parseFloat(p.precio),
          concepto: p.concepto
        }));
      }

      let objetoDetalle = {
        idProducto: idProducto,
        codigoProducto: codProducto,
        descripcion: conceptoPro,
        cantidad: cantProducto,
        precioUnitario: preUnitario,
        subtotal: (preUnitario * cantProducto).toFixed(2),
        stock: stock,
        categoria: categoria,
        imagen: imagen,
        preciosDisponibles: preciosArray
      };

      arregloCarrito.push(objetoDetalle);
      dibujarTablaCarrito();

      // 🧹 Limpiar formulario
      document.getElementById("codProducto").value = "";
      document.getElementById("conceptoPro").value = "";
      document.getElementById("cantProducto").value = 0;
      document.getElementById("preUnitario").value = "";
      document.getElementById("preTotal").value = "0.00";
      document.getElementById("categoria").value = "";
      document.getElementById("imagen").value = "";
    },
    error: function(xhr, status, error) {
      console.log("Error al obtener precios:", error);
      
      // Continuar sin precios adicionales
      let objetoDetalle = {
        idProducto: idProducto,
        codigoProducto: codProducto,
        descripcion: conceptoPro,
        cantidad: cantProducto,
        precioUnitario: preUnitario,
        subtotal: (preUnitario * cantProducto).toFixed(2),
        stock: stock,
        categoria: categoria,
        imagen: imagen,
        preciosDisponibles: []
      };

      arregloCarrito.push(objetoDetalle);
      dibujarTablaCarrito();

      // 🧹 Limpiar formulario
      document.getElementById("codProducto").value = "";
      document.getElementById("conceptoPro").value = "";
      document.getElementById("cantProducto").value = 0;
      document.getElementById("preUnitario").value = "";
      document.getElementById("preTotal").value = "0.00";
      document.getElementById("categoria").value = "";
      document.getElementById("imagen").value = "";
    }
  });
}

function dibujarTablaCarrito() {
  listaDetalle.innerHTML = "";

  arregloCarrito.forEach((detalle, index) => {
    let fila = document.createElement("tr");

    // Input editable para cantidad
    let inputCantidad = `<input type="number" class="form-control form-control-sm" 
value="${detalle.cantidad}" 
min="0" 
max="${detalle.stock}" 
onchange="actualizarCantidad(${index}, this.value)">`;

    // input para el precio
    let titleAttr = "Precio unitario";
    let botonPrecios = "";
    
    if (detalle.preciosDisponibles && detalle.preciosDisponibles.length > 0) {
      titleAttr = `${detalle.preciosDisponibles.length} precio(s) adicional(es) disponible(s) - Click para seleccionar`;
      botonPrecios = `
        <div class="input-group-append">
          <button type="button" class="btn btn-info btn-sm" 
                  onclick="mostrarSelectorPrecios(${index})" 
                  title="Seleccionar precio alternativo">
            <i class="fas fa-list-ul"></i> ${detalle.preciosDisponibles.length}
          </button>
        </div>`;
    }
    
    let inputPrecio = `
<div class="input-group input-group-sm">
  <input type="number" class="form-control" 
  id="precioInput${index}"
  value="${detalle.precioUnitario}" 
  onchange="actualizarPrecio(${index}, this.value)"
  step="0.01"
  min="0"
  title="${titleAttr}"
  placeholder="Precio unitario">
  ${botonPrecios}
</div>
`;

    let imagenHtml = detalle.imagen && detalle.imagen !== "" 
      ? `<img src="assest/dist/img/producto/${detalle.imagen}" alt="Imagen" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">`
      : `<div class="text-center text-muted" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;"><small>Sin imagen</small></div>`;

    fila.innerHTML =
      `<td class="text-center">${imagenHtml}</td>` +
      `<td>${detalle.codigoProducto}</td>` +
      `<td>${detalle.descripcion}</td>` +
      `<td>${detalle.categoria}</td>` +
      `<td>${inputCantidad}</td>` +
      `<td>${detalle.stock}</td>` +
      `<td>${inputPrecio}</td>` +
      `<td>${detalle.subtotal}</td>`;

    let tdEliminar = document.createElement("td");
    let botonEliminar = document.createElement("button");
    botonEliminar.classList.add("btn", "btn-danger", "btn-sm");
    botonEliminar.innerHTML = "<i class='fas fa-trash'></i>";
    botonEliminar.onclick = () => {
      eliminarCarrito(detalle.codigoProducto);
    };

    tdEliminar.appendChild(botonEliminar);
    fila.appendChild(tdEliminar);

    listaDetalle.appendChild(fila);
  });

  calcularTotal();
}

function actualizarPrecio(index, nuevoPrecio) {
  nuevoPrecio = parseFloat(nuevoPrecio) || 0;

  let producto = arregloCarrito[index];
  producto.precioUnitario = nuevoPrecio;
  producto.subtotal = (producto.cantidad * nuevoPrecio).toFixed(2);

  dibujarTablaCarrito(); // Redibuja la tabla con el nuevo subtotal
}

function mostrarSelectorPrecios(index) {
  let producto = arregloCarrito[index];
  
  if (!producto.preciosDisponibles || producto.preciosDisponibles.length === 0) {
    return;
  }
  
  // Crear opciones para el selector
  let opciones = producto.preciosDisponibles.map(p => 
    `<li><a class="dropdown-item" href="#" onclick="seleccionarPrecio(${index}, ${p.precio})">${p.concepto} - Bs. ${p.precio}</a></li>`
  ).join('');
  
  // Mostrar SweetAlert con lista de precios
  Swal.fire({
    title: 'Seleccionar Precio',
    html: `
      <div class="text-left">
        <p class="mb-3"><strong>Producto:</strong> ${producto.descripcion}</p>
        <p class="mb-3"><strong>Precio actual:</strong> Bs. ${producto.precioUnitario}</p>
        <div class="list-group">
          ${producto.preciosDisponibles.map(p => `
            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" 
                    onclick="seleccionarPrecio(${index}, ${p.precio}); Swal.close();">
              <div>
                <strong>${p.concepto}</strong>
              </div>
              <span class="badge badge-info badge-pill">Bs. ${p.precio}</span>
            </button>
          `).join('')}
        </div>
      </div>
    `,
    showConfirmButton: false,
    showCancelButton: true,
    cancelButtonText: 'Cerrar',
    width: '500px',
    customClass: {
      htmlContainer: 'text-left'
    }
  });
}

function seleccionarPrecio(index, precio) {
  // Actualizar el precio en el arreglo
  actualizarPrecio(index, precio);
  
  // Mostrar notificación de éxito
  Swal.fire({
    icon: 'success',
    title: 'Precio Actualizado',
    text: `Nuevo precio: Bs. ${precio}`,
    timer: 1500,
    showConfirmButton: false
  });
}

function actualizarCantidad(index, nuevaCantidad) {
  nuevaCantidad = parseInt(nuevaCantidad) || 1;

  let producto = arregloCarrito[index];

  // Validar que no supere el stock
  if (nuevaCantidad > producto.stock) {
    alert("La cantidad no puede superar el stock disponible.");
    nuevaCantidad = producto.stock;
  }

  producto.cantidad = nuevaCantidad;
  producto.subtotal = (producto.precioUnitario * nuevaCantidad).toFixed(2);

  dibujarTablaCarrito(); // Redibuja la tabla con los nuevos valores
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

function calcularTotal() {
  let totalCarrito = 0;

  for (let i = 0; i < arregloCarrito.length; i++) {
    let subtotal = parseFloat(arregloCarrito[i].subtotal) || 0;
    totalCarrito += subtotal;
  }

  document.getElementById("totVenta").innerHTML = totalCarrito.toFixed(2);

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

// Función específica para buscar productos en notas de salida
function busProductoNS(){
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

      if (data && data["id_producto"]) {
        document.getElementById("idProducto").value = data["id_producto"]
        document.getElementById("conceptoPro").value = data["nombre_producto"]
        document.getElementById("preUnitario").value = data["precio"]
        document.getElementById("stock").value = data["stock"] || 0
        document.getElementById("cantProducto").value = 1
        document.getElementById("categoria").value = data["categoria"] || ''
        document.getElementById("imagen").value = data["imagen_producto"] || ''
      } else {
        // Producto no encontrado - limpiar campos
        document.getElementById("idProducto").value = ""
        document.getElementById("conceptoPro").value = ""
        document.getElementById("stock").value = 0
        document.getElementById("preUnitario").value = ""
        document.getElementById("cantProducto").value = 0
        document.getElementById("categoria").value = ""
        document.getElementById("imagen").value = ""
      }
    },
    error: function() {
      // Error en la petición AJAX
      alert("Error al buscar el producto");
    }
  })
}

//**** carrito de nota de salida ******
var arregloCarritoNS=[]
var totalCarritoNS = 0
var listaDetalleNS=document.getElementById("listaDetalleNS")
function agregarCarritoNS(){

  let idProducto = parseInt(document.getElementById("idProducto").value)
  let codProducto = document.getElementById("codProducto").value
  let conceptoPro = document.getElementById("conceptoPro").value
  let cantProducto = parseInt(document.getElementById("cantProducto").value)
  let preUnitario = parseFloat(document.getElementById("preUnitario").value)
  let categoria = document.getElementById("categoria").value || ""
  let imagen = document.getElementById("imagen").value || ""
  let preTotal = parseFloat(cantProducto * preUnitario)

  let objetoDetalle = {
    idProducto:idProducto,
    codigoProducto:codProducto,
    descripcion:conceptoPro,
    cantidad:cantProducto,
    precioUnitario:preUnitario,
    categoria:categoria,
    imagen:imagen,
    subtotal:preTotal
  }

  arregloCarritoNS.push(objetoDetalle)

  dibujarTablaCarritoNS()

  // borrar formulario carrito
  document.getElementById("codProducto").value=""
  document.getElementById("conceptoPro").value=""
  document.getElementById("cantProducto").value=0
  document.getElementById("stock").value=0
  document.getElementById("preUnitario").value=""
  document.getElementById("categoria").value=""
  document.getElementById("imagen").value=""
}

function dibujarTablaCarritoNS(){
  listaDetalleNS.innerHTML = ""

  arregloCarritoNS.forEach(
    (detalle)=>{
      let fila=document.createElement("tr")

      let imagenHtml = detalle.imagen && detalle.imagen !== "" 
        ? `<img src="assest/dist/img/producto/${detalle.imagen}" alt="Imagen" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">`
        : `<div class="text-center text-muted" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;"><small>Sin imagen</small></div>`;

      fila.innerHTML = `<td class="text-center">${imagenHtml}</td>` +
        `<td>${detalle.codigoProducto}</td>` +
        `<td>${detalle.descripcion}</td>` +
        `<td>${detalle.categoria}</td>` +
        `<td>${detalle.precioUnitario}</td>` +
        `<td>${detalle.cantidad}</td>` +
        `<td>${detalle.subtotal}</td>`

      let tdEliminar = document.createElement("td")
      let botonEliminar = document.createElement("button")
      botonEliminar.classList.add("btn", "btn-danger", "btn-sm")
      botonEliminar.innerHTML="<i class='fas fa-trash'></i>"
      botonEliminar.onclick=()=>{
        eliminarCarritoNS(detalle.codigoProducto)
      }

      tdEliminar.appendChild(botonEliminar)
      fila.appendChild(tdEliminar)

      listaDetalleNS.appendChild(fila)
    })

  calcularTotalNS()
}

function eliminarCarritoNS(cod){
  arregloCarritoNS = arregloCarritoNS.filter((detalle)=>{
    if(cod!=detalle.codigoProducto){
      return detalle
    }
  })

  dibujarTablaCarritoNS()
  calcularTotalNS()
}

function calcularTotalNS(){
  totalCarritoNS = 0
  for(var i=0; i<arregloCarritoNS.length; i++){
    totalCarritoNS = totalCarritoNS + parseFloat(arregloCarritoNS[i].subtotal)
  }
  
  // Actualizar el total mostrado en la tabla
  document.getElementById("totSalida").innerHTML = totalCarritoNS.toFixed(2);
}

function RegNotaSalida(){
  var formData = new FormData($("#FSalidaOtros")[0])
  formData.append("carritoNS", JSON.stringify(arregloCarritoNS));
  formData.append("totalNS", totalCarritoNS);


  $.ajax({
    type: "POST",
    url: "controlador/salidaControlador.php?ctrRegNotaSalida",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'Nota de Salida registrada',
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

function MVerNotaSalida(id) {
  $("#modal-xl").modal("show")
  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/salida/MVerNotaSalida.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-xl").html(data)
    }
  })
}

function MEliNotaSalida(id) {
  var obj = {
    id: id
  }

  Swal.fire({
    title: 'Esta seguro de eliminar esta nota de salida?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/salidaControlador.php?ctrEliNotaSalida",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Nota de Salida eliminada',
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

function FormQrPago(){
  $("#modal-default").modal("show")

  var obj=""
  $.ajax({
    type:"POST",
    url:"vista/venta/FormQrPago.php",
    data:obj,
    success:function(data){
      $("#content-default").html(data)
    }
  })
}

function previsualizarQr() {
  let inputFile = document.getElementById("imgQrPago");
  let imagen = inputFile.files[0];

  if (!imagen) return;

  // Mostrar nombre del archivo en el label
  $(".custom-file-label").text(imagen.name);

  // Validación de formato
  if (imagen.type !== "image/png" && imagen.type !== "image/jpeg" && imagen.type !== "image/jpg") {
    $("#imgQrPago").val("");
    $(".custom-file-label").text("Elegir archivo");
    Swal.fire({
      icon: "error",
      showConfirmButton: true,
      title: "La imagen debe ser formato PNG, JPG o JPEG"
    });
    return;
  }

  // Validación de tamaño
  if (imagen.size > 10000000) { // 10 MB
    $("#imgQrPago").val("");
    $(".custom-file-label").text("Elegir archivo");
    Swal.fire({
      icon: "error",
      showConfirmButton: true,
      title: "La imagen no debe superar los 10MB"
    });
    return;
  }

  // Previsualizar imagen
  let datosImagen = new FileReader();
  datosImagen.onload = function (event) {
    $(".previsualizarQr").attr("src", event.target.result);
  };
  datosImagen.readAsDataURL(imagen);
}

function EditQr(){

  var formData= new FormData($("#FormEditQr")[0])

  $.ajax({
    type:"POST",
    url:"controlador/salidaControlador.php?ctrEditQr",
    data:formData,
    cache:false,
    contentType:false,
    processData:false,
    success:function(data){

      if(data=="ok"){
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'QR Actualizado',
          timer: 1000
        })
        setTimeout(function(){
          location.reload()
        },1200)
      }else{
        Swal.fire({
          icon:'error',
          title:'Error!',
          text:'Error de actualizacion',
          showConfirmButton: false,
          timer:1500
        })
      }
    }
  })
}

function mostrarQr(){
  $("#modal-default").modal("show")

  var obj=""
  $.ajax({
    type:"POST",
    url:"vista/venta/imgQrPago.php",
    data:obj,
    success:function(data){
      $("#content-default").html(data)
    }
  })
}

//**** carrito traspaso ******
function busProductoTs(){
  let almacenOrigen = document.getElementById("almacen_origen").value;

  if (!almacenOrigen) {
    document.getElementById("almacen_origen").classList.add("is-invalid");
    return;
  } else {
    document.getElementById("almacen_origen").classList.remove("is-invalid");
  }

  let codProducto = document.getElementById("codProducto").value

  var obj={
    codProducto:codProducto,
    almacenOrigen: almacenOrigen
  }

  $.ajax({
    type:"POST",
    url:"controlador/productoControlador.php?ctrBusProductoTs",
    data:obj,
    dataType:"json",
    success:function(data){

      document.getElementById("idProducto").value = data["id_producto"]
      document.getElementById("conceptoPro").value = data["nombre_producto"]
      document.getElementById("stock").value = data["stock"]
      document.getElementById("cantProducto").value=1
      document.getElementById("costoProducto").value=data["costo"]
      document.getElementById("categoria").value = data["categoria"] || ''
      document.getElementById("imagen").value = data["imagen_producto"] || ''

      // 🔥 Aquí actualizámos el atributo max según el stock recibido
      document.getElementById("cantProducto").setAttribute("max", data["stock"]);


    }
  })
}

var arregloCarritoTs=[]
var listaDetalleTs=document.getElementById("listaDetalleTs")
function agregarCarritoTs(){

  let idProducto = document.getElementById("idProducto").value
  let codProducto = document.getElementById("codProducto").value
  let conceptoPro = document.getElementById("conceptoPro").value
  let cantProducto = parseInt(document.getElementById("cantProducto").value)
  let costoProducto = parseFloat(document.getElementById("costoProducto").value)
  let categoria = document.getElementById("categoria").value || ""
  let imagen = document.getElementById("imagen").value || ""

  let objetoDetalle = {
    idProducto:idProducto,
    codigoProducto:codProducto,
    descripcion:conceptoPro,
    cantidad:cantProducto,
    costo:costoProducto,
    categoria:categoria,
    imagen:imagen
  }

  arregloCarritoTs.push(objetoDetalle)

  dibujarTablaCarritoTs()

  // borrar formulario carrito
  document.getElementById("codProducto").value=""
  document.getElementById("conceptoPro").value=""
  document.getElementById("stock").value=0
  document.getElementById("cantProducto").value=0
  document.getElementById("costoProducto").value=0
  document.getElementById("categoria").value=""
  document.getElementById("imagen").value=""

}

function dibujarTablaCarritoTs(){
  listaDetalleTs.innerHTML = ""

  arregloCarritoTs.forEach(
    (detalle)=>{
      let fila=document.createElement("tr")

      let imagenHtml = detalle.imagen && detalle.imagen !== "" 
        ? `<img src="assest/dist/img/producto/${detalle.imagen}" alt="Imagen" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">`
        : `<div class="text-center text-muted" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;"><small>Sin imagen</small></div>`;

      fila.innerHTML = `<td class="text-center">${imagenHtml}</td>` +
        `<td>${detalle.codigoProducto}</td>` +
        `<td>${detalle.descripcion}</td>` +
        `<td>${detalle.categoria}</td>` +
        `<td>${detalle.cantidad}</td>`

      let tdEliminar = document.createElement("td")
      let botonEliminar = document.createElement("button")
      botonEliminar.classList.add("btn", "btn-danger", "btn-sm")
      botonEliminar.innerHTML="<i class='fas fa-trash'></i>"
      botonEliminar.onclick=()=>{
        eliminarCarritoTs(detalle.codigoProducto)
      }

      tdEliminar.appendChild(botonEliminar)
      fila.appendChild(tdEliminar)

      listaDetalleTs.appendChild(fila)
    })

}

function eliminarCarritoTs(cod){
  arregloCarritoTs = arregloCarritoTs.filter((detalle)=>{
    if(cod!=detalle.codigoProducto){
      return detalle
    }
  })

  dibujarTablaCarritoTs()

}

function RegTraspaso(){
  var formData = new FormData($("#FNotaTraspaso")[0])
  formData.append("carritoTraspaso", JSON.stringify(arregloCarritoTs));

  $.ajax({
    type: "POST",
    url: "controlador/salidaControlador.php?ctrRegNotaTraspaso",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {

      if (data == "ok") {
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'Traspaso registrado',
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

function MVerNotaTraspaso(id) {
  $("#modal-xl").modal("show")
  var obj = ""
  $.ajax({
    type: "POST",
    url: "vista/salida/MVerNotaTraspaso.php?id=" + id,
    data: obj,
    success: function (data) {
      $("#content-xl").html(data)
    }
  })
}

function MEliNotaTraspaso(id){
  var obj = {
    id: id
  }

  Swal.fire({
    title: 'Esta seguro de eliminar esta nota de traspaso?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        data: obj,
        url: "controlador/salidaControlador.php?ctrEliNotaTraspaso",
        success: function (data) {

          if (data == "ok") {
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Nota de traspaso eliminada',
              timer: 1000
            })
            setTimeout(function () {
              location.reload()
            }, 1200)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!!!',
              text: 'La nota no puede ser eliminada',
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })



    }
  })
}

