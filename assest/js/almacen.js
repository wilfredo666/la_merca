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
            text:'El almacen no se puede registrar',
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
