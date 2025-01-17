function init(){
    localStorage.removeItem('rutaAnterior')
}

$(document).ready(function(){
    var tick_id = getUrlParameter('ID');
    $('#Etick_estre').rating({ 
        showCaption: false
    });
    let rol_id =  $('#rol_idx').val();
    //administrador puede editar la categoria y subcategoria Cambios JJ 28/11/23
    if(rol_id == 3) { setCombos(tick_id) }
    listardetalle(tick_id);
    //Fin Cambios JJ 28/11/23
     /* TODO: Inicializamos summernotejs */
    $('#tickd_descrip').summernote({
        height: 400,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    /* TODO: Inicializamos summernotejs */
    $('#tickd_descripusu').summernote({
        height: 400,
        lang: "es-ES",
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });  

    $('#tickd_descripusu').summernote('disable');

    /* TODO: Listamos documentos en caso hubieran */
    tabla=$('#documentos_data').dataTable({
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
            url: '../../controller/documento.php?op=listar',
            type : "post",
            data : {tick_id:tick_id},
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


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on("click","#btnenviar", function(){
    var tick_id = getUrlParameter('ID');
    var usu_id = $('#user_idx').val();
    var tickd_descrip = $('#tickd_descrip').val();
    

    /* TODO:Validamos si el summernote esta vacio antes de guardar */
    if ($('#tickd_descrip').summernote('isEmpty')){
        swal("Advertencia!", "Falta Descripción", "warning");
    }else{
        var formData = new FormData();
        formData.append('tick_id',tick_id);
        formData.append('usu_id',usu_id);
        formData.append('tickd_descrip',tickd_descrip);
        var totalfiles = $('#fileElem').val().length;
        /* TODO:Agregamos los documentos adjuntos en caso hubiera */
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        /* TODO:Insertar detalle */
        $.ajax({
            url: "../../controller/ticket.php?op=insertdetalle",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data);
                listardetalle(tick_id);
                /* TODO: Limpiar inputfile */
                $('#fileElem').val('');
                $('#tickd_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
});

$(document).on("click","#btncerrarticket", function(){
    /* TODO: Preguntamos antes de cerrar el ticket */
    swal({
        title: "Peticiones",
        text: "Esta seguro de Cerrar el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            var tick_id = getUrlParameter('ID');
            var usu_id = $('#user_idx').val();
            /* TODO: Actualizamos el ticket  */
            $.post("../../controller/ticket.php?op=update", { tick_id : tick_id,usu_id : usu_id }, function (data) {

            });

            /* TODO:Alerta de ticket cerrado via email */
           /* $.post("../../controller/email.php?op=ticket_cerrado", {tick_id : tick_id}, function (data) {

            });*/

            /* TODO:Alerta de ticket cerrado via Whaspp */
            /*$.post("../../controller/whatsapp.php?op=w_ticket_cerrado", {tick_id : tick_id}, function (data) {

            });*/

            /* TODO:Llamamos a funcion listardetalle */
            listardetalle(tick_id);

            /* TODO: Alerta de confirmacion */
            swal({
                title: "Peticiones!",
                text: "Ticket Cerrado correctamente.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
});
$(document).on("click","#btncerrarticketUsuario", function(){
    /* TODO: Preguntamos antes de cerrar el ticket */
    var tick_id = getUrlParameter('ID');
    listardetalleEncuesta(tick_id);
    $('#mdltitulo').html('Llene la encuesta de satisfacción');
    $("#modalEncuesta").modal('show');
    });
function listardetalleEncuesta(tick_id){
    /* TODO: Mostra detalle de ticket */
    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function (data) {
        data = JSON.parse(data);
        $('#Elblestado').val(data.tick_estado_texto);
        $('#Eusu_id').val(data.usu_id)
        $('#Elblnomusuario').val(data.usu_nom +' '+ data.usu_ape );
        $('#Elblfechcrea').val(data.fech_crea);
        $('#Elblnomidticket').val(data.tick_id);
        $('#Ecat_nom').val(data.cat_nom);
        $('#Ecats_nom').val(data.cats_nom);
        $('#Etick_titulo').val(data.tick_titulo);
        $('#Eprio_nom').val(data.prio_nom);
        $('#Elblfechcierre').val(data.fech_cierre);
        if (data.tick_estre==null){
        }else{
            $('#panel1').hide();
        }
    });
}
/* TODO:Guardar Informacion de estrella del ticket */
$(document).on("click","#btnguardar", function(){
    var tick_id = getUrlParameter('ID');
    var tick_estre = $('#Etick_estre').val();
    if(tick_estre == null || tick_estre == undefined || tick_estre == ""){
        swal("Mensaje!", "Califique al usuario con extrellas","warning");
        return
    } 
    var tick_coment = $('#Etick_coment').val();
    var usu_id      = $('#Eusu_id').val()
    $.post("../../controller/ticket.php?op=encuesta", { tick_id : tick_id,tick_estre:tick_estre,tick_coment:tick_coment}, function (data) {
        console.log(data);
        $('#panel1').hide();
        swal("Correcto!", "Gracias por su Tiempo", "success");
    }); 
    /* TODO: Actualizamos el ticket  */
    $.post("../../controller/ticket.php?op=update", { tick_id : tick_id,usu_id : usu_id }, function (data) {

    });
     /* TODO: Ocultar Modal */
     $("#modalEncuesta").modal('hide');
     /* TODO:Recargar Datatable JS */
     listardetalle(tick_id)
});
$(document).on("click","#btnRegresar", function(){
    let url = localStorage.rutaAnterior
    window.open(url,'_self')
});


$(document).on("click","#btnchatgpt", function(){
    var tick_id = getUrlParameter('ID');
    $.post("../../controller/chatgpt.php?op=respuestaia", {tick_id : tick_id}, function (data) {
        $('#tickd_descrip').summernote ('code', data);
    });
});

function listardetalle(tick_id){
    /*console.log("entro")*/
    /* TODO: Mostramos informacion de detalle de ticket */
    $.post("../../controller/ticket.php?op=listardetalle", { tick_id : tick_id }, function (data) {
        $('#lbldetalle').html(data);
    }); 

    /* TODO: Mostramos informacion del ticket en inputs */
    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function (data) {
        data = JSON.parse(data);
        let rol_id =  $('#rol_idx').val();
        //llenar los combos para editar la categoria y subcategoria Inicio JJ 28-11-23
        if(rol_id == 3){
            //categoria
            const select    = document.querySelector('#categoriaId');
            select.value    = data.cat_id 
            //subcategoria
            setSubcategoria(data.cat_id,data.cats_id)
            //fin JJ 28-11-23
          
        }
        $('#lblestado').html(data.tick_estado);
        $('#lbldepnom').html(data.dep_nom);
        $('#lbldeptonom').html(data.depto_nom);
        $('#lblnomusuario').html(data.usu_nom +' '+data.usu_ape);
        $('#lbltelfusuario').html('Tel: ' + data.usu_telf);
        $('#lblcorreousuario').html('Correo: ' + data.usu_correo);
        
        $('#lblfechcrea').html(data.fech_crea);

        $('#lblnomidticket').html("Detalle Ticket - "+data.tick_id);

        $('#cat_nom').val(data.cat_nom);
        $('#cats_nom').val(data.cats_nom);
        $('#tick_titulo').val(data.tick_titulo);
        $('#tickd_descripusu').summernote ('code',data.tick_descrip);

        $('#prio_nom').val(data.prio_nom);

        if (data.tick_estado_texto == "Cerrado"){
            /* TODO: Ocultamos panel de detalle */
            $('#pnldetalle').hide();
        }
    });
}
//CATEGORIAS Y SUBCATEGORIAS JJ 28/11/23
function setCombos(tick_id){

    /* TODO: Llenar Combo categoria */
    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#categoriaId').html(data);
    });
    $("#categoriaId").change(function(){
        cat_id = $(this).val();
        /* TODO: llenar Combo subcategoria segun cat_id */
        $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
            console.log(data);
            $('#subcategoria').html(data);
        });
    });
    updateInformacion(tick_id)
    //activarUpdate
    activarUpdate()
}
function setSubcategoria(cat_id,cats_id){
    $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
        $('#subcategoria').html(data);
        selectCategoria(cats_id)
    });
    
}
function selectCategoria(cats_id){
    const select2   = document.querySelector('#subcategoria');
    select2.value   = cats_id 
}
function updateInformacion(tick_id){
    var boton = document.getElementById("botonUpdate");
    boton.addEventListener("click",function(){
         /* TODO: validamos si los campos tienen informacion antes de guardar */
       /* if ($('#subcategoria').val() == 0 || $('#categoriaId').val() == 0){
            swal("Advertencia!", "Falta Categoria o Subcategoria", "warning");
        }else{*/
        if ($('#categoriaId').val() == 0) {
            swal("Advertencia!", "Falta seleccionar la Categoría", "warning");
        } else if ($('#subcategoria').val() == 0) {
            swal("Advertencia!", "Falta seleccionar la Subcategoría", "warning");
        } else {
            let formData = new FormData()
            formData.append('tick_id',tick_id)
            formData.append('cat_id',$('#categoriaId').val(),)
            formData.append('cats_id',$('#subcategoria').val())
            /* TODO: Guardar Ticket */
            $.ajax({
                url: "../../controller/ticket.php?op=updateTicketInformacion",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    /* TODO: Alerta de Confirmacion */
                    desativarCampos()
                    swal("Correcto!", "Guardado Correctamente", "success");
                }
            });
        }
    })
}
function activarUpdate(){
    var boton = document.getElementById("botonChangeValores");
    //mostrar
    boton.addEventListener("click",function(){
        $("#categoriaId").prop("disabled", false);
        $("#subcategoria").prop("disabled", false);
        $("#botonUpdate").show();
        //acciones
        $("#botonChangeValores").hide();
        $("#botonDesactivarCambios").show();
    })
    //desactivar 
    var botonDesactivar = document.getElementById("botonDesactivarCambios");
    botonDesactivar.addEventListener("click",function(){
        desativarCampos()
    })
}
function desativarCampos(){
     $("#categoriaId").prop("disabled", true);
        $("#subcategoria").prop("disabled", true);
        $("#botonUpdate").hide();
        //acciones
        $("#botonChangeValores").show();
        $("#botonDesactivarCambios").hide();
}
init();
         //Cambios JJ 28/11/23                                                           