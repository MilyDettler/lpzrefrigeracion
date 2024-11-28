<?php
include '../../php/conexion.php';

// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = $_GET['id'];

// Obtener los datos de la provincia a editar
$query = "SELECT * FROM provincias WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$provincia = $stmt->fetch();

if (!$provincia) {
    echo "Provincia no encontrada.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = trim($_POST['descripcion']);
    $estado = isset($_POST['estado']) ? 1 : 0;

    // Validación básica
    if (empty($descripcion)) {
        $error = "La descripción es obligatoria.";
    } else {
        // Actualizar la provincia en la base de datos
        $sql = "UPDATE provincias SET descripcion = :descripcion, estado = :estado WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'descripcion' => $descripcion,
            'estado' => $estado,
            'id' => $id
        ]);

        header("Location: listar.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Provincia</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Contenedor del formulario */
        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        /* Título del formulario */
        .form-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        /* Grupos de formulario */
        .form-group {
            margin-bottom: 20px;
        }

        /* Etiquetas */
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        /* Campos de entrada */
        .form-group input[type="text"],
        .form-group input[type="checkbox"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Checkbox específico */
        .form-group .checkbox-container {
            display: flex;
            align-items: center;
        }

        .form-group .checkbox-container input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        /* Botón de envío */
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Enlace para volver a la lista */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Mensaje de error */
        .error {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Editar Provincia</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" value="<?= htmlspecialchars($provincia['descripcion']) ?>" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <div class="checkbox-container">
                    <input type="checkbox" name="estado" id="estado" value="1" <?= $provincia['estado'] ? 'checked' : '' ?>>
                    <label for="estado">Activo</label>
                </div>
            </div>

            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="listar.php" class="back-link">Volver a la lista de provincias</a>
    </div>
</body>
</html>
