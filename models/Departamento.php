<?php
    class Departamento extends Conectar{

        /* TODO:Todos los registros */
        public function get_departamento($dep_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_departamento 
                  WHERE dep_id = ?  
                  AND est=1;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


         /* TODO: Obtener todos los registros sin filtro */
         public function get_departamentos_all(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                    tm_departamento.depto_id,
                    tm_departamento.dep_id,
                    tm_departamento.depto_nom,
                    tm_dependencia.dep_nom
                    FROM tm_departamento INNER JOIN
                    tm_dependencia on tm_departamento.dep_id = tm_dependencia.dep_id
                    WHERE tm_departamento.est=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


        /* TODO:Insert */
        public function insert_departamento($dep_id,$dep_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_departamento (depto_id, dep_id, depto_nom, est) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_id);
            $sql->bindValue(2, $dep_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_departamento($depto_id, $depto_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_departamento set
                depto_nom = ?
                WHERE
                depto_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $depto_nom);
            $sql->bindValue(2, $depto_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_departamento($depto_id){
            
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_departamento SET
                est = 0
                WHERE 
                depto_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $depto_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_departamento_x_id($dep_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_departamento WHERE dep_id = ? and est = 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $dep_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_departamentoedit_x_id($depto_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_departamento WHERE depto_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $depto_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>