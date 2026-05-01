<?php
    class Modem extends Conectar{

        /* ========================================
           MÉTODOS PARA tm_modem (catálogo de módems)
        ======================================== */

        public function existe_modem_nombre($modem_nombre, $modem_id = null){
            $conectar = parent::conexion();
            parent::set_names();
            if($modem_id){
                $sql = "SELECT COUNT(*) as total FROM tm_modem WHERE modem_nombre = ? AND est = 1 AND modem_id != ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $modem_nombre);
                $sql->bindValue(2, $modem_id);
            } else {
                $sql = "SELECT COUNT(*) as total FROM tm_modem WHERE modem_nombre = ? AND est = 1";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $modem_nombre);
            }
            $sql->execute();
            $row = $sql->fetch();
            return $row["total"] > 0;
        }

        public function insert_modem($modem_nombre, $usu_crea){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_modem (modem_nombre, usu_crea, fech_crea, est) VALUES (?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_nombre);
            $sql->bindValue(2, $usu_crea);
            $sql->execute();
            return $conectar->lastInsertId();
        }

        public function update_modem($modem_id, $modem_nombre){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_modem SET modem_nombre = ?, fech_modi = NOW() WHERE modem_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_nombre);
            $sql->bindValue(2, $modem_id);
            $sql->execute();
        }

        public function delete_modem($modem_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_modem SET est = 0 WHERE modem_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->execute();
        }

        public function get_modems(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_modem WHERE est = 1 ORDER BY modem_id DESC";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_modem_id($modem_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_modem WHERE modem_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* ========================================
           MÉTODOS PARA tm_modem_detalle (características por módem)
        ======================================== */

        public function insert_detalle($modem_id, $carac_id, $detalle_valor){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_modem_detalle (modem_id, carac_id, detalle_valor, fech_crea, est) VALUES (?, ?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->bindValue(2, $carac_id);
            $sql->bindValue(3, $detalle_valor);
            $sql->execute();
        }

        public function get_caracteristicas_modem($modem_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT d.*, c.carac_nombre, c.carac_tipo 
                    FROM tm_modem_detalle d
                    INNER JOIN tm_caracteristica_modem c ON d.carac_id = c.carac_id
                    WHERE d.modem_id = ? AND d.est = 1
                    ORDER BY c.carac_tipo, c.carac_nombre";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function delete_detalles($modem_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "DELETE FROM tm_modem_detalle WHERE modem_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->execute();
        }

        /* ========================================
           MÉTODOS PARA tm_caracteristica_modem (catálogo)
        ======================================== */

        public function existe_caracteristica_nombre($carac_nombre, $carac_id = null){
            $conectar = parent::conexion();
            parent::set_names();
            if($carac_id){
                $sql = "SELECT COUNT(*) as total FROM tm_caracteristica_modem WHERE carac_nombre = ? AND est = 1 AND carac_id != ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $carac_nombre);
                $sql->bindValue(2, $carac_id);
            } else {
                $sql = "SELECT COUNT(*) as total FROM tm_caracteristica_modem WHERE carac_nombre = ? AND est = 1";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $carac_nombre);
            }
            $sql->execute();
            $row = $sql->fetch();
            return $row["total"] > 0;
        }

        public function insert_caracteristica($carac_nombre, $carac_tipo){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_caracteristica_modem (carac_nombre, carac_tipo, fech_crea, est) VALUES (?, ?, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $carac_nombre);
            $sql->bindValue(2, $carac_tipo);
            $sql->execute();
        }

        public function get_caracteristicas(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_caracteristica_modem WHERE est = 1 ORDER BY carac_tipo, carac_nombre";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function delete_caracteristica($carac_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_caracteristica_modem SET est = 0 WHERE carac_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $carac_id);
            $sql->execute();
        }

        /* ========================================
           MÉTODOS PARA tm_modem_cabecera (asignación a usuario)
        ======================================== */

        public function insert_asignacion($modem_id, $usu_id, $usu_asigno_id, $observaciones){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_modem_cabecera (modem_id, usu_id, usu_asigno_id, fecha_asignacion, observaciones, estado_activo, fech_crea, est)
                    VALUES (?, ?, ?, NOW(), ?, 1, NOW(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $usu_asigno_id);
            $sql->bindValue(4, $observaciones);
            $sql->execute();
            return $conectar->lastInsertId();
        }

        public function update_asignacion($asig_id, $modem_id, $usu_id, $observaciones, $estado_activo){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_modem_cabecera SET modem_id=?, usu_id=?, observaciones=?, estado_activo=?, fech_modi=NOW() WHERE asig_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $modem_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $observaciones);
            $sql->bindValue(4, $estado_activo);
            $sql->bindValue(5, $asig_id);
            $sql->execute();
        }

        public function delete_asignacion($asig_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_modem_cabecera SET est = 0 WHERE asig_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $asig_id);
            $sql->execute();
        }

        public function get_asignaciones(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT a.*, m.modem_nombre, u.usu_nom, u.usu_ape, u.usu_numemp
                    FROM tm_modem_cabecera a
                    INNER JOIN tm_modem m ON a.modem_id = m.modem_id
                    INNER JOIN tm_usuario u ON a.usu_id = u.usu_id
                    WHERE a.est = 1
                    ORDER BY a.estado_activo DESC, a.asig_id DESC";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_asignacion_id($asig_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_modem_cabecera WHERE asig_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $asig_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        public function desactivar_otras_asignaciones($usu_id, $asig_id_actual){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_modem_cabecera SET estado_activo = 0 WHERE usu_id = ? AND asig_id != ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $asig_id_actual);
            $sql->execute();
        }

        public function get_mi_modem($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT a.*, m.modem_nombre
                    FROM tm_modem_cabecera a
                    INNER JOIN tm_modem m ON a.modem_id = m.modem_id
                    WHERE a.usu_id = ? AND a.estado_activo = 1 AND a.est = 1
                    LIMIT 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }

        /* ========================================
           AUXILIARES
        ======================================== */

        public function get_usuarios(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT usu_id, usu_nom, usu_ape, usu_numemp FROM tm_usuario WHERE est = 1 AND rol_id = 1 ORDER BY usu_nom, usu_ape";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        }
    }
?>
