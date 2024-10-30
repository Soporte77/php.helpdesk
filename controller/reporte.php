<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Modelo Categoria */
    require_once("../models/Reporte.php");
    $reporte = new Reporte();

    /*TODO: opciones del controlador Categoria*/
    switch($_GET["op"]){
        
        
        /* TODO: Listado de categoria segun formato json para el datatable */
        case "listar":
            $datos=$reporte->get_reporte();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["dependencia"];
                $sub_array[] = $row["titulo"];
                $sub_array[] = $row["descripcion"];
                $sub_array[] = $row["estado"];
                $sub_array[] = $row["fechacreacion"];
                $sub_array[] = $row["fechacierre"];
                $sub_array[] = $row["fechaasignacion"];
                $sub_array[] = $row["Usuario"];
                $sub_array[] = $row["Soporte"];
                $sub_array[] = $row["categoria"];
                $sub_array[] = $row["Area"];
                $sub_array[] = $row["subcategoria"];
                $sub_array[] = $row["prioridad"];
                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        case "listar_fecha":
            // Usa $_POST para obtener las fechas
            $fechadesde = isset($_POST["fechadesde"]) ? $_POST["fechadesde"] : null;
            $fechahasta = isset($_POST["fechahasta"]) ? $_POST["fechahasta"] : null;
        
            // Asegúrate de que las fechas no sean nulas
            if ($fechadesde && $fechahasta) {
                // Llama al método para obtener los datos entre las fechas
                $datos = $reporte->get_reporte_fechas($fechadesde, $fechahasta); // Implementa este método
        
                $data = Array();
                foreach ($datos as $row) {
                    $sub_array = array();
                    $sub_array[] = $row["id"];
                    $sub_array[] = $row["dependencia"];
                    $sub_array[] = $row["titulo"];
                    $sub_array[] = $row["descripcion"];
                    $sub_array[] = $row["estado"];
                    $sub_array[] = $row["fechacreacion"];
                    $sub_array[] = $row["fechacierre"];
                    $sub_array[] = $row["fechaasignacion"];
                    $sub_array[] = $row["Usuario"];
                    $sub_array[] = $row["Soporte"];
                    $sub_array[] = $row["categoria"];
                    $sub_array[] = $row["Area"];
                    $sub_array[] = $row["subcategoria"];
                    $sub_array[] = $row["prioridad"];
                    
                    // Agrega los demás campos necesarios...
                    $data[] = $sub_array;
                }
        
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
            } else {
                // Manejar el caso en que las fechas son nulas
                echo json_encode(array("error" => "Fechas inválidas"));
            }
            break;
    }
    
/*tick.tick_id as id,
usudep.dep_nom as 'dependencia',
tick.tick_titulo as titulo,
tick.tick_descrip as descripcion,
tick.tick_estado as estado,
tick.fech_crea as fechacreacion,
tick.fech_cierre as fechacierre,
tick.fech_asig as fechaasignacion,
CONCAT (usucrea.usu_nom, ' ', usucrea.usu_ape) as Usuario,
IFNULL(CONCAT(usuasig.usu_nom, ' ', usuasig.usu_ape), 'Sin Asignar') as Soporte, 
cat.cat_nom as categoria,
cat.area as Area,
sub.cats_nom as subcategoria,
prio.prio_nom as prioridad*/
?>

