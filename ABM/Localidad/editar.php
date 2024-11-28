<?php
include '../../php/conexion.php';

$id = $_GET['id'];
$query = "SELECT * FROM localidades WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$localidad = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];
    $estado = isset($_POST['estado']) ? 1 : 0;
    $provincia_id = $_POST['provincia_id'];

    $sql = "UPDATE localidades SET descripcion = :descripcion, estado = :estado, provincia_id = :provincia_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['descripcion' => $descripcion, 'estado' => $estado, 'provincia_id' => $provincia_id, 'id' => $id]);

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
    <title>Editar Localidad</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Localidad</h1>
    <form method="POST">
        <label>Descripción:</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($localidad['descripcion']) ?>" required>

        <label>Estado:</label>
        <input type="checkbox" name="estado" value="1" <?= $localidad['estado'] ? 'checked' : '' ?>> Activo

        <label>Provincia:</label>
        <select name="provincia_id" required>
            <?php foreach ($provincias as $provincia): ?>
                <option value="<?= $provincia['id'] ?>" <?= $provincia['id'] == $localidad['provincia_id'] ? 'selected' : '' ?>>
                    <?= $provincia['descripcion'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
