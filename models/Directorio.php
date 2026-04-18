<?php
    class Directorio extends Conectar{

        /* TODO: Obtener todos los registros */
        public function get_directorio(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_directorio_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }



    }
?>