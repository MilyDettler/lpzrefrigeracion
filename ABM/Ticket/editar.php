<?php
include '../../php/conexion.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tickets WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_ticket = $_POST['numero_ticket'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $tienda_id = $_POST['tienda_id'];
    $localidad_id = $_POST['localidad_id'];
    $provincia_id = $_POST['provincia_id'];

    $sql = "UPDATE tickets SET numero_ticket = :numero_ticket, descripcion = :descripcion, estado = :estado, tienda_id = :tienda_id, localidad_id = :localidad_id, provincia_id = :provincia_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'numero_ticket' => $numero_ticket,
        'descripcion' => $descripcion,
        'estado' => $estado,
        'tienda_id' => $tienda_id,
        'localidad_id' => $localidad_id,
        'provincia_id' => $provincia_id,
        'id' => $id
    ]);

    header('Location: listar.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #4cae4c;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Editar Ticket</h1>
    <form method="POST">
        <label>Número de Ticket:</label>
        <input type="number" name="numero_ticket" value="<?= $ticket['numero_ticket'] ?>" required>
        
        <label>Descripción:</label>
        <input type="text" name="descripcion" value="<?= $ticket['descripcion'] ?>" required>
        
        <label>Estado:</label>
        <select name="estado" required>
            <option value="abierto" <?= $ticket['estado'] == 'abierto' ? 'selected' : '' ?>>Abierto</option>
            <option value="cerrado" <?= $ticket['estado'] == 'cerrado' ? 'selected' : '' ?>>Cerrado</option>
        </select>
        
        <label>Tienda ID:</label>
        <input type="number" name="tienda_id" value="<?= $ticket['tienda_id'] ?>" required>
        
        <label>Localidad ID:</label>
        <input type="number" name="localidad_id" value="<?= $ticket['localidad_id'] ?>" required>
        
        <label>Provincia ID:</label>
        <input type="number" name="provincia_id" value="<?= $ticket['provincia_id'] ?>" required>
        
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="listar.php">Volver a la lista</a>
</body>
</html>
