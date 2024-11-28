<?php
include '../../php/conexion.php';

$query = "SELECT * FROM provincias";
$provincias = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Provincias</title>
    <style>
        /* Añade estilos generales */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        h1 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #28a745; color: #fff; }
        a, button { padding: 5px 10px; border: none; cursor: pointer; text-decoration: none; color: white; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #dc3545; }
    </style>
</head>
<body>
    <h1>Provincias</h1>
    <a href="agregar.php" class="btn-edit">Agregar Provincia</a>
    <a href="../../formulario/formularios.php" class="btn-edit">Volver al Formulario</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($provincias as $provincia): ?>
        <tr>
            <td><?= $provincia['id'] ?></td>
            <td><?= htmlspecialchars($provincia['descripcion']) ?></td>
            <td><?= $provincia['estado'] ? 'Activo' : 'Inactivo' ?></td>
            <td>
                <a href="editar.php?id=<?= $provincia['id'] ?>" class="btn-edit">Editar</a>
                <a href="eliminar.php?id=<?= $provincia['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta provincia?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
