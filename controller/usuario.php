<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Modelo Categoria */
    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    /*TODO: opciones del controlador Categoria*/
    switch($_GET["op"]){
        /* TODO: Guardar y editar, guardar si el campo usu_id esta vacio */
        case "guardaryeditar":
            $idUsuario =0;
            if(empty($_POST["usu_id"])){       
                $valor = $usuario->insert_usuario($_POST["usu_numemp"],$_POST["usu_nom"],$_POST["usu_ape"],$_POST["combo_dep_id"],$_POST["combo_depto_id"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["usu_telf"]);     
                $idUsuario = $valor;             
            }
            else {
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_numemp"],$_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["rol_id"],$_POST["usu_telf"]);
                $idUsuario = $_POST["usu_id"];
                //si nueva_pass es diferente de nula o vacio cambiar contrasena
                if(!empty($_POST["nueva_pass"])){
                    $usuario->update_usuario_pass($_POST["usu_id"],$_POST["nueva_pass"]);
                }
            }
            ///====GUARDAR FOTO===================
            /* TODO: Validamos si vienen archivos desde la Vista */
            if (empty($_FILES['files']['name'])){

            }else{
                ///eliminamos la foto anterior
                $fotoAnterior = $_POST["textFoto"];
                if($fotoAnterior == null){ }
                else{
                    $ruta = "../public/document/"."usuario/".$idUsuario."/";
                    $ruta = "../public/document/"."usuario/".$idUsuario."/".$fotoAnterior;
                    // if (file_exists($ruta)) {
                    //     unlink($ruta);
                    // }
                    if(file_exists($ruta)) {
                        if(file_exists($ruta) ){
                            unlink($ruta);
                        }
                    }
                }
                //GUARDAR FOTO NUEVA
                /* TODO:Contar Cantidad de Archivos desde la Vista */
                $countfiles = count($_FILES['files']['name']);
                /* TODO: Generamos ruta segun el ID del ultimo registro insertado */
                $ruta = "../public/document/"."usuario/".$idUsuario."/";
                $files_arr = array();

                /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }

                /* TODO:Recorremos los archivos, y insertamos tantos detalles como documentos vinieron desde la vista */
                for ($index = 0; $index < $countfiles; $index++) {
                    $doc1 = $_FILES['files']['tmp_name'][$index];
                    $destino = $ruta.$_FILES['files']['name'][$index];

                    /* TODO: Insertamos Documentos */
                    $usuario->insert_Foto( $idUsuario,$_FILES['files']['name'][$index]);

                    /* TODO: Movemos los archivos hacia la carpeta creada */
                    move_uploaded_file($doc1,$destino);
                }
            }
            echo json_encode($idUsuario);
            break;

        /* TODO: Listado de usuario segun formato json para el datatable */
        case "listar":
            $datos=$usuario->get_usuario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_ape"];
                $sub_array[] = $row["usu_numemp"];
                $sub_array[] = $row["dep_nom"];
                $sub_array[] = $row["depto_nom"];
               

                if ($row["rol_id"]=="1"){
                    $sub_array[] = '<span class="label label-pill label-success">Usuario</span>';
                }
                if ($row["rol_id"]=="2"){
                    $sub_array[] = '<span class="label label-pill label-info">Soporte</span>';
                }
                if ($row["rol_id"]=="3"){
                    $sub_array[] = '<span class="label label-pill label-dark">Administrador</span>';
                }
                $sub_array[] = '<a href="../../public/document/usuario/'.$row["usu_id"].'/'.$row["foto"].'" target="_blank"><img src="../../public/document/usuario/'.$row["usu_id"].'/'.$row["foto"].'" class="img-thumbnail" width="50" height="50" /></a>';
                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO: Actualizar estado a 0 segun id de usuario */
        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
            break;

        /* TODO: Mostrar en formato JSON segun usu_id */
        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_numemp"] = $row["usu_numemp"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["dep_id"] = $row["dep_id"];
                    $output["depto_id"] = $row["depto_id"];
                    $output["dep_nom"] = $row["dep_nom"];
                    $output["depto_nom"] = $row["depto_nom"];
                    $output["usu_correo"] = $row["usu_correo"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["rol_id"] = $row["rol_id"];
                    $output["usu_telf"] = $row["usu_telf"];
                    $output["usu_foto"] = "../../public/document/usuario/" .$row["usu_id"].'/'.$row["foto"];
                    $output["textFoto"] = $row["foto"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Cantidad de Ticket por Usuario en formato JSON */
        case "total";
            $datos=$usuario->get_usuario_total_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Cantidad de Ticket Abiertos por Usuario en formato JSON */
        case "totalabierto";
            $datos=$usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Cantidad de Ticket Cerrados por Usuario en formato JSON */
        case "totalcerrado";
            $datos=$usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Formato Json segun cantidad de ticket por categoria por usuario */
        case "grafico";
            $datos=$usuario->get_usuario_grafico($_POST["usu_id"]);  
            echo json_encode($datos);
            break;

        /* TODO: Formato para llenar combo en formato HTML */
        case "combo";
            $datos = $usuario->get_usuario_x_rol();
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom']."</option>";
                }
                echo $html;
            }
            break;
        /*TODO: Controller para actualizar contraseña */
        case "password":
            $usuario->update_usuario_pass($_POST["usu_id"],$_POST["usu_pass"]);
            break;

              /* TODO: Formato Json segun cantidad de ticket por categoria por usuario */
        case "graficoSoporte":
            $datos=$usuario->graficoSoporte();  
            $html = "";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.="
                        <div class='col-lg-4'>
                            <div class='row'>
                                <div class='col-md-12'>
                                <div class='card' style='padding:15px;'>
                                    <div style='display: flex;justify-content: center;'>";
                                    $html .= "<img src='../../public/document/usuario/".$row['usu_id']."/".$row['foto']."' style='margin:10px;border-radius:50%;' width='100' height='80' alt='Imagen soporte'>";
                                    $html.="</div>
                                  
                                        <div class='card-body'>
                                        "
                                        ."<p class='card-text text-center'>".$row['usu_nom']. " ". $row['usu_ape']."</p>
                                    <p class='card-text text-center'><b>Tickets</b>:".$row['totalTicket']."</p>
                                            <div class='row' style='cursor:pointer'  onClick='verUsuarios(".$row['usu_id'].",5".");'>
                                                <div class='col-lg-9'>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <div class='rating-bar-container'>
                                                            <div class='rating-bar-full rounded' style='height: 1rem;'> ";
                                                                if ($row['total5'] == 5){
                                                                    $html.="<div class='rating-bar-full rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total5'] == 4){
                                                                    $html.="<div class='rating-bar-80 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total5'] == 3){
                                                                    $html.="<div class='rating-bar-60 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total5'] == 3){
                                                                    $html.="<div class='rating-bar-45 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total5'] == 1){
                                                                    $html.="<div class='rating-bar-30 rounded' style='height: 1rem;'></div>";
                                                                }
                                                            $html.="
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-lg-3'>
                                                    5 <i class='fas fa-star'></i>
                                                </div>
                                            </div>
                                            <div class='row' style='cursor:pointer' onClick='verUsuarios(".$row['usu_id'].",4".");'>
                                                <div class='col-lg-9'>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <div class='rating-bar-container'>
                                                            <div class='rating-bar-full rounded' style='height: 1rem;'> ";
                                                                if ($row['total4'] == 5){
                                                                    $html.="<div class='rating-bar-full rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total4'] == 4){
                                                                    $html.="<div class='rating-bar-80 rounded'  style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total4'] == 3){
                                                                    $html.="<div class='rating-bar-60 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total4'] == 2){
                                                                    $html.="<div class='rating-bar-45 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total4'] == 1){
                                                                    $html.="<div class='rating-bar-30 rounded' style='height: 1rem;'></div>";
                                                                }
                                                            $html.="
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-lg-3'>
                                                    4 <i class='fas fa-star'></i>
                                                </div>
                                            </div>
                                            <div class='row' style='cursor:pointer'  onClick='verUsuarios(".$row['usu_id'].",3".");'>
                                                <div class='col-lg-9'>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <div class='rating-bar-container'>
                                                            <div class='rating-bar-full rounded' style='height: 1rem;'> ";
                                                                if ($row['total3'] == 5){
                                                                    $html.="<div class='rating-bar-full rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total3'] == 4){
                                                                    $html.="<div class='rating-bar-80 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total3'] == 3){
                                                                    $html.="<div class='rating-bar-60 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total3'] == 2){
                                                                    $html.="<div class='rating-bar-45 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total3'] == 1){
                                                                    $html.="<div class='rating-bar-30 rounded' style='height: 1rem;'></div>";
                                                                }
                                                            $html.="
                                                            </div>
                                                        </div>     
                                                    </div>
                                                </div>
                                                <div class='col-lg-3'>
                                                    3 <i class='fas fa-star'></i>
                                                </div>
                                            </div>
                                            <div class='row' style='cursor:pointer'  onClick='verUsuarios(".$row['usu_id'].",2".");'>
                                                <div class='col-lg-9'>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <div class='rating-bar-container'>
                                                            <div class='rating-bar-full rounded' style='height: 1rem;'> ";
                                                                if ($row['total2'] == 5){
                                                                    $html.="<div class='rating-bar-full rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total2'] == 4){
                                                                    $html.="<div class='rating-bar-80 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total2'] == 3){
                                                                    $html.="<div class='rating-bar-60 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total2'] == 2){
                                                                    $html.="<div class='rating-bar-45 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total2'] == 1){
                                                                    $html.="<div class='rating-bar-30 rounded' style='height: 1rem;'></div>";
                                                                }
                                                            $html.="
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class='col-lg-3'>
                                                    2 <i class='fas fa-star'></i>
                                                </div>
                                            </div>
                                            <div class='row' style='cursor:pointer'  onClick='verUsuarios(".$row['usu_id'].",1".");'>
                                                <div class='col-lg-9'>
                                                    <div class='d-flex align-items-center mb-2'>
                                                        <div class='rating-bar-container'>
                                                            <div class='rating-bar-full rounded' style='height: 1rem;'> ";
                                                                if ($row['total1'] == 5){
                                                                    $html.="<div class='rating-bar-full rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total1'] == 4){
                                                                    $html.="<div class='rating-bar-80 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total1'] == 3){
                                                                    $html.="<div class='rating-bar-60 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total1'] == 2){
                                                                    $html.="<div class='rating-bar-45 rounded' style='height: 1rem;'></div>";
                                                                }
                                                                if ($row['total1'] == 1){
                                                                    $html.="<div class='rating-bar-30 rounded' style='height: 1rem;'></div>";
                                                                }
                                                            $html.="
                                                            </div>
                                                        </div>     
                                                    </div>
                                                </div>
                                                <div class='col-lg-3'>
                                                    1 <i class='fas fa-star' style='margin-left:4px;'></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
    
                // Elimina los saltos de línea y espacios innecesarios
                $html = str_replace(array("\r\n", "\r", "\n", '  '), '', $html);
            }
            // echo $html;
            echo json_encode($html);
            break;
            case "mostrarCalificaciones":
                $html = "";
                $datos=$usuario->mostrarCalificaciones($_POST["usu_id"],$_POST["calificacion"]);  
                $data= Array();
                foreach($datos as $row){
                    $html.="
                    <tr>
                    <td>".$row['usu_nom']."</td>
                    <td>".$row['usu_ape']."</td>
                    <td>".$row['usu_correo']."</td>
                    <td>".$row['fech_cierre']."</td>
                    <td>".$row['tick_coment']."</td>
                    </tr>
                    ";
                     // Elimina los saltos de línea y espacios innecesarios
                     $html = str_replace(array("\r\n", "\r", "\n", '  '), '', $html);

    }

    echo json_encode($html);
    // echo json_encode($datos);
break;
    }
?>