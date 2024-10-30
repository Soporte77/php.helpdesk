var tabla;
function init() {
    $("#usuario_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}
$(document).ready(function(){
    // Obtener la fecha actual
    const today = new Date();

    // Calcular el primer día de la semana (Lunes)
    const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 1));
    
    // Calcular el último día de la semana (Domingo)
    const lastDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 7));

    // Convertir las fechas a formato YYYY-MM-DD
    const formatDate = (date) => date.toISOString().slice(0, 10);

    // Asignar las fechas a los inputs
    document.getElementById('fechadesde').value = formatDate(firstDayOfWeek);
    // document.getElementById('fechadesde').value = "2023-12-12"
    document.getElementById('fechahasta').value = formatDate(lastDayOfWeek);
    listardatatable();
});

function filtrarPorFechas() {
    var fechaDesde = $("#fechadesde").val();
    var fechaHasta = $("#fechahasta").val();

    console.log("Fecha Desde: " + fechaDesde);
    console.log("Fecha Hasta: " + fechaHasta);

    if (fechaDesde === "" || fechaHasta === "") {
        swal({
            title: "Advertencia!",
            text: "Debe seleccionar ambas fechas.",
            type: "warning",
            confirmButtonClass: "btn-warning"
        });
        return;
    }

    // Recargar la tabla con las fechas filtradas
    tabla = $('#usuario_data2').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ajax": {
            url: '../../controller/reporte.php?op=listar_fecha',
            type: "post",
            dataType: "json",
            data: {
                fechadesde: fechaDesde,
                fechahasta: fechaHasta
            },
            error: function(e) {
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    }).DataTable().ajax.reload();

    tabla.order([4, 'asc']).draw();
}
/* TODO:Filtro avanzado */
$(document).on("click","#btnfiltrar", function(){
    limpiar();
    filtrarPorFechas();

});
function listardatatable(){
    var fechaDesde = $("#fechadesde").val();
    var fechaHasta = $("#fechahasta").val();

    console.log("Fecha Desde1: " + fechaDesde);
    console.log("Fecha Hasta: " + fechaHasta);

    if (fechaDesde === "" || fechaHasta === "") {
        swal({
            title: "Advertencia!",
            text: "Debe seleccionar ambas fechas.",
            type: "warning",
            confirmButtonClass: "btn-warning"
        });
        return;
    }
    console.log("pasooo")
    tabla=$('#usuario_data2').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/reporte.php?op=listar_fecha',
            type : "post",
            dataType : "json",
            data:{ 
                fechadesde: fechaDesde,
                fechahasta: fechaHasta
            },
            success:function(e){
                console.log("test",e)
            },
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable().ajax.reload();
    tabla.order([0, 'DESC']).draw();
}

/* TODO: Limpiamos restructurando el html del datatable js */
function limpiar(){
    $('#table').html(
        "<table id='usuario_data2' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
            "<thead>"+
                "<tr>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Folio</th>"+
                    
                    "<th style='width: 15%;'>Dependencia</th>"+
                    "<th style='width: 15%;'>Titulo</th>"+
					"<th style='width: 15%;'>Descripcion</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 30%;'>Estado</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Fecha Creacion</th>"+
                   
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Cierre</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Asignación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Usuario</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Soporte</th>" +   
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Categoria</th>" +   
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Area</th>" +   
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Subcategoria</th>" +   
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Prioridad</th>" + 
                "</tr>"+
            "</thead>"+
            "<tbody>"+

            "</tbody>"+
        "</table>"
    );
}
// $(document).ready(function() {
//     // Inicializar la tabla
//     tabla = $('#usuario_data').DataTable({
//         "aProcessing": true,
//         "aServerSide": true,
//         dom: 'Bfrtip',
//         "searching": true,
//         lengthChange: false,
//         colReorder: true,
//         buttons: [
//             'copyHtml5',
//             'excelHtml5',
//             'csvHtml5',
//             'pdfHtml5'
//         ],
//         "ajax": {
//             url: '../../controller/reporte.php?op=listar',
//             type: "post",
//             dataType: "json",
//             error: function(e) {
//                 console.log("aa",e)
//             }
//         },
//         "bDestroy": true,
//         "responsive": true,
//         "bInfo": true,
//         "iDisplayLength": 10,
//         "autoWidth": false,
//         "language": {
//             "sProcessing": "Procesando...",
//             "sLengthMenu": "Mostrar _MENU_ registros",
//             "sZeroRecords": "No se encontraron resultados",
//             "sEmptyTable": "Ningún dato disponible en esta tabla",
//             "sInfo": "Mostrando un total de _TOTAL_ registros",
//             "sInfoEmpty": "Mostrando un total de 0 registros",
//             "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
//             "sSearch": "Buscar:",
//             "sLoadingRecords": "Cargando...",
//             "oPaginate": {
//                 "sFirst": "Primero",
//                 "sLast": "Último",
//                 "sNext": "Siguiente",
//                 "sPrevious": "Anterior"
//             }
//         }
//     }).DataTable().ajax.reload();
    
//     tabla.order([4, 'asc']).draw();
// });

// Inicializar la configuración al cargar la página
init();

setInterval(function(){
    console.log("Recargando tabla...");
    $('#usuario_data2').DataTable().ajax.reload();
}, 300000);