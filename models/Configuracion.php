<?php

class Configuracion{
    public function BackupDb(){
        $host = 'localhost';
        $usuario = 'root';
        $contraseña = '';
        $base_de_datos = 'help';

        $conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

        if ($conexion->connect_error) {
            die("Error al conectar a la base de datos: " . $conexion->connect_error);
        }

        // Obtener la lista de todas las tablas
        $query = "SHOW TABLES";
        $tablas = $conexion->query($query);

        if (!$tablas) {
            die("Error al recuperar las tablas: " . $conexion->error);
        }
        $fecha = date("Y-m-d");
        $archivo = "../backups/Backup-".$fecha.".sql";
        $file = fopen($archivo, 'w');
        // Copia de seguridad de las tablas
        while ($tabla = $tablas->fetch_row()) {
            $nombre_tabla = $tabla[0];

            // Generar la sentencia CREATE TABLE
            $createTableQuery = $conexion->query("SHOW CREATE TABLE $nombre_tabla");
            $createTableData = $createTableQuery->fetch_assoc();

            fwrite($file, $createTableData['Create Table'] . ";\n\n");

            // Volcar el contenido de la tabla
            $datos = $conexion->query("SELECT * FROM $nombre_tabla");

            // while ($fila = $datos->fetch_assoc()) {
            //     $valores = array_map([$conexion, 'real_escape_string'], array_values($fila));
            //     $valores = join("', '", $valores);
            //     $sql = "INSERT INTO $nombre_tabla VALUES ('" . $valores . "');\n";
            //     fwrite($file, $sql);
            // }
            while ($fila = $datos->fetch_assoc()) {
                $valores = array_map([$conexion, 'real_escape_string'], array_values($fila));
                $valores = array_map(function ($valor) {
                    return ($valor == null) ? 'NULL' : "'" . $valor . "'";
                }, $valores);
            
                $sql = "INSERT INTO $nombre_tabla VALUES (" . implode(', ', $valores) . ");\n";
                fwrite($file, $sql);
            }

            fwrite($file, "\n\n");
        }

        // Copia de seguridad de los procedimientos almacenados
        $queryProcedures = "SHOW PROCEDURE STATUS WHERE Db = '$base_de_datos'";
        $procedures = $conexion->query($queryProcedures);

        if ($procedures) {
            while ($procedure = $procedures->fetch_assoc()) {
                $nombre_procedimiento = $procedure['Name'];
                $createProcedureQuery = $conexion->query("SHOW CREATE PROCEDURE $nombre_procedimiento");
                $createProcedureData = $createProcedureQuery->fetch_assoc();
                fwrite($file, "DELIMITER ;;\n");
                fwrite($file, $createProcedureData['Create Procedure'] . ";;\n");
                fwrite($file, "DELIMITER ;\n\n");
            }
        }

        fclose($file);
        $conexion->close();
    }
}