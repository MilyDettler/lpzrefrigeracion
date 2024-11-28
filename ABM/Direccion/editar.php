<?php
include '../../php/conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $direccion = $_POST['direccion'];
    $localidad_id = $_POST['localidad_id'];
    $provincia_id = $_POST['provincia_id'];

    $sql = "UPDATE direcciones SET direccion = :direccion, localidad_id = :localidad_id, provincia_id = :provincia_id 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'direccion' => $direccion,
        'localidad_id' => $localidad_id,
        'provincia_id' => $provincia_id,
        'id' => $id
    ]);

    header('Location: listar.php');
    exit;
}

// Consultas para obtener las localidades y provincias
$localidades = $pdo->query("SELECT id, descripcion FROM localidades")->fetchAll(PDO::FETCH_ASSOC);
$provincias = $pdo->query("SELECT id, descripcion FROM provincias")->fetchAll(PDO::FETCH_ASSOC);

// Obtener datos de la dirección actual
$sql = "SELECT * FROM direcciones WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$direccion_actual = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$direccion_actual) {
    header('Location: listar.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Dirección</title>
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
    <h1>Editar Dirección</h1>
    <form method="POST">
        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $direccion_actual['direccion']; ?>" required>

        <label>Localidad:</label>
        <select name="localidad_id" required>
            <option value="">Seleccione una localidad</option>
            <?php foreach ($localidades as $localidad): ?>
                <option value="<?php echo $localidad['id']; ?>" <?php if ($localidad['id'] == $direccion_actual['localidad_id']) echo 'selected'; ?>><?php echo $localidad['descripcion']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Provincia:</label>
        <select name="provincia_id" required>
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?php echo $provincia['id']; ?>" <?php if ($provincia['id'] == $direccion_actual['provincia_id']) echo 'selected'; ?>><?php echo $provincia['descripcion']; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Actualizar</button>
    </form>
    <a href="listar.php">Volver a la lista de direcciones</a>
</body>
</html>
