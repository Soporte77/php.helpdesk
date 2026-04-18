<?php
    class EquipoComputo extends Conectar{

        /* TODO: Insertar nuevo equipo */
        public function insert_equipo($tipo_equipo, $marca, $modelo, $serie, $inventario, $procesador, $ram, $disco, $sistema_operativo, $usuario_asignado, $departamento, $ubicacion, $fecha_compra, $estado_equipo, $observaciones){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_equipo_computo (equipo_id, tipo_equipo, marca, modelo, serie, inventario, procesador, ram, disco, sistema_operativo, usuario_asignado, departamento, ubicacion, fecha_compra, estado_equipo, observaciones, fech_crea, est) 
                    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), 1)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tipo_equipo);
            $sql->bindValue(2, $marca);
            $sql->bindValue(3, $modelo);
            $sql->bindValue(4, $serie);
            $sql->bindValue(5, $inventario);
            $sql->bindValue(6, $procesador);
            $sql->bindValue(7, $ram);
            $sql->bindValue(8, $disco);
            $sql->bindValue(9, $sistema_operativo);
            $sql->bindValue(10, $usuario_asignado);
            $sql->bindValue(11, $departamento);
            $sql->bindValue(12, $ubicacion);
            $sql->bindValue(13, $fecha_compra);
            $sql->bindValue(14, $estado_equipo);
            $sql->bindValue(15, $observaciones);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Actualizar equipo */
        public function update_equipo($equipo_id, $tipo_equipo, $marca, $modelo, $serie, $inventario, $procesador, $ram, $disco, $sistema_operativo, $usuario_asignado, $departamento, $ubicacion, $fecha_compra, $estado_equipo, $observaciones){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_equipo_computo SET
                    tipo_equipo = ?,
                    marca = ?,
                    modelo = ?,
                    serie = ?,
                    inventario = ?,
                    procesador = ?,
                    ram = ?,
                    disco = ?,
                    sistema_operativo = ?,
                    usuario_asignado = ?,
                    departamento = ?,
                    ubicacion = ?,
                    fecha_compra = ?,
                    estado_equipo = ?,
                    observaciones = ?,
                    fech_modi = now()
                    WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tipo_equipo);
            $sql->bindValue(2, $marca);
            $sql->bindValue(3, $modelo);
            $sql->bindValue(4, $serie);
            $sql->bindValue(5, $inventario);
            $sql->bindValue(6, $procesador);
            $sql->bindValue(7, $ram);
            $sql->bindValue(8, $disco);
            $sql->bindValue(9, $sistema_operativo);
            $sql->bindValue(10, $usuario_asignado);
            $sql->bindValue(11, $departamento);
            $sql->bindValue(12, $ubicacion);
            $sql->bindValue(13, $fecha_compra);
            $sql->bindValue(14, $estado_equipo);
            $sql->bindValue(15, $observaciones);
            $sql->bindValue(16, $equipo_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Eliminar equipo (eliminación lógica) */
        public function delete_equipo($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_equipo_computo SET est=0, fech_elim=now() WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Listar todos los equipos activos */
        public function get_equipos(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_computo WHERE est=1 ORDER BY equipo_id DESC";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Obtener equipo por ID */
        public function get_equipo_id($equipo_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_computo WHERE equipo_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $equipo_id);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Obtener equipos por usuario asignado */
        public function get_equipos_by_usuario($usuario_asignado){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_computo WHERE usuario_asignado LIKE ? AND est=1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, "%".$usuario_asignado."%");
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Obtener equipos por departamento */
        public function get_equipos_by_departamento($departamento){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_computo WHERE departamento LIKE ? AND est=1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, "%".$departamento."%");
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        /* TODO: Obtener equipos por estado */
        public function get_equipos_by_estado($estado_equipo){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_equipo_computo WHERE estado_equipo = ? AND est=1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $estado_equipo);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    }
?>
