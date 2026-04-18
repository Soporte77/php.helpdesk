var tabla;
var caracteristicas_count = 0;

function init(){
    $("#equipo_form").on("submit",function(e){
        guardaryeditar(e);	
    });
    
    $("#carac_form").on("submit",function(e){
        guardar_caracteristica(e);
    });
}

$(document).ready(function(){
    // Cargar DataTable de equipos
    tabla=$('#equipos_data').dataTable({
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
            url: '../../controller/equipo.php?op=listar',
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
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sSearch":         "Buscar:",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    }).DataTable();
});

function guardaryeditar(e){
    e.preventDefault();
    
    // Recopilar características dinámicas
    let caracteristicas = [];
    $('.carac-item').each(function(){
        let carac_id = $(this).find('.carac-select').val();
        let valor = $(this).find('.carac-valor').val();
        if(carac_id && valor){
            caracteristicas.push({carac_id: carac_id, valor: valor});
        }
    });
    
    // Validar que se haya agregado al menos una característica
    if(caracteristicas.length === 0){
        swal({
            title: "Advertencia",
            text: "Debe agregar al menos una característica del equipo (RAM, Disco, Marca, Modelo, etc.)",
            type: "warning",
            confirmButtonClass: "btn-warning"
        });
        return false;
    }
    
	var formData = new FormData($("#equipo_form")[0]);
	formData.append('caracteristicas', JSON.stringify(caracteristicas));
	
    $.ajax({
        url: "../../controller/equipo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            $('#equipo_form')[0].reset();
            $("#modalequipo").modal('hide');
            $('#equipos_data').DataTable().ajax.reload();

            swal({
                title: "Gestión de Equipos",
                text: "Equipo guardado correctamente",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    }); 
}

function editar(equipo_id){
    $('#mdltitulo').html('Editar Equipo');
    $('#buscar_usuario').val('');
    
    // Cargar usuarios
    cargar_usuarios();
    
    $.post("../../controller/equipo.php?op=mostrar", {equipo_id : equipo_id}, function (response) {
        let data = JSON.parse(response);
        
        $('#equipo_id').val(data.equipo_id);
        $('#estado_activo').val(data.estado_activo);
        $('#observaciones').val(data.observaciones);
        
        // Cargar usuario seleccionado
        setTimeout(function(){
            $('#usu_id').val(data.usu_id);
            if(data.usu_id){
                let texto = $('#usu_id option:selected').text();
                $('#buscar_usuario').val(texto);
            }
        }, 500);
        
        // Cargar características del equipo
        $('#caracteristicas_container').html('');
        caracteristicas_count = 0;
        
        if(data.caracteristicas && data.caracteristicas.length > 0){
            data.caracteristicas.forEach(function(carac){
                agregar_caracteristica_campo(carac.carac_id, carac.detalle_valor);
            });
        }
    }); 
    
    $('#modalequipo').modal('show');
}

function eliminar(equipo_id){
    swal({
        title: "Gestión de Equipos",
        text: "¿Está seguro de eliminar este equipo?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/equipo.php?op=eliminar", {equipo_id : equipo_id}, function (data) {
                $('#equipos_data').DataTable().ajax.reload();	
                swal({
                    title: "Gestión de Equipos",
                    text: "Equipo eliminado correctamente",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            }); 
        }
    });
}

$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Asignar Nuevo Equipo');
    $('#equipo_form')[0].reset();
    $('#equipo_id').val('');
    $('#caracteristicas_container').html('');
    caracteristicas_count = 0;
    $('#buscar_usuario').val('');
    
    cargar_usuarios();
    cargar_caracteristicas_disponibles();
    $('#modalequipo').modal('show');
});

$(document).on("click","#btncaracteristicas", function(){
    cargar_catalogo_caracteristicas();
    $('#modalcaracteristicas').modal('show');
});

$(document).on("click","#btnagregar_carac", function(){
    agregar_caracteristica_campo();
});

function cargar_usuarios(){
    $.ajax({
        url: '../../controller/equipo.php?op=listar_usuarios',
        type: 'GET',
        success: function(response){
            let usuarios = JSON.parse(response);
            window.todos_usuarios = usuarios; // Guardar para filtrado
            
            let html = '<option value="">-- Seleccionar cliente --</option>';
            usuarios.forEach(function(user){
                html += `<option value="${user.usu_id}">${user.usu_nom} ${user.usu_ape} (${user.usu_numemp})</option>`;
            });
            $('#usu_id').html(html);
            
            // Configurar búsqueda en tiempo real - IMPORTANTE: Después de cargar los usuarios
            configurar_busqueda_usuario();
        }
    });
}

// Función separada para configurar la búsqueda
function configurar_busqueda_usuario(){
    // Remover eventos anteriores
    $('#buscar_usuario').off('keyup');
    $('#usu_id').off('change');
    
    // Configurar búsqueda en tiempo real
    $('#buscar_usuario').on('keyup', function(){
        let filtro = $(this).val().toLowerCase().trim();
        
        if(!window.todos_usuarios){
            return;
        }
        
        if(filtro === ''){
            // Si está vacío, mostrar todos
            let html = '<option value="">-- Seleccionar cliente --</option>';
            window.todos_usuarios.forEach(function(user){
                html += `<option value="${user.usu_id}">${user.usu_nom} ${user.usu_ape} (${user.usu_numemp})</option>`;
            });
            $('#usu_id').html(html);
        } else {
            // Filtrar usuarios
            let usuarios_filtrados = window.todos_usuarios.filter(function(user){
                let texto = `${user.usu_nom} ${user.usu_ape} ${user.usu_numemp}`.toLowerCase();
                return texto.indexOf(filtro) > -1;
            });
            
            let html = '<option value="">-- ' + usuarios_filtrados.length + ' resultado(s) --</option>';
            if(usuarios_filtrados.length > 0){
                usuarios_filtrados.forEach(function(user){
                    html += `<option value="${user.usu_id}">${user.usu_nom} ${user.usu_ape} (${user.usu_numemp})</option>`;
                });
            } else {
                html += '<option value="">No se encontraron clientes</option>';
            }
            $('#usu_id').html(html);
        }
    });
    
    // Al seleccionar un usuario, mostrarlo en el buscador
    $('#usu_id').on('change', function(){
        if($(this).val()){
            let texto = $(this).find('option:selected').text();
            $('#buscar_usuario').val(texto);
        }
    });
}

function cargar_caracteristicas_disponibles(){
    $.ajax({
        url: '../../controller/equipo.php?op=listar_caracteristicas',
        type: 'GET',
        success: function(response){
            window.caracteristicas_catalogo = JSON.parse(response);
        }
    });
}

// Función auxiliar para obtener características ya seleccionadas
function obtener_caracteristicas_seleccionadas(){
    let seleccionadas = [];
    $('.carac-select').each(function(){
        let val = $(this).val();
        if(val){
            seleccionadas.push(val.toString()); // Convertir a string para comparación
        }
    });
    return seleccionadas;
}

// Función para actualizar todos los selects y eliminar opciones duplicadas
function actualizar_selects_caracteristicas(){
    let seleccionadas = obtener_caracteristicas_seleccionadas();
    
    $('.carac-select').each(function(){
        let select_actual = $(this);
        let valor_actual = select_actual.val();
        
        // Reconstruir opciones
        let html = '<option value="">Seleccionar...</option>';
        window.caracteristicas_catalogo.forEach(function(carac){
            let carac_id_str = carac.carac_id.toString();
            // Mostrar la opción si es la seleccionada actualmente o si no está en uso
            if(carac_id_str == valor_actual || seleccionadas.indexOf(carac_id_str) === -1){
                let selected = (carac_id_str == valor_actual) ? 'selected' : '';
                html += `<option value="${carac.carac_id}" ${selected}>${carac.carac_nombre}</option>`;
            }
        });
        
        select_actual.html(html);
    });
    
    // Re-vincular eventos change a todos los selects
    $('.carac-select').off('change').on('change', function(){
        actualizar_selects_caracteristicas();
    });
}

function agregar_caracteristica_campo(carac_id_selected = '', valor = ''){
    if(!window.caracteristicas_catalogo){
        cargar_caracteristicas_disponibles();
        setTimeout(function(){ agregar_caracteristica_campo(carac_id_selected, valor); }, 500);
        return;
    }
    
    caracteristicas_count++;
    let carac_count_temp = caracteristicas_count;
    
    let html = `
        <div class="form-group carac-item" id="carac_${caracteristicas_count}">
            <div class="row">
                <div class="col-md-5">
                    <select class="form-control carac-select" data-carac-id="${caracteristicas_count}">
                        <option value="">Seleccionar...</option>`;
    
    // Obtener características ya seleccionadas
    let seleccionadas = obtener_caracteristicas_seleccionadas();
    
    window.caracteristicas_catalogo.forEach(function(carac){
        let carac_id_str = carac.carac_id.toString();
        // Mostrar la opción solo si es la seleccionada o si no está en uso
        if(carac_id_str == carac_id_selected.toString() || seleccionadas.indexOf(carac_id_str) === -1){
            let selected = (carac_id_str == carac_id_selected.toString()) ? 'selected' : '';
            html += `<option value="${carac.carac_id}" ${selected}>${carac.carac_nombre}</option>`;
        }
    });
    
    html += `
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control carac-valor" placeholder="Valor (ej: 16GB, Intel i5)" value="${valor}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-block" onclick="eliminar_caracteristica(${caracteristicas_count})">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    $('#caracteristicas_container').append(html);
    
    // Vincular evento change al nuevo select
    $('.carac-select').off('change').on('change', function(){
        actualizar_selects_caracteristicas();
    });
}

// Función para eliminar característica y actualizar selects
function eliminar_caracteristica(id){
    $('#carac_' + id).remove();
    actualizar_selects_caracteristicas();
}

function cargar_catalogo_caracteristicas(){
    $.ajax({
        url: '../../controller/equipo.php?op=listar_caracteristicas',
        type: 'GET',
        success: function(response){
            let caracteristicas = JSON.parse(response);
            let html = '';
            
            caracteristicas.forEach(function(carac){
                let badge = carac.carac_tipo === 'componente' ? 'primary' : 
                           (carac.carac_tipo === 'software' ? 'success' : 'warning');
                html += `
                    <tr>
                        <td>${carac.carac_nombre}</td>
                        <td><span class="label label-${badge}">${carac.carac_tipo}</span></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar_caracteristica_catalogo(${carac.carac_id})">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            $('#caracteristicas_table tbody').html(html);
        }
    });
}

function guardar_caracteristica(e){
    e.preventDefault();
    
    let nombre = $('#nueva_carac_nombre').val();
    let tipo = $('#nueva_carac_tipo').val();
    
    if(!nombre || !tipo){
        swal("Error", "Complete todos los campos", "error");
        return;
    }
    
    $.post("../../controller/equipo.php?op=guardar_caracteristica", {
        carac_nombre: nombre,
        carac_tipo: tipo
    }, function(response){
        $('#carac_form')[0].reset();
        cargar_catalogo_caracteristicas();
        swal("Éxito", "Característica agregada", "success");
    });
}

function eliminar_caracteristica_catalogo(carac_id){
    swal({
        title: "¿Eliminar característica?",
        text: "Se eliminará del catálogo",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
    }, function(isConfirm){
        if(isConfirm){
            $.post("../../controller/equipo.php?op=eliminar_caracteristica", {carac_id: carac_id}, function(response){
                cargar_catalogo_caracteristicas();
                swal("Eliminado", "Característica eliminada", "success");
            });
        }
    });
}

init();
