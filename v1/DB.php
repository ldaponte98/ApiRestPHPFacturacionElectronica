<?php 

class Conexion
{
	public $server = "localhost"; // El servidor que utilizaremos, en este caso será el localhost 
	public $user = "root"; // El usuario que acabamos de crear en la base de datos 
	public $password = ""; // La contraseña del usuario que utilizaremos 
	public $name_database = "apge"; // El nombre de la base de datos 
	public $conection = null;
	
	function __construct($name_database =  "apge")
	{
		$this->conection = new mysqli($this->server, $this->user, $this->password,$this->name_database);
		$this->conection->set_charset("utf8");

		if (!$this->conection) { 
		    die('<strong>No pudo conectarse con el server:</strong> ' . mysql_error()); 
		}else{ 
		    // La siguiente linea no es necesaria, simplemente la pondremos ahora para poder observar que la conexión ha sido realizada 
		    //echo 'Conectado  satisfactoriamente al servidor <br />'; 
		} 
	}

}

?>