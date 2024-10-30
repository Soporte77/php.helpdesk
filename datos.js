console.log("ok")
const opciones           = document.querySelector("#opciones")
function init(){
    opciones.addEventListener('change',selectRol);
}

$(document).ready(function() {
});
function selectRol(e){
    let Rolid = opciones.value; 
    console.log("uwi",Rolid)
    $('#rol_id').val(Rolid);
    const image = `public/${Rolid}.jpg`
    $("#imgtipo").attr("src",image);
    switch (Rolid) {
        case '1':
            // Acciones para Usuario
            $('#lbltitulo').html(`Acceso Usuario`);
            break;
        case '2':
            // Acciones para Soporte
            $('#lbltitulo').html(`Acceso Soporte`);
            break;
        case '3':
            // Acciones para Administrador
            $('#lbltitulo').html(`Acceso Administrador`);
            break;
        default:
            $('#lbltitulo').html(`Acceso Usuario`);
    }
    // if(e.target.classList.contains('list-group-item')){
    //     const Rolid = e.target.getAttribute('data-rol')
    //     const Tipo = e.target.getAttribute('data-name')
    //     $('#rol_id').val(Rolid);
    //     const image = `public/${Rolid}.jpg`
    //     $("#imgtipo").attr("src",image);
    //     $('#lbltitulo').html(`Acceso ${Tipo}`);
    // }
}
/* TODO: Script para poder modificar segun el valor de acceso soporte o usuario */
// $(document).on("click", "#opciones", function () {
//     // if ($('#rol_id').val()==1){
//     //     $('#lbltitulo').html("Acceso Soporte 2");
//     //     $('#btnsoporte').html("Acceso Usuario 2");
//     //     $('#rol_id').val(2);
//     //     $("#imgtipo").attr("src","public/2.jpg");
//     // }else{
//     //     $('#lbltitulo').html("Acceso Usuario 3");
//     //     $('#btnsoporte').html("Acceso Soporte 4");
//     //     $('#rol_id').val(1);
//     //     $("#imgtipo").attr("src","public/1.jpg");
//     // }
// });

init();