<?php
    class Usuario extends Conectar{

        /* TODO: Funcion de login y generacion de session */
        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                $rol = $_POST["rol_id"];
                if(empty($correo) and empty($pass)){
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? 
                    and usu_pass=MD5(?) and rol_id=? and est=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->bindValue(3, $rol);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nom"]=$resultado["usu_nom"];
                        $_SESSION["usu_ape"]=$resultado["usu_ape"];
                        $_SESSION["rol_id"]=$resultado["rol_id"];
                        header("Location:".Conectar::ruta()."view/Home/");
                        exit(); 
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }
        }

        /* TODO:Insert */
        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, usu_telf, fech_crea, fech_modi, fech_elim, est) VALUES (NULL,?,?,?,MD5(?),?,?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$usu_telf){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = ?,
                rol_id = ?,
                usu_telf = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_telf);
            $sql->bindValue(7, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_d_usuario_01(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Todos los registros */
        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Obtener registros de usuarios segun rol 2 */
        public function get_usuario_x_rol(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario where est=1 and rol_id=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_02(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de registros segun usu_id */
        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Abiertos por usu_id */
        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets Cerrado por usu_id */
        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Total de Tickets por categoria segun usuario */
        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //GRAFICO SOPORTE
        public function graficoSoporte(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            (
                SELECT COUNT(*)  
                FROM tm_ticket t
                WHERE t.tick_estado = 'Cerrado'
                AND t.tick_estre = '5'
                AND t.usu_asig = u.usu_id
            ) AS estrella5,
            (
                SELECT COUNT(*)  
                FROM tm_ticket t
                WHERE t.tick_estado = 'Cerrado'
                AND t.tick_estre = '4'
                AND t.usu_asig = u.usu_id
            ) AS estrella4
            ,
            (
                SELECT COUNT(*)  
                FROM tm_ticket t
                WHERE t.tick_estado = 'Cerrado'
                AND t.tick_estre = '3'
                AND t.usu_asig = u.usu_id
            ) AS estrella3,
            (
                SELECT COUNT(*)  
                FROM tm_ticket t
                WHERE t.tick_estado = 'Cerrado'
                AND t.tick_estre = '2'
                AND t.usu_asig = u.usu_id
            ) AS estrella2,
            (
                SELECT COUNT(*)  
                FROM tm_ticket t
                WHERE t.tick_estado = 'Cerrado'
                AND t.tick_estre = '1'
                AND t.usu_asig = u.usu_id
            ) AS estrella1
            ,u.*
            FROM tm_usuario u
            WHERE u.rol_id = '2'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            $resultado = $resultado=$sql->fetchAll();
            foreach($resultado as $key => $item){
                $valor5 = $item['estrella5'];
                $valor4 = $item['estrella4'];
                $valor3 = $item['estrella3'];
                $valor2 = $item['estrella2'];
                $valor1 = $item['estrella1'];
                //PROCESO
                $total5 = $this->algoritmoRestarParaGraficoSoporte($item['estrella5'],$item,$valor4,$valor3,$valor2,$valor1);
                $total4 = $this->algoritmoRestarParaGraficoSoporte($item['estrella4'],$item,$valor5,$valor3,$valor2,$valor1);
                $total3 = $this->algoritmoRestarParaGraficoSoporte($item['estrella3'],$item,$valor5,$valor4,$valor2,$valor1);
                $total2 = $this->algoritmoRestarParaGraficoSoporte($item['estrella2'],$item,$valor5,$valor4,$valor3,$valor1);
                $total1 = $this->algoritmoRestarParaGraficoSoporte($item['estrella1'],$item,$valor5,$valor4,$valor3,$valor2);
                $datos[$key] = [
                    'estrella5'         => $item['estrella5'],
                    'estrella4'         => $item['estrella4'],
                    'estrella3'         => $item['estrella3'],
                    'estrella2'         => $item['estrella2'],
                    'estrella1'         => $item['estrella1'],
                    'usu_nom'           => $item['usu_nom'],
                    'usu_ape'           => $item['usu_ape'],
                    'usu_id'            => $item['usu_id'],
                    'total5'            => $total5,
                    'total4'            => $total4,
                    'total3'            => $total3,
                    'total2'            => $total2,
                    'total1'            => $total1,
                ];
            }
            return $datos;
        }
        public function algoritmoRestarParaGraficoSoporte($estrella,$array,$valor1,$valor2,$valor3,$valor4){
            $contador = 0;
            if($estrella > $valor1) { ++$contador; }
            if($estrella > $valor2) { ++$contador; }
            if($estrella > $valor3) { ++$contador; }
            if($estrella > $valor4) { ++$contador; }
            return $contador;            
        }
        public function mostrarCalificaciones($usu_id,$calificacion){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT u.*,t.fech_cierre,t.tick_coment
            FROM tm_ticket t
            LEFT JOIN tm_usuario u ON t.usu_id = u.usu_id
            WHERE usu_asig = ?
            AND tick_estre = ?
            AND u.rol_id = '1'
            order by t.fech_cierre desc
            ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $calificacion);
            $sql->execute();
            //haz un update de usu_id 
            return $resultado=$sql->fetchAll();
            
        }
        /* TODO: Actualizar contraseña del usuario */
        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    usu_pass = MD5(?)
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>