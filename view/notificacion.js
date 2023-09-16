$(document).ready(function(){

    mostrar_notificacion();

});
let isFlashing = false;
let originalTitle = document.title;
var msgNotificacion = ""
function mostrar_notificacion(){
    var formData = new FormData();
    var usu_id = $('#user_idx').val();
    var rol_id =  $('#rol_idx').val();
    formData.append('usu_id',$('#user_idx').val());
    formData.append('rol_id',rol_id);
    $.ajax({
        url: "../../controller/notificacion.php?op=mostrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            if (data==''){

            }else{
                data = JSON.parse(data);
                msgNotificacion = data.not_mensaje
                //solo para los administradores pueden ver el nuevo ticket creado en notificacion
                if (data.not_mensaje.includes("Nuevo")) {
                    if(rol_id != 3){
                        return
                    }else{
                        $.notify({
                            icon: 'glyphicon glyphicon-star',
                            message: data.not_mensaje,
                            url: "http:/localhost/HelpDesk/view/DetalleTicket/?ID="+data.tick_id
                        });
                        $.post("../../controller/notificacion.php?op=actualizar", {not_id : data.not_id}, function (data) {
        
                        });
                        mostrarPestana()
                    }
                } else{
                    console.log("normal")
                    if(rol_id == 3){
                        return
                    }
                    mostrarPestana()
                    $.notify({
                        icon: 'glyphicon glyphicon-star',
                        message: data.not_mensaje,
                        url: "http:/localhost/HelpDesk/view/DetalleTicket/?ID="+data.tick_id
                    });
                    $.post("../../controller/notificacion.php?op=actualizar", {not_id : data.not_id}, function (data) {
    
                    });
                }
            }
        }
    });

}

// Función para cambiar el favicon
function changeFavicon(newFavicon) {
const faviconElement = document.getElementById('favicon');
faviconElement.href = 'https://cdn-icons-png.flaticon.com/512/1182/1182718.png';
}
function changeFavicon2(){
    const faviconElement = document.getElementById('favicon');
faviconElement.href = 'https://cdn-icons-png.flaticon.com/512/94/94717.png';
}
function mostrarPestana(){
    const intervalId = setInterval(flashTitleAndFavicon, 1000); // Flash cada 1 segundo
    setTimeout(function() {
      clearInterval(intervalId);
      document.title = originalTitle; // Restaura el título original
      changeFavicon2(); // Restaura el favicon original
    }, 20000); // Detiene el efecto después de 5 segundos
}



// Función para alternar el título de la pestaña y el favicon
function flashTitleAndFavicon() {
  if (isFlashing) {
    document.title = msgNotificacion;
    changeFavicon(); // Cambia al favicon de alerta
  } else {
    document.title = originalTitle;
    changeFavicon(); // Cambia al favicon normal
  }
  isFlashing = !isFlashing;
}

setInterval(function(){
    mostrar_notificacion();
}, 5000);


