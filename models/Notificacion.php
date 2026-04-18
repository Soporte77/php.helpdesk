<?php
    class Notificacion extends Conectar{

        /* TODO:Todos los registros */
        public function get_notificacion_x_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_notificacion WHERE usu_id= ? AND est=2 Limit 1;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        /* TODO:Todos los registros para el administrador*/
        public function get_notificacion_xAll(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_notificacion WHERE est=2 Limit 1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Obtener registro segun el usuario */
        public function get_notificacion_x_usu2($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_notificacion WHERE usu_id= ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23
        /* TODO: Traer todas las notificaciones para el administrador */
        public function get_notificacion_xAll2($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_notificacion
            WHERE usu_id= ?
            AND est=2
            ORDER BY not_id DESC
            Limit 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }//Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23


         //Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23
        /* TODO: Traer todas las notificaciones para el administrador */
        public function get_notificacion_xAll1($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_notificacion
            WHERE usu_id= ?
            AND est=1
            ORDER BY not_id DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }//Cambio JCPR para enviar notificacion para todos los administradores cuando se genere un ticket 06/09/23


        /* TODO: Actualizar estado de la notificacion luego de ser mostrado */
        public function update_notificacion_estado($not_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_notificacion SET est=1 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Actualizar notificacion luego de ser leido */
        public function update_notificacion_estado_read($not_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_notificacion SET est=0 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>