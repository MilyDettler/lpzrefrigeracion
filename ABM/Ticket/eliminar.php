<?php
include '../../php/conexion.php';

$id = $_GET['id'];
$sql = "DELETE FROM tickets WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

header('Location: listar.php');
?>
