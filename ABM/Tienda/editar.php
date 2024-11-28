<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tienda = $_POST['tienda'];
    $localidad_id = $_POST['localidad_id'];
    $provincia_id = $_POST['provincia_id'];

    $sql = "UPDATE tienda SET numero_tienda = :numero_tienda, localidad_id = :localidad_id, provincia_id = :provincia_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'numero_tienda' => $tienda,
        'localidad_id' => $localidad_id,
        'provincia_id' => $provincia_id,
        'id' => $id
    ]);

    header('Location: listar.php');
    exit;
}

// Obtener la tienda a editar
$id = $_GET['id'];
$tienda = $pdo->prepare("SELECT * FROM tienda WHERE id = :id");
$tienda->execute(['id' => $id]);
$tienda = $tienda->fetch(PDO::FETCH_ASSOC);

// Consultas para obtener localidades y provincias
$localidades = $pdo->query("SELECT id, descripcion FROM localidades")->fetchAll(PDO::FETCH_ASSOC);
$provincias = $pdo->query("SELECT id, descripcion FROM provincias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tienda</title>
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
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
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
    <h1>Editar Tienda</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $tienda['id']; ?>">

        <label>Número de Tienda:</label>
        <input type="number" name="tienda" value="<?php echo $tienda['numero_tienda']; ?>" required>

        <label>Localidad:</label>
        <select name="localidad_id" required>
            <option value="">Seleccione una localidad</option>
            <?php foreach ($localidades as $localidad): ?>
                <option value="<?php echo $localidad['id']; ?>" <?php echo ($localidad['id'] == $tienda['localidad_id']) ? 'selected' : ''; ?>>
                    <?php echo $localidad['descripcion']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Provincia:</label>
        <select name="provincia_id" required>
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?php echo $provincia['id']; ?>" <?php echo ($provincia['id'] == $tienda['provincia_id']) ? 'selected' : ''; ?>>
                    <?php echo $provincia['descripcion']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="listar.php">Volver a la lista de tiendas</a>
</body>
</html>
