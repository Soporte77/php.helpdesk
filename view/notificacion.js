$(document).ready(function(){

    mostrar_notificacion();

});

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
                //solo para los administradores pueden ver el nuevo ticket creado en notificacion
                if (data.not_mensaje.includes("Nuevo")) {
                    if(rol_id != 3){
                        return
                    }
                } 
                $.notify({
                    icon: 'glyphicon glyphicon-star',
                    message: data.not_mensaje,
                    url: "http:/localhost/HelpDesk/view/DetalleTicket/?ID="+data.tick_id
                });
                $.post("../../controller/notificacion.php?op=actualizar", {not_id : data.not_id}, function (data) {

                });
            }
        }
    });

}

setInterval(function(){
    mostrar_notificacion();
}, 5000);


