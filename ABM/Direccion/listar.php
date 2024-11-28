<?php
include '../../php/conexion.php';

// Cambia 'l.direccion' a 'l.nombre' o al nombre correcto de la columna
$direcciones = $pdo->query("SELECT d.id, d.direccion, l.descripcion AS localidad, p.descripcion AS provincia 
                              FROM direcciones d 
                              JOIN localidades l ON d.localidad_id = l.id 
                              JOIN provincias p ON d.provincia_id = p.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar Direcciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lista de Direcciones</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($direcciones as $direccion): ?>
                <tr>
                    <td><?php echo $direccion['id']; ?></td>
                    <td><?php echo $direccion['direccion']; ?></td>
                    <td><?php echo $direccion['localidad']; ?></td>
                    <td><?php echo $direccion['provincia']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $direccion['id']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $direccion['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="agregar.php">Agregar Nueva Dirección</a>
    <a href="../../formulario/formularios.php">Volver al Formulario</a>
</body>
</html>
