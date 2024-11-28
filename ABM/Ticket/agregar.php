<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_ticket = $_POST['numero_ticket'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $tienda_id = $_POST['tienda_id'];
    $localidad_id = $_POST['localidad_id'];
    $provincia_id = $_POST['provincia_id'];

    $sql = "INSERT INTO tickets (numero_ticket, descripcion, estado, tienda_id, localidad_id, provincia_id) 
            VALUES (:numero_ticket, :descripcion, :estado, :tienda_id, :localidad_id, :provincia_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'numero_ticket' => $numero_ticket,
        'descripcion' => $descripcion,
        'estado' => $estado,
        'tienda_id' => $tienda_id,
        'localidad_id' => $localidad_id,
        'provincia_id' => $provincia_id
    ]);

    header('Location: listar.php');
    exit;
}

// Consultas para obtener las tiendas, localidades y provincias
$tienda = $pdo->query("SELECT id, numero_tienda FROM tienda")->fetchAll(PDO::FETCH_ASSOC);
$localidades = $pdo->query("SELECT id, descripcion FROM localidades")->fetchAll(PDO::FETCH_ASSOC);
$provincias = $pdo->query("SELECT id, descripcion FROM provincias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Ticket</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="number"],
        input[type="text"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        button {
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            text-align: center;
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Agregar Ticket</h1>
    <form method="POST">
        <label>Número de Ticket:</label>
        <input type="number" name="numero_ticket" required>

        <label>Descripción:</label>
        <input type="text" name="descripcion" required>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="abierto">Abierto</option>
            <option value="cerrado">Cerrado</option>
        </select>

        <label>Tienda:</label>
        <select name="tienda_id" required>
            <option value="">Seleccione una tienda</option>
            <?php foreach ($tienda as $tienda): ?>
                <option value="<?php echo $tienda['id']; ?>"><?php echo $tienda['numero_tienda']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Localidad:</label>
        <select name="localidad_id" required>
            <option value="">Seleccione una localidad</option>
            <?php foreach ($localidades as $localidad): ?>
                <option value="<?php echo $localidad['id']; ?>"><?php echo $localidad['descripcion']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Provincia:</label>
        <select name="provincia_id" required>
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?php echo $provincia['id']; ?>"><?php echo $provincia['descripcion']; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Agregar</button>
    </form>
    <a href="listar.php">Volver a la lista de tickets</a>
</body>
</html>
