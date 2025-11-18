function MNuevoCaja(){
  $("#modal-default").modal('show');

  var obj="";
  $.ajax({
    type:"POST",
    url:"vista/caja/FRegCaja.php",
    data:obj,
    success:function(data){

      $("#content-default").html(data);
    }
  });
}

//*pendiente el uso
// function MEditCaja(id){
//   $("#modal-lg").modal('show');

//   var obj="";
//   $.ajax({
//     type:"POST",
//     url:"vista/caja/FEditCaja.php?id="+id,
//     data:obj,
//     success:function(data){
//       $("#content-lg").html(data);
//     }
//   });
// }

function MEliCaja(id){
  var obj = {
    id: id
  };

  Swal.fire({
    title: '¿Está seguro de eliminar este movimiento de caja?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: 'Confirmar',
    denyButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "controlador/cajaControlador.php?ctrEliCaja",
        data: obj,
        success: function(data) {
          if(data == "ok"){
            location.reload();
          } else {
            alert("Error al eliminar el movimiento");
          }
        }
      });
    }
  });
}

function RegCaja(){
  var formData = new FormData($("#FormRegCaja")[0]);

  $.ajax({
    type: "POST",
    url: "controlador/cajaControlador.php?ctrRegCaja",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
      if(data == "ok"){
        Swal.fire({
          icon: 'success',
          showConfirmButton: false,
          title: 'Movimiento de caja registrado',
          timer: 1000
        });
        setTimeout(function(){
          location.reload();
        }, 1200);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo registrar el movimiento',
          showConfirmButton: true
        });
      }
    }
  });
}

//*pendiente el uso
// function EditCaja(){
//   var formData = new FormData($("#FormEditCaja")[0]);

//   $.ajax({
//     type: "POST",
//     url: "controlador/cajaControlador.php?ctrEditCaja",
//     data: formData,
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function(data){
//       if(data == "ok"){
//         Swal.fire({
//           icon: 'success',
//           showConfirmButton: false,
//           title: 'Movimiento de caja actualizado',
//           timer: 1000
//         });
//         setTimeout(function(){
//           location.reload();
//         }, 1200);
//       } else {
//         Swal.fire({
//           icon: 'error',
//           title: 'Error',
//           text: 'No se pudo actualizar el movimiento',
//           showConfirmButton: true
//         });
//       }
//     }
//   });
// }

// Función para calcular automáticamente el saldo
function calcularSaldo() {
  var tipo = $("#tipo").val();
  var cantidad = parseFloat($("#cantidad").val()) || 0;
  
  // Aquí podrías hacer una llamada AJAX para obtener el saldo actual
  // y mostrar una previsualización del nuevo saldo
}

// Event listeners
$(document).ready(function() {
  // Evento para calcular saldo al cambiar tipo o cantidad
  $("#tipo, #cantidad").on('change keyup', function() {
    calcularSaldo();
  });
});