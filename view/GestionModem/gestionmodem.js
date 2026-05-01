var tabla_modems;
var carac_count = 0;

function init(){
    $("#modem_form").on("submit", function(e){ guardar_modem(e); });
    $("#carac_form").on("submit", function(e){ guardar_caracteristica(e); });

    // Botones tab
    $(document).on("click", ".btn-tab-modem", function(){
        let tab = $(this).data("tab");
        $(".btn-tab-modem").css({ "background-color":"#b0c4de", "color":"#fff", "border-color":"#b0c4de" });
        $(this).css({ "background-color":"#1a6faf", "color":"#fff", "border-color":"#1a6faf" });
        $(".tab-pane-modem").hide();
        $("#" + tab).show();
        if(tab === "tab-caracteristicas") cargar_catalogo_caracteristicas();
    });
}

$(document).ready(function(){
    tabla_modems = $('#modems_data').dataTable({
        "aProcessing": true, "aServerSide": true,
        dom: 'Bfrtip', "searching": true, lengthChange: false, colReorder: true,
        buttons: ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5'],
        "ajax":{ url: '../../controller/modem.php?op=listar_modems', type:"get", dataType:"json", error:function(e){ console.log(e.responseText); } },
        "bDestroy": true, "responsive": true, "bInfo": true, "iDisplayLength": 10, "autoWidth": false,
        "language": {
            "sProcessing":"Procesando...", "sLengthMenu":"Mostrar _MENU_ registros",
            "sZeroRecords":"No se encontraron resultados", "sEmptyTable":"Ningún dato disponible",
            "sInfo":"Mostrando registros del _START_ al _END_ de _TOTAL_", "sInfoEmpty":"Mostrando 0 registros",
            "sInfoFiltered":"(filtrado de _MAX_)", "sSearch":"Buscar:",
            "oPaginate":{ "sFirst":"Primero","sLast":"Último","sNext":"Siguiente","sPrevious":"Anterior" }
        }
    }).DataTable();
});

/* =============================================
   MÓDEMS
============================================= */

$(document).on("click","#btn_nuevo_modem", function(){
    $('#mdl_modem_titulo').html('Nuevo Módem');
    $('#modem_form')[0].reset();
    $('#modem_id').val('');
    $('#modem_carac_container').html('');
    carac_count = 0;
    cargar_caracteristicas_disponibles();
    $('#modal_modem').modal('show');
});

function editar_modem(modem_id){
    $('#mdl_modem_titulo').html('Editar Módem');
    cargar_caracteristicas_disponibles();
    $.post("../../controller/modem.php?op=mostrar_modem", {modem_id: modem_id}, function(response){
        let data = JSON.parse(response);
        $('#modem_id').val(data.modem_id);
        $('#modem_nombre').val(data.modem_nombre);
        $('#modem_carac_container').html('');
        carac_count = 0;
        if(data.caracteristicas && data.caracteristicas.length > 0){
            data.caracteristicas.forEach(function(c){
                agregar_carac_campo(c.carac_id, c.detalle_valor);
            });
        }
    });
    $('#modal_modem').modal('show');
}

function eliminar_modem(modem_id){
    swal({ title:"Módems", text:"¿Eliminar este módem?", type:"warning", showCancelButton:true,
        confirmButtonClass:"btn-danger", confirmButtonText:"Sí", cancelButtonText:"No", closeOnConfirm:false },
        function(ok){ if(ok){
            $.post("../../controller/modem.php?op=eliminar_modem", {modem_id: modem_id}, function(){
                tabla_modems.ajax.reload();
                swal("Eliminado","Módem eliminado correctamente","success");
            });
        }
    });
}

function guardar_modem(e){
    e.preventDefault();
    let caracteristicas = [];
    $('.carac-item').each(function(){
        let carac_id = $(this).find('.carac-select').val();
        let valor    = $(this).find('.carac-valor').val();
        if(carac_id && valor) caracteristicas.push({carac_id: carac_id, valor: valor});
    });

    let formData = new FormData($("#modem_form")[0]);
    formData.append('caracteristicas', JSON.stringify(caracteristicas));

    $.ajax({
        url: "../../controller/modem.php?op=guardar_modem",
        type: "POST", data: formData, contentType: false, processData: false,
        success: function(response){
            let res = JSON.parse(response);
            if(res.status === "error"){
                swal("Nombre duplicado", res.msg, "warning");
                return;
            }
            $('#modem_form')[0].reset();
            $('#modal_modem').modal('hide');
            tabla_modems.ajax.reload();
            swal("Módems","Guardado correctamente","success");
        }
    });
}

/* =============================================
   CARACTERÍSTICAS DINÁMICAS EN EL MODAL
============================================= */

$(document).on("click","#btn_agregar_carac_modem", function(){
    agregar_carac_campo();
});

function cargar_caracteristicas_disponibles(){
    $.ajax({
        url: '../../controller/modem.php?op=listar_caracteristicas', type:'GET',
        success: function(response){ window.carac_catalogo = JSON.parse(response); }
    });
}

function obtener_seleccionadas(){
    let sel = [];
    $('.carac-select').each(function(){ let v = $(this).val(); if(v) sel.push(v.toString()); });
    return sel;
}

function actualizar_selects(){
    let sel = obtener_seleccionadas();
    $('.carac-select').each(function(){
        let $s = $(this), actual = $s.val();
        let html = '<option value="">Seleccionar...</option>';
        window.carac_catalogo.forEach(function(c){
            let id = c.carac_id.toString();
            if(id == actual || sel.indexOf(id) === -1){
                html += `<option value="${c.carac_id}" ${id==actual?'selected':''}>${c.carac_nombre}</option>`;
            }
        });
        $s.html(html);
    });
    $('.carac-select').off('change').on('change', function(){ actualizar_selects(); });
}

function agregar_carac_campo(carac_id_sel='', valor=''){
    if(!window.carac_catalogo){
        cargar_caracteristicas_disponibles();
        setTimeout(function(){ agregar_carac_campo(carac_id_sel, valor); }, 400);
        return;
    }
    carac_count++;
    let sel = obtener_seleccionadas();
    let opts = '<option value="">Seleccionar...</option>';
    window.carac_catalogo.forEach(function(c){
        let id = c.carac_id.toString();
        if(id == carac_id_sel.toString() || sel.indexOf(id) === -1){
            opts += `<option value="${c.carac_id}" ${id==carac_id_sel.toString()?'selected':''}>${c.carac_nombre}</option>`;
        }
    });
    let html = `
        <div class="form-group carac-item" id="carac_${carac_count}">
            <div class="row">
                <div class="col-md-5">
                    <select class="form-control carac-select">${opts}</select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control carac-valor" placeholder="Valor (ej: TP-Link, 100Mbps)" value="${valor}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-block" onclick="eliminar_carac_campo(${carac_count})">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>
            </div>
        </div>`;
    $('#modem_carac_container').append(html);
    $('.carac-select').off('change').on('change', function(){ actualizar_selects(); });
}

function eliminar_carac_campo(id){
    $('#carac_'+id).remove();
    actualizar_selects();
}

/* =============================================
   CATÁLOGO DE CARACTERÍSTICAS
============================================= */

function cargar_catalogo_caracteristicas(){
    $.ajax({
        url: '../../controller/modem.php?op=listar_caracteristicas', type:'GET',
        success: function(response){
            let lista = JSON.parse(response);
            let html = '';
            let badges = {identificacion:'primary', red:'info', configuracion:'success', otro:'warning'};
            lista.forEach(function(c){
                let badge = badges[c.carac_tipo] || 'default';
                html += `<tr>
                    <td>${c.carac_nombre}</td>
                    <td><span class="label label-${badge}">${c.carac_tipo}</span></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminar_caracteristica(${c.carac_id})">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#caracteristicas_table tbody').html(html);
        }
    });
}

function guardar_caracteristica(e){
    e.preventDefault();
    let nombre = $('#nueva_carac_nombre').val().trim();
    let tipo   = $('#nueva_carac_tipo').val();
    if(!nombre || !tipo){ swal("Error","Complete todos los campos","error"); return; }
    $.post("../../controller/modem.php?op=guardar_caracteristica", {carac_nombre: nombre, carac_tipo: tipo}, function(response){
        let res = JSON.parse(response);
        if(res.status === "error"){
            swal("Nombre duplicado", res.msg, "warning");
            return;
        }
        $('#carac_form')[0].reset();
        cargar_catalogo_caracteristicas();
        swal("Éxito","Característica agregada","success");
    });
}

function eliminar_caracteristica(carac_id){
    swal({ title:"¿Eliminar?", text:"Se eliminará del catálogo", type:"warning", showCancelButton:true,
        confirmButtonText:"Sí", cancelButtonText:"No", closeOnConfirm:false },
        function(ok){ if(ok){
            $.post("../../controller/modem.php?op=eliminar_caracteristica", {carac_id: carac_id}, function(){
                cargar_catalogo_caracteristicas();
                swal("Eliminado","Característica eliminada","success");
            });
        }
    });
}

init();
