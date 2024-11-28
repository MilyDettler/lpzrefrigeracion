<?php
// Incluir el archivo de conexión
require('../php/conexion.php');

// Comprobar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $fecha = $_POST['date'];
    $servicioSolicitado = $_POST['servicioSolicitado'];
    $razonSocial = $_POST['razonSocial'];
    $solicitante = $_POST['solicitante'];
    $locacion = $_POST['locacion'];
    $ticket = $_POST['ticket'];
    $direccion = $_POST['direccion'];
    $provincia = $_POST['provincia'];
    $localidad = $_POST['localidad'];
    $inconveniente = $_POST['inconveniente'];
    $tareas = $_POST['tareas'];
    $repuestos = $_POST['repuestos'];
    $observaciones = $_POST['observaciones'];
    $estado = $_POST['estado'];
    $horaEntrada = $_POST['horaEntrada'];
    $horaSalida = $_POST['horaSalida'];
    $horaTotal = $_POST['horaTotal'];
    $kilometros = $_POST['kilometros'];
    $operarios = $_POST['operarios'];
    $legajo = $_POST['aclaracion'];

    // Directorios donde se guardarán las firmas
    $directorioFirmasTienda = '../formulario/firmas/firmaTienda/';
    $directorioFirmasTecnico = '../formulario/firmas/firmaTecnico/';
    $firmaTiendaRuta = null;
    $firmaTecnicoRuta = null;

    // Crear directorios si no existen
    if (!is_dir($directorioFirmasTienda)) {
        mkdir($directorioFirmasTienda, 0777, true);
    }
    if (!is_dir($directorioFirmasTecnico)) {
        mkdir($directorioFirmasTecnico, 0777, true);
    }

    // Guardar la firma de la tienda
    if (isset($_POST['firmaTienda']) && !empty($_POST['firmaTienda'])) {
        $dataFirmaTienda = $_POST['firmaTienda'];
        $dataFirmaTienda = str_replace('data:image/png;base64,', '', $dataFirmaTienda);
        $dataFirmaTienda = str_replace(' ', '+', $dataFirmaTienda);
        $dataFirmaTiendaDecoded = base64_decode($dataFirmaTienda);

        if ($dataFirmaTiendaDecoded !== false) {
            $nombreFirmaTienda = 'firma_tienda_' . time() . '.png';
            $firmaTiendaRuta = $directorioFirmasTienda . $nombreFirmaTienda;
            file_put_contents($firmaTiendaRuta, $dataFirmaTiendaDecoded);
        } else {
            echo "Error: La firma de la tienda no se pudo decodificar.";
        }
    }

    // Guardar la firma del técnico
    if (isset($_FILES['firmaTecnico']) && $_FILES['firmaTecnico']['error'] === UPLOAD_ERR_OK) {
        $nombreFirmaTecnico = 'firma_tecnico_' . time() . '.png';
        $firmaTecnicoRuta = $directorioFirmasTecnico . $nombreFirmaTecnico;

        // Mover el archivo subido a la carpeta correspondiente
        if (move_uploaded_file($_FILES['firmaTecnico']['tmp_name'], $firmaTecnicoRuta)) {
            // Archivo subido correctamente
        } else {
            echo "Error: No se pudo subir la firma del técnico.";
        }
    } else {
        echo "Error: No se ha seleccionado una firma de técnico o hay un problema con la carga.";
    }

    // Preparar e insertar los datos en la base de datos con mysqli
    $sql = "INSERT INTO ordenes (
                date, servicioSolicitado, razonSocial, solicitante, locacion, ticket, 
                direccion, provincia, localidad, inconveniente, tareas, repuestos, 
                observaciones, estado, horaEntrada, horaSalida, horaTotal, kilometros, 
                operarios, firmaTienda, firmaTecnico, legajo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Enlazar parámetros (22 tipos 's' para 22 columnas)
    $stmt->bind_param(
        'ssssssssssssssssssssss', // Ahora hay 22 's' para las 22 columnas
        $fecha,
        $servicioSolicitado,
        $razonSocial,
        $solicitante,
        $locacion,
        $ticket,
        $direccion,
        $provincia,
        $localidad,
        $inconveniente,
        $tareas,
        $repuestos,
        $observaciones,
        $estado,
        $horaEntrada,
        $horaSalida,
        $horaTotal,
        $kilometros,
        $operarios,
        $firmaTiendaRuta,
        $firmaTecnicoRuta,
        $legajo
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Orden de trabajo registrada exitosamente.'); window.location.href = 'formularios.php';</script>";
    } else {
        echo "Error: No se pudo registrar la orden de trabajo.";
    }

    $stmt->close();
    $conexion->close();
}
?>
