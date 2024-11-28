<?php
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];
    $estado = isset($_POST['estado']) ? 1 : 0;

    $sql = "INSERT INTO provincias (descripcion, estado) VALUES (:descripcion, :estado)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['descripcion' => $descripcion, 'estado' => $estado]);

    header("Location: listar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Provincia</title>
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
        h1 {
            text-align: center;
            color: #333;
        }
        /* Estilos para el contenedor del formulario */
        form {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="checkbox"] {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h1>Agregar Provincia</h1>
        
        <div class="form-group">
            <label for="descripcion">Provincia:</label>
            <input type="text" name="descripcion" id="descripcion" required>
        </div>
        
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="checkbox" name="estado" id="estado" value="1" checked> Activo
        </div>
        
        <button type="submit">Agregar</button>
    </form>
</body>
</html>
