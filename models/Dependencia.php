<?php
    class Dependencia extends Conectar{

        /* TODO:Todos los registros */
        public function get_dependencia(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_dependencia WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Insert */
        public function insert_dependencia($dep_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_dependencia (dep_id, dep_nom, est) VALUES (NULL,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_dependencia($dep_id,$dep_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_dependencia set
                dep_nom = ?
                WHERE
                dep_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_nom);
            $sql->bindValue(2, $dep_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_dependencia($dep_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_dependencia SET
                est = 0
                WHERE 
                dep_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_dependencia_x_id($dep_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_dependencia WHERE dep_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>