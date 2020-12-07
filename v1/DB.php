<?php 


$server = "localhost"; // El servidor que utilizaremos, en este caso será el localhost 
$user = "root"; // El usuario que acabamos de crear en la base de datos 
$password = ""; // La contraseña del usuario que utilizaremos 
$name_database = "apge"; // El nombre de la base de datos 
$conection = new mysqli($server, $user, $password,$name_database);
$conection->set_charset("utf8");

if (!$conection) { 
    die('<strong>No pudo conectarse con el server:</strong> ' . mysql_error()); 
}else{ 
    // La siguiente linea no es necesaria, simplemente la pondremos ahora para poder observar que la conexión ha sido realizada 
    //echo 'Conectado  satisfactoriamente al servidor <br />'; 
} 
/* 
En esta linea seleccionaremos la BD con la que trabajaremos y le pasaremos como referencia la conexión al servidor. Para saber si se conecto o no a la BD podríamos utilizar el IF de la misma forma que la utilizamos al momento de conectar al servidor, pero usaremos otra forma de comprobar eso usando die(). 
*/

?>