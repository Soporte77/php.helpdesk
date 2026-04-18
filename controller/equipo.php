<?php
    /* TODO: Cadena de Conexión */
    require_once("../config/conexion.php");
    /* TODO: Modelo Equipo */
    require_once("../models/Equipo.php");
    $equipo = new Equipo();

    /* TODO: Opciones del controlador */
    switch($_GET["op"]){
        
        /* TODO: Ver MI equipo (ROL 1 - Cliente) */
        case "mi_equipo":
            $usu_id = $_SESSION["usu_id"];
            $datos = $equipo->get_mi_equipo($usu_id);
            
            if(is_array($datos) && count($datos) > 0){
                $equipo_data = $datos[0];
                
                // Obtener características del equipo
                $caracteristicas = $equipo->get_caracteristicas_equipo($equipo_data['equipo_id']);
                $equipo_data['caracteristicas'] = $caracteristicas;
                
                echo json_encode($equipo_data);
            } else {
                echo json_encode(array('error' => 'No tiene equipo asignado'));
            }
            break;
        
        /* TODO: Listar todos los equipos (ROL 3 - Admin) */
        case "listar":
            $datos = $equipo->get_equipos();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["equipo_id"];
                $sub_array[] = $row["usu_nom"] . ' ' . $row["usu_ape"];
                
                if($row["estado_activo"] == 1){
                    $sub_array[] = '<span class="label label-pill label-success">Activo</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-default">Inactivo</span>';
                }
                
                $sub_array[] = '<button type="button" onClick="editar('.$row["equipo_id"].');" class="btn btn-inline btn-warning btn-sm"><i class="fa fa-edit"></i></button> ';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["equipo_id"].');" class="btn btn-inline btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
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

        /* TODO: Guardar y editar equipo */
        case "guardaryeditar":
            if(empty($_POST["equipo_id"])){       
                // Insertar nuevo equipo
                $equipo_id = $equipo->insert_equipo(
                    $_POST["usu_id"],
                    $_SESSION["usu_id"], // Usuario que asigna el equipo
                    $_POST["estado_activo"],
                    $_POST["observaciones"]
                );
                
                // Si es activo, desactivar otros equipos del mismo usuario
                if($_POST["estado_activo"] == 1){
                    $equipo->desactivar_otros_equipos($_POST["usu_id"], $equipo_id);
                }
                
                // Guardar características
                if(isset($_POST["caracteristicas"])){
                    $caracteristicas = json_decode($_POST["caracteristicas"], true);
                    foreach($caracteristicas as $carac){
                        $equipo->insert_detalle($equipo_id, $carac['carac_id'], $carac['valor']);
                    }
                }
                
            } else {
                // Actualizar equipo existente
                $equipo->update_equipo(
                    $_POST["equipo_id"],
                    $_POST["usu_id"],
                    $_POST["estado_activo"],
                    $_POST["observaciones"]
                );
                
                // Si es activo, desactivar otros equipos del mismo usuario
                if($_POST["estado_activo"] == 1){
                    $equipo->desactivar_otros_equipos($_POST["usu_id"], $_POST["equipo_id"]);
                }
                
                // Eliminar características antiguas
                $equipo->delete_detalles($_POST["equipo_id"]);
                
                // Guardar nuevas características
                if(isset($_POST["caracteristicas"])){
                    $caracteristicas = json_decode($_POST["caracteristicas"], true);
                    foreach($caracteristicas as $carac){
                        $equipo->insert_detalle($_POST["equipo_id"], $carac['carac_id'], $carac['valor']);
                    }
                }
            }
            echo json_encode(array("status" => "success"));
            break;

        /* TODO: Mostrar datos de un equipo */
        case "mostrar":
            $datos = $equipo->get_equipo_id($_POST["equipo_id"]);  
            if(is_array($datos) && count($datos) > 0){
                $output = $datos[0];
                
                // Obtener características
                $caracteristicas = $equipo->get_caracteristicas_equipo($_POST["equipo_id"]);
                $output['caracteristicas'] = $caracteristicas;
                
                echo json_encode($output);
            }
            break;

        /* TODO: Eliminar equipo */
        case "eliminar":
            $equipo->delete_equipo($_POST["equipo_id"]);
            echo json_encode(array("status" => "success"));
            break;
        
        /* TODO: Listar usuarios para asignar */
        case "listar_usuarios":
            $datos = $equipo->get_usuarios();
            echo json_encode($datos);
            break;
        
        /* TODO: Listar catálogo de características */
        case "listar_caracteristicas":
            $datos = $equipo->get_caracteristicas();
            echo json_encode($datos);
            break;
        
        /* TODO: Guardar nueva característica */
        case "guardar_caracteristica":
            $equipo->insert_caracteristica($_POST["carac_nombre"], $_POST["carac_tipo"]);
            echo json_encode(array("status" => "success"));
            break;
        
        /* TODO: Eliminar característica */
        case "eliminar_caracteristica":
            $equipo->delete_caracteristica($_POST["carac_id"]);
            echo json_encode(array("status" => "success"));
            break;
    }
?>
