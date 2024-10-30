<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Modelo departamento */
    require_once("../models/Departamento.php");
    $departamento = new Departamento();

    /*TODO: opciones del controlador departamento*/
    switch($_GET["op"]){
        /* TODO: Guardar y editar, guardar si el campo prio_id esta vacio */
        case "guardaryeditar":
            if(empty($_POST["depto_id"])){       
                $departamento->insert_departamento($_POST["dep_id"], $_POST["depto_nom"]);     
            }
            else {
                $departamento->update_departamento($_POST["depto_id"],$_POST["depto_nom"]);
            }
            break;

        /* TODO: Listado de departamento segun formato json para el datatable */
        case "listar":
            $datos=$departamento->get_departamentos_all();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["dep_nom"];
                $sub_array[] = $row["depto_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["depto_id"].');"  id="'.$row["depto_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["depto_id"].');"  id="'.$row["depto_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        /* TODO: Actualizar estado a 0 segun id de departamento */
        case "eliminar":
            $departamento->delete_departamento($_POST["depto_id"]);
            break;
        
        /* TODO: Mostrar en formato JSON segun prio_id */
        case "mostrar";
            
            $datos=$departamento->get_departamento_x_id($_POST["dep_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['depto_id']."'>".$row['depto_nom']."</option>";
                }
                echo $html;
            }
            break;

        
            case "mostraredit";
            $datos=$departamento->get_departamentoedit_x_id($_POST["depto_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["depto_id"] = $row["depto_id"];
                    $output["dep_id"] = $row["dep_id"];
                    $output["depto_nom"] = $row["depto_nom"];
                }
                echo json_encode($output);
            }
            break;
        
        /* TODO: Formato para llenar combo en formato HTML */
        case "combo":
            $datos = $departamento->get_departamento($_POST["dep_id"]);
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['depto_id']."'>".$row['depto_nom']."</option>";
                }
                echo $html;
            }
            break;
    }
?>