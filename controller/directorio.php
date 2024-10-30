<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Modelo Categoria */
    require_once("../models/Directorio.php");
    $directorio = new Directorio();

    /*TODO: opciones del controlador Categoria*/
    switch($_GET["op"]){
        
        
        /* TODO: Listado de categoria segun formato json para el datatable */
        case "listar":
            $datos=$directorio->get_directorio();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["ext_num"];
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["dep_nom"];
                $sub_array[] = $row["depto_nom"];
                $sub_array[] = $row["order_id"];
                
                
                                
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

