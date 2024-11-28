<?php
// Establecer conexión a la base de datos
$servidor = "localhost";  // o el nombre de tu servidor
$usuario = "root";        // tu usuario de base de datos
$contraseña = "";         // tu contraseña de base de datos
$base_de_datos = "lpzrefrigeracion"; // el nombre de tu base de datos

// Crear la conexión
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>


