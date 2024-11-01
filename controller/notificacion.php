<?php
    /*TODO: llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    $notificacion = new Notificacion();

    /*TODO: opciones del controlador */
    switch($_GET["op"]){

        /* TODO: Mostrar en formato JSON segun usu_id */
        /*case "mostrar";
            $rol_id =  $_POST["rol_id"];
            $datos  = "";
            //Administrador: Traigo todas las notificaciones
            if($rol_id == 3){
                $datos=$notificacion->get_notificacion_xAll();
            }else{
                $datos=$notificacion->get_notificacion_x_usu($_POST["usu_id"]);  
            }
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["not_id"] = $row["not_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["not_mensaje"] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                    $output["tick_id"] = $row["tick_id"];
                }
                echo json_encode($output);
            }
            break;*/

        /* TODO: Mostrar en formato JSON segun usu_id */
        case "mostrar";
            $datos=$notificacion->get_notificacion_x_usu($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["not_id"] = $row["not_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["not_mensaje"] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                    $output["tick_id"] = $row["tick_id"];
                }
                echo json_encode($output);
            }
            break;
//Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23
        case "mostrar_admin";
        $datos=$notificacion->get_notificacion_xAll2($_POST["usu_id"]);  
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["not_id"] = $row["not_id"];
                $output["usu_id"] = $row["usu_id"];
                $output["not_mensaje"] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                $output["tick_id"] = $row["tick_id"];
            }
            echo json_encode($output);
        }
        break;
//Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23

        /* TODO:Actualizar estado segun not_id */
        case "actualizar";
            $notificacion->update_notificacion_estado($_POST["not_id"]);
            break;

        /* TODO: Listado de notificacion segun formato json para el datatable */    
        case "listar":
            $rol_id =  $_POST["rol_id"];
            $datos  = "";
            //Administrador: Traigo todas las notificaciones
            if($rol_id == 3){
                $datos=$notificacion->get_notificacion_xAll1($_POST["usu_id"]);
            }else{
                $datos=$notificacion->get_notificacion_x_usu2($_POST["usu_id"]);
    
            }
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

    }
?>