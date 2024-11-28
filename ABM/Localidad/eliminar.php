<?php
include '../../php/conexion.php';

$id = $_GET['id'];
$sql = "DELETE FROM localidades WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

header("Location: listar.php");
exit();
?>




