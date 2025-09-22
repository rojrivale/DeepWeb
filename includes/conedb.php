<?php 
// Conexión a la base de datos
$conexion = new mysqli("localhost","root","","deepwebb");

if($conexion ->connect_error){
    die("No se ha podido realizar la conexión con la Base de Datos correctamente.");
}
?>