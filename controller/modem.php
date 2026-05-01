<?php
    require_once("../config/conexion.php");
    require_once("../models/Modem.php");
    $modem = new Modem();

    switch($_GET["op"]){

        /* ---- CATÁLOGO DE MÓDEMS ---- */

        case "listar_modems":
            $datos = $modem->get_modems();
            $data = array();
            foreach($datos as $row){
                $sub = array();
                $sub[] = $row["modem_id"];
                $sub[] = $row["modem_nombre"];
                $sub[] = $row["fech_crea"];
                $sub[] = '<button type="button" onClick="editar_modem('.$row["modem_id"].');" class="btn btn-inline btn-warning btn-sm"><i class="fa fa-edit"></i></button> '
                        .'<button type="button" onClick="eliminar_modem('.$row["modem_id"].');" class="btn btn-inline btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                $data[] = $sub;
            }
            echo json_encode(array("sEcho"=>1,"iTotalRecords"=>count($data),"iTotalDisplayRecords"=>count($data),"aaData"=>$data));
            break;

        case "guardar_modem":
            $nombre = trim($_POST["modem_nombre"]);
            $modem_id_edit = !empty($_POST["modem_id"]) ? $_POST["modem_id"] : null;

            if($modem->existe_modem_nombre($nombre, $modem_id_edit)){
                echo json_encode(array("status"=>"error", "msg"=>"Ya existe un módem con ese nombre."));
                break;
            }

            if(empty($_POST["modem_id"])){
                $nuevo_id = $modem->insert_modem($nombre, $_SESSION["usu_id"]);
                // Guardar características si vienen
                if(isset($_POST["caracteristicas"])){
                    $caracteristicas = json_decode($_POST["caracteristicas"], true);
                    foreach($caracteristicas as $carac){
                        $modem->insert_detalle($nuevo_id, $carac["carac_id"], $carac["valor"]);
                    }
                }
            } else {
                $modem->update_modem($_POST["modem_id"], $nombre);
                // Reemplazar características
                $modem->delete_detalles($_POST["modem_id"]);
                if(isset($_POST["caracteristicas"])){
                    $caracteristicas = json_decode($_POST["caracteristicas"], true);
                    foreach($caracteristicas as $carac){
                        $modem->insert_detalle($_POST["modem_id"], $carac["carac_id"], $carac["valor"]);
                    }
                }
            }
            echo json_encode(array("status"=>"success"));
            break;

        case "mostrar_modem":
            $datos = $modem->get_modem_id($_POST["modem_id"]);
            if(is_array($datos) && count($datos) > 0){
                $output = $datos[0];
                $output["caracteristicas"] = $modem->get_caracteristicas_modem($_POST["modem_id"]);
                echo json_encode($output);
            }
            break;

        case "eliminar_modem":
            $modem->delete_modem($_POST["modem_id"]);
            echo json_encode(array("status"=>"success"));
            break;

        /* ---- CARACTERÍSTICAS DEL MÓDEM (detalle por módem) ---- */

        case "guardar_detalle":
            $modem->delete_detalles($_POST["modem_id"]);
            if(isset($_POST["caracteristicas"])){
                $caracteristicas = json_decode($_POST["caracteristicas"], true);
                foreach($caracteristicas as $carac){
                    $modem->insert_detalle($_POST["modem_id"], $carac["carac_id"], $carac["valor"]);
                }
            }
            echo json_encode(array("status"=>"success"));
            break;

        /* ---- CATÁLOGO DE CARACTERÍSTICAS ---- */

        case "listar_caracteristicas":
            $datos = $modem->get_caracteristicas();
            echo json_encode($datos);
            break;

        case "guardar_caracteristica":
            $nombre = trim($_POST["carac_nombre"]);
            if($modem->existe_caracteristica_nombre($nombre)){
                echo json_encode(array("status"=>"error", "msg"=>"Ya existe una característica con ese nombre."));
                break;
            }
            $modem->insert_caracteristica($nombre, $_POST["carac_tipo"]);
            echo json_encode(array("status"=>"success"));
            break;

        case "eliminar_caracteristica":
            $modem->delete_caracteristica($_POST["carac_id"]);
            echo json_encode(array("status"=>"success"));
            break;

        /* ---- ASIGNACIONES (cabecera) ---- */

        case "listar_asignaciones":
            $datos = $modem->get_asignaciones();
            $data = array();
            foreach($datos as $row){
                $sub = array();
                $sub[] = $row["asig_id"];
                $sub[] = $row["modem_nombre"];
                $sub[] = $row["usu_nom"].' '.$row["usu_ape"];
                if($row["estado_activo"] == 1){
                    $sub[] = '<span class="label label-pill label-success">Activo</span>';
                } else {
                    $sub[] = '<span class="label label-pill label-default">Inactivo</span>';
                }
                $sub[] = '<button type="button" onClick="editar_asignacion('.$row["asig_id"].');" class="btn btn-inline btn-warning btn-sm"><i class="fa fa-edit"></i></button> '
                        .'<button type="button" onClick="eliminar_asignacion('.$row["asig_id"].');" class="btn btn-inline btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                $data[] = $sub;
            }
            echo json_encode(array("sEcho"=>1,"iTotalRecords"=>count($data),"iTotalDisplayRecords"=>count($data),"aaData"=>$data));
            break;

        case "guardar_asignacion":
            if(empty($_POST["asig_id"])){
                $asig_id = $modem->insert_asignacion($_POST["modem_id"], $_POST["usu_id"], $_SESSION["usu_id"], $_POST["observaciones"]);
                if($_POST["estado_activo"] == 1){
                    $modem->desactivar_otras_asignaciones($_POST["usu_id"], $asig_id);
                }
            } else {
                $modem->update_asignacion($_POST["asig_id"], $_POST["modem_id"], $_POST["usu_id"], $_POST["observaciones"], $_POST["estado_activo"]);
                if($_POST["estado_activo"] == 1){
                    $modem->desactivar_otras_asignaciones($_POST["usu_id"], $_POST["asig_id"]);
                }
            }
            echo json_encode(array("status"=>"success"));
            break;

        case "mostrar_asignacion":
            $datos = $modem->get_asignacion_id($_POST["asig_id"]);
            if(is_array($datos) && count($datos) > 0){
                echo json_encode($datos[0]);
            }
            break;

        case "eliminar_asignacion":
            $modem->delete_asignacion($_POST["asig_id"]);
            echo json_encode(array("status"=>"success"));
            break;

        case "listar_usuarios":
            echo json_encode($modem->get_usuarios());
            break;

        case "listar_modems_select":
            echo json_encode($modem->get_modems());
            break;
    }
?>
