<?php
    class Reporte extends Conectar{

        /* TODO: Obtener todos los registros */
        public function get_reporte(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_reporte_02()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_reporte_fechas($fechadesde, $fechahasta){
            $conectar = parent::conexion();
            parent::set_names();
            
            // Llamada al procedimiento almacenado con parámetros
            $sql = "CALL sp_l_reporteFechas(?, ?)";
            
            // Preparar la consulta
            $sql = $conectar->prepare($sql);
            
            // Pasar los parámetros de fecha
            $sql->bindValue(1, $fechadesde);
            $sql->bindValue(2, $fechahasta);
            
            // Ejecutar la consulta
            $sql->execute();
            
            // Obtener los resultados
            return $resultado = $sql->fetchAll();
        }


    }
?>