<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Modelo dependencia */
    require_once("../models/Dependencia.php");
    $dependencia = new Dependencia();

    /*TODO: opciones del controlador dependencia*/
    switch($_GET["op"]){
        /* TODO: Guardar y editar, guardar si el campo prio_id esta vacio */
        case "guardaryeditar":
            if(empty($_POST["dep_id"])){       
                $dependencia->insert_dependencia($_POST["dep_nom"]);     
            }
            else {
                $dependencia->update_dependencia($_POST["dep_id"],$_POST["dep_nom"]);
            }
            break;

        /* TODO: Listado de dependencia segun formato json para el datatable */
        case "listar":
            $datos=$dependencia->get_dependencia();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["dep_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["dep_id"].');"  id="'.$row["dep_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["dep_id"].');"  id="'.$row["dep_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        /* TODO: Actualizar estado a 0 segun id de dependencia */
        case "eliminar":
            $dependencia->delete_dependencia($_POST["dep_id"]);
            break;
        
        /* TODO: Mostrar en formato JSON segun prio_id */
        case "mostrar";
            //$datos=$dependencia->get_dependencia_x_id($_POST["prio_id"]);
            $datos=$dependencia->get_dependencia_x_id($_POST["dep_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["dep_id"] = $row["dep_id"];
                    $output["dep_nom"] = $row["dep_nom"];
                }
                echo json_encode($output);
            }
            break;
        /* TODO: Formato para llenar combo en formato HTML */
        case "combo":
            $datos = $dependencia->get_dependencia();
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['dep_id']."'>".$row['dep_nom']."</option>";
                }
                echo $html;
            }
            break;
    }
?>