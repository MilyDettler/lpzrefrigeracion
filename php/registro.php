<?php
// Iniciar la sesión
session_start();

// Incluir el archivo para conectar a la base de datos
require('conexion.php'); // Asegúrate de que la ruta es correcta

if (isset($_POST['registro'])) {
    // Obtener los datos del formulario y aplicar la función de escape con la variable $conexion
    $nombre_user = mysqli_real_escape_string($conexion, $_POST['nombre_user']);
    $correo_user = mysqli_real_escape_string($conexion, $_POST['correo_user']);
    $contraseña_user = mysqli_real_escape_string($conexion, $_POST['contraseña_user']);
    $confirmar_contraseña_user = mysqli_real_escape_string($conexion, $_POST['confirmar_contraseña_user']);

    // Verificar si las contraseñas coinciden
    if ($contraseña_user != $confirmar_contraseña_user) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href = '../registro.html';</script>";
        exit();
    }

    // Verificar si el nombre de usuario ya existe
    $query = "SELECT * FROM usuarios WHERE nombre_user = '$nombre_user'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('El nombre de usuario ya está registrado.'); window.location.href = '../registro.html';</script>";
        exit();
    }

    // Verificar si el correo electrónico ya está registrado
    $query = "SELECT * FROM usuarios WHERE correo_user = '$correo_user'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('El correo electrónico ya está registrado.'); window.location.href = '../registro.html';</script>";
        exit();
    }

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña_user, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre_user, correo_user, contraseña_user) VALUES ('$nombre_user', '$correo_user', '$contraseña_hash')";

    if (mysqli_query($conexion, $query)) {
        echo "<script>alert('Registro exitoso. Puedes iniciar sesión ahora.'); window.location.href = '../login.html';</script>";
    } else {
        echo "<script>alert('Error en el registro. Inténtalo de nuevo.'); window.location.href = '../registro.html';</script>";
    }
} else {
    // Si no se ha enviado el formulario, redirigir a la página de registro
    header("Location: ../registro.html");
    exit();
}
?>
