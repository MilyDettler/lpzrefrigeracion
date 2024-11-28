<?php
// Iniciar la sesión
session_start();

// Incluir el archivo para conectar a la base de datos
require('DataBase.php');

// Verificar si el formulario ha sido enviado
if (isset($_POST['login'])) {
    // Obtener los datos del formulario y aplicar la función de escape con la variable $conexion
    $nombre_user = mysqli_real_escape_string($conexion, $_POST['nombre_user']);
    $contraseña_user = mysqli_real_escape_string($conexion, $_POST['contraseña_user']);

    // Verificar si el usuario existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE nombre_user = '$nombre_user'";
    $result = mysqli_query($conexion, $query);

    // Si el usuario existe
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verificar la contraseña usando password_verify
        if (password_verify($contraseña_user, $row['contraseña_user'])) {
            // Crear variables de sesión
            $_SESSION['nombre_user'] = $row['nombre_user'];
            $_SESSION['id_user'] = $row['id'];

            // Redirigir al usuario a la página del formulario
            header("Location: ../formulario/formularios.php");
            exit(); // Terminar el script después de la redirección
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta.'); window.location.href = '../login.html';</script>";
            exit(); // Asegurar que no se ejecute más código
        }
    } else {
        // El nombre de usuario no existe
        echo "<script>alert('El usuario no existe.'); window.location.href = '../login.html';</script>";
        exit(); // Terminar el script
    }
} else {
    // Si no se ha enviado el formulario, redirigir a la página de login
    header("Location: ../login.html");
    exit(); // Terminar el script
}
?>