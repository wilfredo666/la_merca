function MNuevoAlmacen(){
  $("#modal-default").modal("show")

  var obj=""
  $.ajax({
    type:"POST",
    url:"vista/almacen/FNuevoAlmacen.php",
    data:obj,
    success:function(data){
      $("#content-default").html(data)
    }
  })
}

function RegAlmacen(){

    var formData= new FormData($("#FormRegAlmacen")[0])

    $.ajax({
      type:"POST",
      url:"controlador/almacenControlador.php?ctrRegAlmacen",
      data:formData,
      cache:false,
      contentType:false,
      processData:false,
      success:function(data){
        console.log(data)
        if(data=="ok"){
          Swal.fire({
            icon: 'success',
            showConfirmButton: false,
            title: 'El almacen ha sido registrado',
            timer: 1000
          })
          setTimeout(function(){
            location.reload()
          },1200)
        }else{
          Swal.fire({
            icon:'error',
            title:'Error!',
            text:'El almacen ya esta en uso',
            showConfirmButton: false,
            timer:1500
          })
        }
      }
    })
}

function MEditAlmacen(id){
  $("#modal-default").modal("show")

  var obj=""
  $.ajax({
    type:"POST",
    url:"vista/almacen/FEditAlmacen.php?id="+id,
    data:obj,
    success:function(data){
      $("#content-default").html(data)
    }
  })
}

function EditAlmacen(){

    var formData= new FormData($("#FormEditAlmacen")[0])

    $.ajax({
      type:"POST",
      url:"controlador/almacenControlador.php?ctrEditAlmacen",
      data:formData,
      cache:false,
      contentType:false,
      processData:false,
      success:function(data){

        if(data=="ok"){
          Swal.fire({
            icon: 'success',
            showConfirmButton: false,
            title: 'El Almacen ha sido actualizado',
            timer: 1000
          })
          setTimeout(function(){
            location.reload()
          },1200)
        }else{
          Swal.fire({
            icon:'error',
            title:'Error!',
            text:'No se ha podido actualizar!!!',
            showConfirmButton: false,
            timer:1500
          })
        }
      }
    })

}

function MEliAlmacen(id){
  var obj={
    id:id
  }

  Swal.fire({
    title:'¿Esta seguro de eliminar este Almacen?',
    showDenyButton:true,
    showCancelButton:false,
    confirmButtonText:'Confirmar',
    denyButtonText:'Cancelar'    
  }).then((result)=>{
    if(result.isConfirmed){
      $.ajax({
        type:"POST",
        data:obj,
        url:"controlador/almacenControlador.php?ctrEliAlmacen",
        success:function(data){

          if(data=="ok"){
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              title: 'Almacen eliminado',
              timer: 1000
            })
            setTimeout(function(){
              location.reload()
            },1200)
          }else{
            Swal.fire({
              icon:'error',
              title:'Error!!!',
              text:'El Almacen no puede ser eliminado, porque es un Almacen activo',
              showConfirmButton:false,
              timer:1900
            })
          }
        }
      })

    }
  })
}


$(document).on('click', '.estadoAlmacen', function(e) {
  e.preventDefault();

  let $this = $(this);
  let est = $this.data('est');
  let id = $this.data('id');
  
// Cambias el valor antes de enviarlo
  if(est==1){
    est=0
  }else{
    est=1
  }

  var obj={
    est:est,
    id:id
  }

  $.ajax({
    type:"POST",
    url:"controlador/AlmacenControlador.php?ctrCambioEstado",
    data:obj,
    success: function(data){

      if(data === "ok" && est == 0){
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
function actualizarPermiso(idAlmacen, idPermiso) {
  var obj = {
    idAlmacen: idAlmacen,
    idPermiso: idPermiso
  }

  $.ajax({
    type: "POST",
    url: "controlador/AlmacenControlador.php?ctrActualizarPermiso",
    data: obj,
    success: function(data) {
    }
  })
}
