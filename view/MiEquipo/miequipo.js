function init(){
    cargarMiEquipo();
}

function cargarMiEquipo(){
    $.ajax({
        url: '../../controller/equipo.php?op=mi_equipo',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            if(data.error){
                $('#divEquipo').hide();
                $('#divNoEquipo').show();
            } else {
                mostrarEquipo(data);
            }
        },
        error: function(xhr, status, error){
            console.log('Error:', error);
            $('#divEquipo').hide();
            $('#divNoEquipo').show();
        }
    });
}

function mostrarEquipo(equipo){
    let html = `
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 style="color: white; margin: 0;">
                            <i class="glyphicon glyphicon-hdd"></i> Mi Equipo de Cómputo
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5><strong>Especificaciones Técnicas</strong></h5>
                                <div id="especificaciones">`;
    
    // Agrupar características por tipo
    let componentes = '';
    let software = '';
    let accesorios = '';
    
    if(equipo.caracteristicas && equipo.caracteristicas.length > 0){
        equipo.caracteristicas.forEach(function(carac){
            let item = `
                <div class="alert alert-info" style="padding: 10px; margin-bottom: 10px;">
                    <strong><i class="glyphicon glyphicon-${getIcono(carac.carac_tipo)}"></i> ${carac.carac_nombre}:</strong><br>
                    ${carac.detalle_valor}
                </div>
            `;
            
            if(carac.carac_tipo === 'componente'){
                componentes += item;
            } else if(carac.carac_tipo === 'software'){
                software += item;
            } else if(carac.carac_tipo === 'accesorio'){
                accesorios += item;
            }
        });
        
        if(componentes) html += '<h6 class="text-primary">Componentes:</h6>' + componentes;
        if(software) html += '<h6 class="text-success">Software:</h6>' + software;
        if(accesorios) html += '<h6 class="text-warning">Accesorios:</h6>' + accesorios;
    } else {
        html += '<div class="alert alert-warning">No hay especificaciones registradas</div>';
    }
    
    html += `
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5><strong>Información General</strong></h5>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td colspan="2"><strong>Asignado por:</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">${equipo.asigno_nom && equipo.asigno_ape ? equipo.asigno_nom + ' ' + equipo.asigno_ape : '-'}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Fecha de Asignación:</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">${equipo.fecha_asignacion ? formatearFecha(equipo.fecha_asignacion) : '-'}</td>
                                    </tr>`;
    
    if(equipo.observaciones){
        html += `
                                    <tr>
                                        <td colspan="2"><strong>Observaciones:</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">${equipo.observaciones}</td>
                                    </tr>`;
    }
    
    html += `
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#divEquipo').html(html);
}

function getIcono(tipo){
    switch(tipo){
        case 'componente': return 'cog';
        case 'software': return 'cd';
        case 'accesorio': return 'wrench';
        default: return 'tag';
    }
}

function formatearFecha(fecha){
    if(!fecha) return '-';
    let date = new Date(fecha);
    let dia = String(date.getDate()).padStart(2, '0');
    let mes = String(date.getMonth() + 1).padStart(2, '0');
    let anio = date.getFullYear();
    return dia + '/' + mes + '/' + anio;
}

init();
