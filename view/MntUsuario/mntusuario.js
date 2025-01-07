var tabla;

function init(){
    $("#usuario_form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

/* TODO: Guardar datos de los input */
function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#usuario_form")[0]);
    formData.append("files[]", $('#fileFoto')[0].files[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){    
            console.log(datos + " Guardar");
            $('#usuario_form')[0].reset();
            /* TODO:Ocultar Modal */
            $("#modalmantenimiento").modal('hide');
            $('#usuario_data').DataTable().ajax.reload();

            /* TODO:Mensaje de Confirmacion */
            swal({
                title: "Peticiones!",
                text: "Completado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}






$(document).ready(function(){
    //$("#modalmantenimiento input[type='text']").val(''); // Esto eliminará el texto en los campos de entrada
    
  
    /*$.post("../../controller/dependencia.php?op=combo",function(data, status){
        $('#dep_id').html(data);
    });

    $("#dep_id").change(function(){
        dep_id = $(this).val();
        console.log(dep_id);
        /* TODO: llenar Combo subcategoria segun cat_id */
        /*$.post("../../controller/departamento.php?op=combo",{dep_id : dep_id},function(data, status){
            console.log(data+"Aqui");
            $('#depto_id').html(data);
        });
    });*/

    // Ocultar los elementos después de asignar valores
   

   
    tabla=$('#usuario_data').dataTable({
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
            url: '../../controller/usuario.php?op=listar',
            type : "post",
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

/* TODO: Mostrar informacion segun ID en los inputs */
function editar(usu_id){

  
 
     // Elimina los elementos existentes si es necesario
     $('#combo_dep_id').remove();
     $('#combo_depto_id').remove();
    
    $("#modalmantenimiento input[type='text']").val(''); // Esto eliminará el texto en los campos de entrada
    

    $('#mdltitulo').html('Editar Registro');

    /* TODO: Mostrar Informacion en los inputs */
    $.post("../../controller/usuario.php?op=mostrar", {usu_id : usu_id}, function (data) {
        // Mostrar los elementos
        $('#dep_id').show();
        $('#depto_id').show();
        //limpiar o dejar vacio .nueva_pass
        $("#nueva_pass").val('');
        
        data = JSON.parse(data);
        console.log(data);
        $('#usu_id').val(data.usu_id);
        $('#usu_numemp').val(data.usu_numemp);
        $('#usu_nom').val(data.usu_nom);
        $('#usu_ape').val(data.usu_ape);
        $('#usu_ape').val(data.usu_ape);
        $('#dep_id').val(data.dep_nom);
        $('#depto_id').val(data.depto_nom);
        $('#usu_correo').val(data.usu_correo);
        $('#usu_pass').val(data.usu_pass);
        $('#rol_id').val(data.rol_id).trigger('change');
        $('#usu_telf').val(data.usu_telf);
        $('#usu_foto').attr('src', data.usu_foto);
        $('#textFoto').val(data.textFoto);
        console.log(data.depto_id + " Editar");

        $("#dep_id").prop("disabled", true);
        $("#depto_id").prop("disabled", true);
        $("#usu_pass").prop("disabled", true);
        $(".grupo_nueva_pass").css("display", "block");

    }); 

    /* TODO: Mostrar Modal */
    $('#modalmantenimiento').modal('show');

    
}

/* TODO: Cambiar estado a eliminado en caso de confirmar mensaje */
function eliminar(usu_id){
    swal({
        title: "Peticiones",
        text: "Esta seguro de Eliminar el registro?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/usuario.php?op=eliminar", {usu_id : usu_id}, function (data) {

            }); 

            $('#usuario_data').DataTable().ajax.reload();	

            swal({
                title: "Peticiones!",
                text: "Registro Eliminado.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

/* TODO: Limpiar Inputs */
$(document).on("click","#btnnuevo", function(){
   

    // Ocultar los inputs al cargar la página de edición
 
    $('#dep_id').hide();
    $('#depto_id').hide();


    // Elimina los elementos existentes si es necesario
    $('#combo_dep_id').remove();
    $('#combo_depto_id').remove();




   // Crea los nuevos elementos select y asignales un ID y nombre
    var $comboDep = $("<select>")
        .attr("id", "combo_dep_id")
        .attr("name", "combo_dep_id")
        .addClass("select2 form-control tx-uppercase"); // Agrega las clases CSS necesarias
    
    // Crea un nuevo elemento label
    var $labelDep = $("<label>")
    .addClass("form-control-label") // Agrega las clases CSS necesarias
    .attr("for", "combo_dep_id")
    .text("");


    // Crea el elemento form-group y agrega el label y el select
    var $formGroup = $("<div>")
    .addClass("form-group")
    .append($labelDep)
    .append($comboDep);





    var $comboDepto = $("<select>")
        .attr("id", "combo_depto_id")
        .attr("name", "combo_depto_id")
        .addClass("select2 form-control tx-uppercase"); // Agrega las clases CSS necesarias

     // Crea un nuevo elemento label
     var $labelDepto = $("<label>")
     .addClass("form-control-label") // Agrega las clases CSS necesarias
     .attr("for", "combo_depto_id")
     .text("");
 
 
     // Crea el elemento form-group y agrega el label y el select
     var $formGroupDepto = $("<div>")
     .addClass("form-group")
     .append($labelDepto)
     .append($comboDepto);

      // Agrega el nuevo select y label después del contenedor existente
    $('.form-group:contains("Dependencia")').append($labelDep).append($comboDep);


     // Agrega el nuevo select y label después del contenedor existente
     $('.form-group:contains("Departamento")').append($labelDepto).append($comboDepto);



    // Agrega los elementos select al formulario o donde desees
    $("#modalmantenimiento .modal-body").append($formGroup);
    $("#modalmantenimiento .modal-body").append($formGroupDepto);

    // Ahora puedes llenar los combos, por ejemplo, con datos AJAX

    
    $.post("../../controller/dependencia.php?op=combo",function(data, status){
        $('#combo_dep_id').html(data);
    });


    $("#combo_dep_id").change(function(){
        dep_id = $(this).val();

        console.log(combo_dep_id + " Nuevo");
        /* TODO: llenar Combo subcategoria segun cat_id */
        $.post("../../controller/departamento.php?op=mostrar",{dep_id : dep_id},function(data, status){
            console.log(data);
            $('#combo_depto_id').html(data);
        });
    });
    // ...

    // Luego, muestra el modal
    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    //display none para grupo_nueva_pass solo para editar disponible
    $(".grupo_nueva_pass").css("display", "none");

    $('#usu_id').val('');
    $('#combo_dep_id').val('').trigger('change');
    $('#combo_depto_id').val('').trigger('change');
    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    /* TODO:Mostrar Modal */
    $('#modalmantenimiento').modal('show');

   
});

init();