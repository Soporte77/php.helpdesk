<?php
    /* TODO: Inicio de Sesion en la WebApp */
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                //TODO: Cadena de Conexion Local
                //$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=helpdesk","root","");
				$conectar = $this->dbh = new PDO("mysql:local=187.237.254.57;dbname=helpdesk","root","");
                //TODO: Cadenad e Conexion Produccion
                //$conectar = $this->dbh = new PDO("mysql:host=187.237.254.57;dbname=Peticiones_helpdesk1","Peticiones","contraseña");
				return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        /* TODO: Set Name para utf 8 español - evitar tener problemas con las tildes */
        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        /* TODO: Ruta o Link del proyecto */
        public static function ruta(){
            return "http://187.237.254.57/peticiones/";
            //TODO: Ruta Proyecto Local
			//return "http://localhost/peticiones/";
           
            //TODO: Ruta Proyecto Produccion
          
		}

    }
?>