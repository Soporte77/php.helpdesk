<?php
    class Equipo extends Conectar{

        /* ========================================
           MÉTODOS PARA EQUIPOS CABECERA
        ======================================== */

        /* TODO: Insertar nuevo equipo */
        public function insert_equipo($usu_id, $usu_asigno_id, $estado_activo, $observaciones){
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "INSERT INTO tm_equipo_cabecera 
                    (equipo_id, usu_id, usu_asigno_id, fecha_asignacion, observaciones, estado_activo, fech_crea, est) 
                    VALUES (NULL, ?, ?, NOW(), ?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $usu_asigno_id);
            $sql->bindValue(3, $observaciones);
            $sql->bindValue(4, $estado_activo);
            $sql->execute();
            
            // Obtener el ID del equipo insertado
            return $conectar->lastInsertId();
        }

        /* TODO: Actualizar equipo */
        public function update_equipo($equipo_id, $usu_id, $estado_activo, $observaciones){
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "UPDATE tm_equipo_cabecera SET
                    usu_id = ?,
                    estado_activo = ?,
                    observaciones = ?,
                    fech_modi = NOW()
                    WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $estado_activo);
            $sql->bindValue(3, $observaciones);
            $sql->bindValue(4, $equipo_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Eliminar equipo (eliminación lógica) */
        public function delete_equipo($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_equipo_cabecera SET est=0 WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Listar todos los equipos con datos de usuario */
        public function get_equipos(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT e.*, u.usu_nom, u.usu_ape, u.usu_numemp 
                    FROM tm_equipo_cabecera e
                    INNER JOIN tm_usuario u ON e.usu_id = u.usu_id
                    WHERE e.est = 1
                    ORDER BY e.estado_activo DESC, e.equipo_id DESC";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Obtener equipo por ID */
        public function get_equipo_id($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_cabecera WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Obtener equipo ACTIVO del usuario (para ROL 1) */
        public function get_mi_equipo($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT e.*, u.usu_nom AS asigno_nom, u.usu_ape AS asigno_ape 
                    FROM tm_equipo_cabecera e
                    LEFT JOIN tm_usuario u ON e.usu_asigno_id = u.usu_id
                    WHERE e.usu_id = ? AND e.estado_activo = 1 AND e.est = 1
                    LIMIT 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Desactivar otros equipos del mismo usuario */
        public function desactivar_otros_equipos($usu_id, $equipo_id_actual){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_equipo_cabecera 
                    SET estado_activo = 0 
                    WHERE usu_id = ? AND equipo_id != ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $equipo_id_actual);
            $sql->execute();
        }

        /* ========================================
           MÉTODOS PARA EQUIPOS DETALLE
        ======================================== */

        /* TODO: Insertar detalle de característica */
        public function insert_detalle($equipo_id, $carac_id, $detalle_valor){
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "INSERT INTO tm_equipo_detalle 
                    (detalle_id, equipo_id, carac_id, detalle_valor, fech_crea, est) 
                    VALUES (NULL, ?, ?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->bindValue(2, $carac_id);
            $sql->bindValue(3, $detalle_valor);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Obtener características de un equipo */
        public function get_caracteristicas_equipo($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "SELECT d.*, c.carac_nombre, c.carac_tipo 
                    FROM tm_equipo_detalle d
                    INNER JOIN tm_caracteristica_equipo c ON d.carac_id = c.carac_id
                    WHERE d.equipo_id = ? AND d.est = 1
                    ORDER BY c.carac_tipo, c.carac_nombre";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Eliminar todos los detalles de un equipo */
        public function delete_detalles($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "DELETE FROM tm_equipo_detalle WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
        }

        /* ========================================
           MÉTODOS PARA CATÁLOGO DE CARACTERÍSTICAS
        ======================================== */

        /* TODO: Insertar nueva característica */
        public function insert_caracteristica($carac_nombre, $carac_tipo){
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "INSERT INTO tm_caracteristica_equipo 
                    (carac_id, carac_nombre, carac_tipo, fech_crea, est) 
                    VALUES (NULL, ?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $carac_nombre);
            $sql->bindValue(2, $carac_tipo);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Listar todas las características activas */
        public function get_caracteristicas(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_caracteristica_equipo WHERE est = 1 ORDER BY carac_tipo, carac_nombre";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* TODO: Eliminar característica */
        public function delete_caracteristica($carac_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_caracteristica_equipo SET est = 0 WHERE carac_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $carac_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* ========================================
           MÉTODOS AUXILIARES
        ======================================== */

        /* TODO: Listar usuarios para asignar equipos */
        public function get_usuarios(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT usu_id, usu_nom, usu_ape, usu_numemp 
                    FROM tm_usuario 
                    WHERE est = 1 AND rol_id = 1
                    ORDER BY usu_nom, usu_ape";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }
    }
?>
