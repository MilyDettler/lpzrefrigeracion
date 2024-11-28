<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];
    $estado = isset($_POST['estado']) ? 1 : 0;
    $provincia_id = $_POST['provincia_id'];

    $sql = "INSERT INTO localidades (descripcion, estado, provincia_id) VALUES (:descripcion, :estado, :provincia_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['descripcion' => $descripcion, 'estado' => $estado, 'provincia_id' => $provincia_id]);

    header("Location: listar.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM provincias");
$provincias = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Localidad</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Agregar Localidad</h1>
    <form method="POST">
        <label>Localidad:</label>
        <input type="text" name="descripcion" required>

        <label>Estado:</label>
        <input type="checkbox" name="estado" value="1"> Activo

        <label>Provincia:</label>
        <select name="provincia_id" required>
            <option value="">Seleccionar provincia</option>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?= $provincia['id'] ?>"><?= $provincia['descripcion'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar</button>
        <a href="listar.php" class="btn">Volver a la Lista</a>
    </form>
</body>
</html>
