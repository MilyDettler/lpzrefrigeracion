<?php
include '../../php/conexion.php';

$sql = "SELECT * FROM tickets";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tickets</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #003399, #66ccff);
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            font-size: 2em;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        a {
            color: #ffffff;
            background-color: #0044cc;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-right: 10px;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        }

        a:hover {
            background-color: #003366;
        }

        /* Estilos de la tabla */
        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0044cc;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td a {
            color: #ffffff; /* Cambiado a blanco */
            font-weight: bold;
            text-decoration: none;
            margin-right: 10px;
            background-color: #0044cc; /* Color de fondo para los enlaces */
            padding: 8px 12px; /* Espaciado para los enlaces */
            border-radius: 5px; /* Bordes redondeados */
            transition: background-color 0.3s ease;
        }

        td a:hover {
            background-color: #003366; /* Color de fondo al pasar el mouse */
        }
    </style>
</head>
<body>
    <h1>Lista de Tickets</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Ticket</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket['id'] ?></td>
                <td><?= $ticket['numero_ticket'] ?></td>
                <td><?= $ticket['descripcion'] ?></td>
                <td><?= $ticket['estado'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $ticket['id'] ?>">Modificar</a>
                    <a href="eliminar.php?id=<?= $ticket['id'] ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br><a href="agregar.php">Agregar Nuevo Ticket</a><br>
    <a href="../../formulario/formularios.php">Volver al formulario</a>
</body>
</html>


