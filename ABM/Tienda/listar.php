<?php
include '../../php/conexion.php';

$tiendas = $pdo->query("SELECT t.id, t.numero_tienda, l.descripcion AS localidad, p.descripcion AS provincia
                         FROM tienda t
                         JOIN localidades l ON t.localidad_id = l.id
                         JOIN provincias p ON t.provincia_id = p.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tiendas</title>
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

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f8f8;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lista de Tiendas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Tienda</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tiendas as $tienda): ?>
                <tr>
                    <td><?php echo $tienda['id']; ?></td>
                    <td><?php echo $tienda['numero_tienda']; ?></td>
                    <td><?php echo $tienda['localidad']; ?></td>
                    <td><?php echo $tienda['provincia']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $tienda['id']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $tienda['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tienda?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="agregar.php">Agregar Nueva Tienda</a>
    <a href="../../formulario/formularios.php">Volver al formulario</a>
</body>
</html>
