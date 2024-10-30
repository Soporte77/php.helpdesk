var tabla;
function init(){

}
//quiero una funcion de javascript que me ayude con la suma de 2 numeros
$(document).ready(function(){
    var usu_id = $('#user_idx').val();

    /* TODO: Llenar graficos segun rol  */
    if ( $('#rol_idx').val() == 1){
        $.post("../../controller/usuario.php?op=total", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        }); 

        $.post("../../controller/usuario.php?op=totalabierto", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=grafico", {usu_id:usu_id},function (data) {
            data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value'],
                barColors: ["#1AB244"], 
            });
        }); 


    }else{
        $.post("../../controller/ticket.php?op=total",function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=totalabierto",function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=totalcerrado", function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=grafico",function (data) {
            data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value']
            });
        });

          //grafico soporte
          $.post("../../controller/usuario.php?op=graficoSoporte",  function (data) {
            data = JSON.parse(data);
            $('#lblDatosSoporte').html(data);
        });
    }

});

//metodos para ver usuarios tickets
function verUsuarios(soporte_id,calificacion){
    try {


    $('#mdltitulo').html('Usuarios que Calificaron '+calificacion+' Estrellas');

    $.post("../../controller/usuario.php?op=mostrarCalificaciones", {usu_id : soporte_id,calificacion:calificacion}, function (data) {
        data = JSON.parse(data);
        $('#lblTabla').html(data);
    }); 
    /* TODO: Mostrar Modal */
    $('#modalCalificaciones').modal('show');
    }catch (error) {

    }
}
init();