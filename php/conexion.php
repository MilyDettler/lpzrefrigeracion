<?php
$servidor = "localhost"; // Prueba con 'localhost'
$usuario = "root"; // Usuario de la base de datos en Alwaysdata
$contraseña = ""; // Contraseña de la base de datos
$base_datos = "lpzrefrigeracion"; // Nombre de la base de datos
 

// Crear conexión con MySQLi
$conexion = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Crear conexión con PDO
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>




