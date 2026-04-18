<?php
    /* TODO: Cadena de Conexión */
    require_once("../config/conexion.php");
    /* TODO: Modelo EquipoComputo */
    require_once("../models/EquipoComputo.php");
    $equipocomputo = new EquipoComputo();

    /* TODO: Opciones del controlador EquipoComputo */
    switch($_GET["op"]){
        
        /* TODO: Guardar y editar */
        case "guardaryeditar":
            if(empty($_POST["equipo_id"])){       
                $equipocomputo->insert_equipo(
                    $_POST["tipo_equipo"],
                    $_POST["marca"],
                    $_POST["modelo"],
                    $_POST["serie"],
                    $_POST["inventario"],
                    $_POST["procesador"],
                    $_POST["ram"],
                    $_POST["disco"],
                    $_POST["sistema_operativo"],
                    $_POST["usuario_asignado"],
                    $_POST["departamento"],
                    $_POST["ubicacion"],
                    $_POST["fecha_compra"],
                    $_POST["estado_equipo"],
                    $_POST["observaciones"]
                );     
            } else {
                $equipocomputo->update_equipo(
                    $_POST["equipo_id"],
                    $_POST["tipo_equipo"],
                    $_POST["marca"],
                    $_POST["modelo"],
                    $_POST["serie"],
                    $_POST["inventario"],
                    $_POST["procesador"],
                    $_POST["ram"],
                    $_POST["disco"],
                    $_POST["sistema_operativo"],
                    $_POST["usuario_asignado"],
                    $_POST["departamento"],
                    $_POST["ubicacion"],
                    $_POST["fecha_compra"],
                    $_POST["estado_equipo"],
                    $_POST["observaciones"]
                );
            }
            break;

        /* TODO: Listado de equipos */
        case "listar":
            $datos = $equipocomputo->get_equipos();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["equipo_id"];
                $sub_array[] = $row["tipo_equipo"];
                $sub_array[] = $row["marca"];
                $sub_array[] = $row["modelo"];
                $sub_array[] = $row["serie"];
                $sub_array[] = $row["inventario"];
                $sub_array[] = $row["usuario_asignado"];
                
                if($row["estado_equipo"] == "Operativo"){
                    $sub_array[] = '<span class="label label-pill label-success">Operativo</span>';
                } else if($row["estado_equipo"] == "En Reparación"){
                    $sub_array[] = '<span class="label label-pill label-warning">En Reparación</span>';
                } else if($row["estado_equipo"] == "Disponible"){
                    $sub_array[] = '<span class="label label-pill label-info">Disponible</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-danger">Dado de Baja</span>';
                }
                
                $sub_array[] = '<button type="button" onClick="editar('.$row["equipo_id"].');" id="'.$row["equipo_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["equipo_id"].');" id="'.$row["equipo_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data
            );
            echo json_encode($results);
            break;

        /* TODO: Mostrar datos de un equipo */
        case "mostrar":
            $datos = $equipocomputo->get_equipo_id($_POST["equipo_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $output["equipo_id"] = $row["equipo_id"];
                    $output["tipo_equipo"] = $row["tipo_equipo"];
                    $output["marca"] = $row["marca"];
                    $output["modelo"] = $row["modelo"];
                    $output["serie"] = $row["serie"];
                    $output["inventario"] = $row["inventario"];
                    $output["procesador"] = $row["procesador"];
                    $output["ram"] = $row["ram"];
                    $output["disco"] = $row["disco"];
                    $output["sistema_operativo"] = $row["sistema_operativo"];
                    $output["usuario_asignado"] = $row["usuario_asignado"];
                    $output["departamento"] = $row["departamento"];
                    $output["ubicacion"] = $row["ubicacion"];
                    $output["fecha_compra"] = $row["fecha_compra"];
                    $output["estado_equipo"] = $row["estado_equipo"];
                    $output["observaciones"] = $row["observaciones"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Eliminar equipo */
        case "eliminar":
            $equipocomputo->delete_equipo($_POST["equipo_id"]);
            break;
    }
?>
