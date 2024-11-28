<?php
include '../../php/conexion.php';

$query = "SELECT l.id, l.descripcion, l.estado, p.descripcion AS provincia 
          FROM localidades l 
          LEFT JOIN provincias p ON l.provincia_id = p.id";
$stmt = $pdo->query($query);
$localidades = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Localidades</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Lista de Localidades</h1>
    <a href="agregar.php" class="btn">Agregar Localidad</a><br>
    <a href="../../formulario/formularios.php" class="btn">Volver al Formulario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Provincia</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($localidades as $localidad): ?>
                <tr>
                    <td><?= htmlspecialchars($localidad['id']) ?></td>
                    <td><?= htmlspecialchars($localidad['descripcion']) ?></td>
                    <td><?= htmlspecialchars($localidad['provincia']) ?></td>
                    <td><?= $localidad['estado'] ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="editar.php?id=<?= $localidad['id'] ?>" class="btn-edit">Editar</a>
                        <a href="eliminar.php?id=<?= $localidad['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
