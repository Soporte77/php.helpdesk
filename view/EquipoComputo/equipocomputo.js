var tabla;

function init(){
    $("#equipo_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

$(document).ready(function(){
    /* TODO: Cargar información en el datatable */
    tabla=$('#equipo_data').dataTable({
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
            url: '../../controller/equipocomputo.php?op=listar',
            type : "get",
            dataType : "json",						
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
    }).DataTable();
});

function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#equipo_form")[0]);
    $.ajax({
        url: "../../controller/equipocomputo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            $('#equipo_form')[0].reset();
            $("#modalequipo").modal('hide');
            $('#equipo_data').DataTable().ajax.reload();

            swal({
                title: "Equipo de Cómputo",
                text: "Guardado Correctamente",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

function editar(equipo_id){
    $('#mdltitulo').html('Editar Equipo');
    $.post("../../controller/equipocomputo.php?op=mostrar", {equipo_id : equipo_id}, function (data) {
        data = JSON.parse(data);
        $('#equipo_id').val(data.equipo_id);
        $('#tipo_equipo').val(data.tipo_equipo);
        $('#marca').val(data.marca);
        $('#modelo').val(data.modelo);
        $('#serie').val(data.serie);
        $('#inventario').val(data.inventario);
        $('#procesador').val(data.procesador);
        $('#ram').val(data.ram);
        $('#disco').val(data.disco);
        $('#sistema_operativo').val(data.sistema_operativo);
        $('#usuario_asignado').val(data.usuario_asignado);
        $('#departamento').val(data.departamento);
        $('#ubicacion').val(data.ubicacion);
        $('#fecha_compra').val(data.fecha_compra);
        $('#estado_equipo').val(data.estado_equipo);
        $('#observaciones').val(data.observaciones);
    }); 
    $('#modalequipo').modal('show');
}

function eliminar(equipo_id){
    swal({
        title: "Equipo de Cómputo",
        text: "¿Está seguro de eliminar el registro?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/equipocomputo.php?op=eliminar", {equipo_id : equipo_id}, function (data) {

            }); 

            $('#equipo_data').DataTable().ajax.reload();	

            swal({
                title: "Equipo de Cómputo",
                text: "Registro Eliminado correctamente.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Equipo de Cómputo');
    $('#equipo_form')[0].reset();
    $('#modalequipo').modal('show');
});

init();
