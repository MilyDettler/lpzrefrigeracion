<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tienda = $_POST['tienda'];
    $localidad_id = $_POST['localidad_id'];
    $provincia_id = $_POST['provincia_id'];

    $sql = "INSERT INTO tienda (numero_tienda, localidad_id, provincia_id) 
            VALUES (:numero_tienda, :localidad_id, :provincia_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'numero_tienda' => $tienda,
        'localidad_id' => $localidad_id,
        'provincia_id' => $provincia_id
    ]);

    header('Location: listar.php');
    exit;
}

// Consultas para obtener localidades y provincias
$localidades = $pdo->query("SELECT id, descripcion FROM localidades")->fetchAll(PDO::FETCH_ASSOC);
$provincias = $pdo->query("SELECT id, descripcion FROM provincias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Tienda</title>
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
    <h1>Agregar Tienda</h1>
    <form method="POST">
        <label>Número de Tienda:</label>
        <input type="number" name="tienda" required>

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
    <a href="listar.php">Volver a la lista de tiendas</a>
</body>
</html>
