<?php
// Conexión a la base de datos
require('conexion.php');  // Asegúrate de que 'conexion.php' esté correctamente configurado

try {
    // Consultar todas las órdenes disponibles
    $stmt = $pdo->query('SELECT id, date FROM ordenes');
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($orders) > 0) {
        echo '<form action="" method="GET" style="margin-bottom: 20px;">';
        echo '<label for="orden">Selecciona una orden para visualizar:</label>';
        echo '<select id="orden" name="orden" required>';
        echo '<option value="">Seleccione una orden</option>';

        // Rellenar el select con las órdenes
        foreach ($orders as $order) {
            echo '<option value="' . htmlspecialchars($order['id']) . '">' . htmlspecialchars($order['id']) . ' - ' . htmlspecialchars($order['date']) . '</option>';
        }

        echo '</select>';
        echo '<button type="submit">Visualizar Orden</button>';
        echo '</form>';

        // Verificar si una orden ha sido seleccionada
        if (isset($_GET['orden'])) {
            $selectedOrderId = $_GET['orden'];

            // Consultar los detalles de la orden seleccionada
            $stmt = $pdo->prepare('
                SELECT o.*, l.descripcion AS localidad_descripcion
                FROM ordenes o
                LEFT JOIN localidades l ON o.localidad = l.id
                WHERE o.id = :id
            ');
            $stmt->execute(['id' => $selectedOrderId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                ?>

                <form action="procesar_orden.php" method="POST" style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; background-color: #f9f9f9; border-radius: 10px;">
                    <style>
                        label { font-weight: bold; margin-bottom: 5px; display: block; }
                        input, textarea { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
                        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
                        button:hover { background-color: #45a049; }
                    </style>

                    <label for="Ordenes">Ordenes Laborales</label>
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($order['id']); ?>" readonly>

                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($order['date']); ?>">

                    <label for="servicioSolicitado">Servicio:</label>
                    <input type="text" id="servicioSolicitado" name="servicioSolicitado" value="<?php echo htmlspecialchars($order['servicioSolicitado']); ?>">

                    <label for="razonSocial">Razón Social:</label>
                    <input type="text" id="razonSocial" name="razonSocial" value="<?php echo htmlspecialchars($order['razonSocial']); ?>">

                    <label for="solicitante">Solicitante:</label>
                    <input type="text" id="solicitante" name="solicitante" value="<?php echo htmlspecialchars($order['solicitante']); ?>">

                    <label for="locacion">Tienda:</label>
                    <input type="text" id="locacion" name="locacion" value="<?php echo htmlspecialchars($order['locacion']); ?>">
                    
                    <label for="ticket">Ticket:</label>
                    <input type="number" id="ticket" name="ticket" value="<?php echo htmlspecialchars($order['ticket']); ?>">
                    
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($order['direccion']); ?>">

                    <label for="provincia">Provincia:</label>
                    <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($order['provincia']); ?>">

                    <label for="localidad">Localidad:</label>
                    <input type="text" id="localidad" name="localidad" value="<?php echo htmlspecialchars($order['localidad_descripcion']); ?>" readonly> <!-- Mostrar la descripción de la localidad -->

                    <label for="inconveniente">Inconveniente:</label>
                    <textarea id="inconveniente" name="inconveniente"><?php echo htmlspecialchars($order['inconveniente']); ?></textarea>

                    <label for="tareas">Tareas:</label>
                    <textarea id="tareas" name="tareas"><?php echo htmlspecialchars($order['tareas']); ?></textarea>

                    <label for="repuestos">Repuestos:</label>
                    <textarea id="repuestos" name="repuestos"><?php echo htmlspecialchars($order['repuestos']); ?></textarea>

                    <label for="observaciones">Observaciones:</label>
                    <textarea id="observaciones" name="observaciones"><?php echo htmlspecialchars($order['observaciones']); ?></textarea>

                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($order['estado']); ?>">

                    <label for="horaEntrada">Hora Entrada:</label>
                    <input type="time" id="horaEntrada" name="horaEntrada" value="<?php echo htmlspecialchars($order['horaEntrada']); ?>">

                    <label for="horaSalida">Hora Salida:</label>
                    <input type="time" id="horaSalida" name="horaSalida" value="<?php echo htmlspecialchars($order['horaSalida']); ?>">

                    <label for="horaTotal">Cantidad de Horas:</label>
                    <input type="text" id="horaTotal" name="horaTotal" value="<?php echo htmlspecialchars($order['horaTotal']); ?>">

                    <label for="kilometros">Cantidad de Kilómetros:</label>
                    <input type="text" id="kilometros" name="kilometros" value="<?php echo htmlspecialchars($order['kilometros']); ?>">

                    <label for="operarios">Cantidad de Operarios:</label>
                    <input type="text" id="operarios" name="operarios" value="<?php echo htmlspecialchars($order['operarios']); ?>">

                    <!-- Mostrar el logo -->
                    <div style="margin-top: 20px;">
                        <p style="display: inline-block; font-weight: bold;">
                            Quien suscribe, en representación del cliente, recibe conforme el servicio prestado por 
                            <img src="../formulario/imagen/LOPEZ logo.svg" alt="logo" class="logo" style="width: 100px; height: auto; vertical-align: middle;"/>
                        </p>
                    </div>

                    <!-- Firma Técnico -->
                    <label for="firmaTecnico">Firma del Técnico:</label>
                    <img src="<?php echo !empty($order['firmaTecnico']) ? $order['firmaTecnico'] : 'ruta/a/imagen_no_disponible_tecnico.jpg'; ?>" alt="Firma Técnico" style="width: 200px; height: auto;" />

                    <!-- Firma Tienda -->
                    <label for="firmaTienda">Firma de la Tienda:</label>
                    <img src="<?php echo !empty($order['firmaTienda']) ? $order['firmaTienda'] : 'ruta/a/imagen_no_disponible_tienda.jpg'; ?>" alt="Firma Tienda" style="width: 200px; height: auto;" />

                    <label for="legajo">Legajo Empleado Dia:</label>
                    <input type="text" id="legajo" name="legajo" value="<?php echo htmlspecialchars($order['legajo']); ?>">

                    <!-- Botones -->
                    <form method="post" action="descargar_orden.php">
                        <input type="hidden" name="orden" value="<?php echo htmlspecialchars($order['id']); ?>">
                        <button type="submit">Descargar Orden</button>
                    </form>


                    <button><a href="../formulario/formularios.php">Volver al Formulario</a></button><br><br>
                </form>

                <?php
            } else {
                echo '<p>Orden no encontrada.</p>';
            }
        }
    } else {
        echo '<p>No hay órdenes registradas.</p>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
