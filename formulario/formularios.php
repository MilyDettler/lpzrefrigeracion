<?php
// Conexión a la base de datos
include_once '../php/conexion.php'; // Asegúrate de que 'conexion.php' contiene la conexión a la base de datos

// Consulta para obtener las tiendas
$query_tienda = "SELECT id, numero_tienda FROM tienda WHERE estado = 1"; // Cambia 'activo' a lo que sea relevante
$tienda = $pdo->query($query_tienda)->fetchAll(PDO::FETCH_ASSOC);


// Consulta para obtener los tickets
$query_tickets = "SELECT id, numero_ticket FROM tickets";
$tickets = $pdo->query($query_tickets)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las direcciones
$query_direccion = "SELECT id, direccion FROM direcciones";
$direcciones = $pdo->query($query_direccion)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las provincias
$query_provincias = "SELECT id, descripcion FROM provincias WHERE estado = 1";
$provincias = $pdo->query($query_provincias)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las localidades
$query_localidades = "SELECT id, descripcion FROM localidades WHERE estado = 1"; // Cambia 'estado = 1' si es necesario
$localidades = $pdo->query($query_localidades)->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las ordenes
$query_ordenes = "SELECT * FROM ordenes"; // Ajusta los campos según sea necesario
$ordenes = $pdo->query($query_ordenes)->fetchAll(PDO::FETCH_ASSOC);

$locacion = $_POST['locacion'] ?? null;
$ticket = $_POST['ticket'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$provincia = $_POST['provincia'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo</title>
    <link href="estilos/style.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="Validaciones/app.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script src="Validaciones/agregar.js" type="text/javascript"></script>
    <script>
        window.onload = function() {
                 generarNumeroOrden();
                 const canvas = document.getElementById('firmaTiendaCanvas');
                 signaturePad = new SignaturePad(canvas);
        };

        function generarNumeroOrden() {
            const numeroOrden = 'ORD-' + Math.floor(Math.random() * 1000000);
            document.getElementById('numeroOrden').value = numeroOrden;
        }
        function saveSignature() {
            var canvas = document.getElementById('firmaTiendaCanvas');
            var dataURL = canvas.toDataURL('image/png');
            document.getElementById('firmaTienda').value = dataURL; // Guardar imagen en base64 en input oculto
            alert('Firma guardada exitosamente.');
        }
    </script>
</head>
<body>
    <div class="container">
        <header>  
            <h5 class="my-3">ORDEN DE TRABAJO</h5>
            <form method="post" action="Formulario.php" action='../generar_pdf.php' onsubmit="return verificarNumeroOrden()">
                <label for="numeroOrden">Número de Orden</label>
                <input type="text" id="numeroOrden" name="numeroOrden" readonly="">
            </form>
        </header>
        <div class="contenedor_formulario">
            <form method="post" action="Formulario.php" action="Validaciones/app.js" enctype="multipart/form-data" id="form">
                <input type="hidden" name="accion" value="submit"/>
                <div class="mb-3">
                    <label for="date">Seleccione una fecha</label>
                    <input type="date" class="form-control" name="date" id="date">
                </div>

                <div class="mb-3">
                    <label for="servicioSolicitado">Servicio Solicitado</label>
                    <input type="text" class="form-control" name="servicioSolicitado" id="servicioSolicitado" placeholder="Servicio Solicitado">
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="razonSocial">Razón Social</label>
                        <input type="text" class="form-control" name="razonSocial" id="razonSocial" placeholder="Razón Social">
                    </div>
                    <div class="col">
                        <label for="solicitante">Solicitante</label>
                        <input type="text" class="form-control" name="solicitante" id="solicitante" placeholder="Solicitante">
                    </div>
                </div>

                <!-- Select de tiendas -->
                <div class="mb-3">
                    <label for="locacion">Nº de tienda</label>
                    <select id="locacion" name="locacion" class="form-select" required>
                        <?php foreach ($tienda as $tienda): ?>
                            <option value="<?= $tienda['numero_tienda'] ?>"><?= $tienda['numero_tienda'] ?></option>
                        <?php endforeach; ?>
                            
                    </select>
                    <a href="../ABM/Tienda/listar.php" class="btn btn-link">Agregar</a>
                </div>

                <!-- Select de tickets -->
                <div class="row mb-3">
                    <div class="mb-3">
                        <label for="ticket">Nº de Ticket</label>
                        <select id="ticket" name="ticket" class="form-select" required>
                                <?php foreach ($tickets as $ticket): ?>
                                <option value="<?= $ticket['numero_ticket'] ?>"><?= $ticket['numero_ticket'] ?></option>
                                <?php endforeach; ?>
                        </select>
                        <a href="../ABM/Ticket/listar.php" class="btn btn-link">Agregar</a>
                    </div>
                </div>

                <!-- Select de direcciones -->
                <div class="row mb-3">
                    <div class="mb-3">
                        <label for="direccion">Dirección</label>
                        <select id="direccion" name="direccion" class="form-select" required>
                            <?php foreach ($direcciones as $direccion): ?>
                                <option value="<?= $direccion['direccion'] ?>"><?= $direccion['direccion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a href="../ABM/Direccion/listar.php" class="btn btn-link">Agregar</a>
                    </div>
                </div>

                <!-- Select de provincias -->
                <div class="row mb-3">
                    <div class="mb-3">
                        <label for="provincia">Provincia</label>
                        <select id="provincia" name="provincia" class="form-select" required>
                            <?php foreach ($provincias as $provincia): ?>
                                <option value="<?= $provincia['descripcion'] ?>"><?= $provincia['descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a href="../ABM/Provincia/listar.php" class="btn btn-link">Agregar</a>
                    </div>
                </div>


                <!-- Select de localidades -->
            <div class="row mb-3">
                <div class="mb-3">
                    <label for="localidad">Localidad</label>
                    <select id="localidad" name="localidad" class="form-select" required>
                        <?php foreach ($localidades as $localidad): ?>
                            <option value="<?= $localidad['id'] ?>"><?= $localidad['descripcion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="../ABM/Localidad/listar.php" class="btn btn-link">Agregar</a>
                </div>
            </div>


                <!-- Otros campos del formulario -->
                <div class="mb-3">
                    <label for="inconveniente">Inconveniente Detectado</label>
                    <input type="text" class="form-control" name="inconveniente" id="inconveniente" placeholder="Inconveniente Detectado">
                </div>

                <div class="mb-3">
                    <label for="tareas">Tareas Desarrolladas</label>
                    <textarea id="tareas" name="tareas" rows="5" class="form-control" placeholder="Tareas desarrolladas"></textarea>
                </div>
                <div class="mb-3">
                    <label for="repuestos">Repuestos Utilizados</label>
                    <textarea id="repuestos" name="repuestos" rows="5" cols="40" placeholder="Repuestos Utilizados"></textarea>
                </div>

                <div class="mb-3">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="5" cols="40" placeholder="Observaciones"></textarea>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="resuelto" name="estado" class="custom-control-input" value="Resuelto">
                        <label class="custom-control-label" for="resuelto">Resuelto</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="pendiente" name="estado" class="custom-control-input" value="Pendiente">
                        <label class="custom-control-label" for="pendiente">Pendiente</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="presupuestar" name="estado" class="custom-control-input" value="A Presupuestar">
                        <label class="custom-control-label" for="presupuestar">A Presupuestar</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="horaEntrada">Hora de Entrada</label>
                    <input type="time" class="form-control" name="horaEntrada" id="horaEntrada">
                </div>
                <div class="mb-3">
                    <label for="horaSalida">Hora de Salida</label>
                    <input type="time" class="form-control" name="horaSalida" id="horaSalida">
                </div>

                <div class="mb-3">
                    <label for="horaTotal">Cantidad de Horas</label>
                    <input type="time" class="form-control" name="horaTotal" id="horaTotal">
                </div>
                <div class="mb-3">
                    <label for="kilometros">Cantidad de KM</label>
                    <input type="number" class="form-control" name="kilometros" id="kilometros">
                </div>
                <div class="mb-3">
                    <label for="operarios">Cantidad de Operarios</label>
                    <input type="number" class="form-control" name="operarios" id="operarios">
                </div>

                <!-- Firma del Técnico (input file) -->
                <div class="mb-3">
                    <label for="firmaTecnico">Firma Técnico</label>
                    <input type="file" name="firmaTecnico" accept="image/png" required>
                    <br>
                    <?php if (!empty($order['firmaTecnico'])): ?>
                        <img src="../formulario/firmasTecnico/<?= htmlspecialchars($order['firmaTecnico']) ?>" alt="Firma Técnico" style="border: 1px solid black; width: 200px; height: auto;">
                    <?php endif; ?>
                </div>

            <div class="mb-3">
                <p>
                    <b>Quien suscribe, en representación del cliente, recibe conforme el servicio prestado por 
                    <img src="imagen/LOPEZ logo.png" alt="logo" class="logo" />
                    </b>
                </p><br>
               <!-- Firma de la Tienda (canvas) -->
                <div class="mb-3">
                    <label for="firmaTienda">Firma Tienda</label><br>
                    <br><canvas id="firmaTiendaCanvas" width="400" height="200" style="border: 1px solid #000;"></canvas>
                    <br>
                    <button type="button" onclick="saveSignature()">Guardar Firma</button>
                    <input type="hidden" id="firmaTienda" name="firmaTienda" />
                </div>
                    <br>
                    <?php if (!empty($order['firmaTienda'])): ?>
                        <img src="../formulario/firmasTienda/<?= htmlspecialchars($order['firmaTienda']) ?>" alt="Firma Tienda" style="border: 1px solid black; width: 200px; height: auto;">
                    <?php endif; ?>
                </div>
                    <div class="mb-3">
                        <label for="legajo" class="legajo">Legajo Empleado Dia</label>
                        <input type="number" class="form-control" name="aclaracion" id="aclaracion" placeholder="Legajo">
                    </div>
                </div>
                <!-- Botón enviar -->
                <br>
                <button type="submit" class="btn btn-primary">Guardar Órden</button>
                <button id="printOrdersBtn" class="btn btn-success"><a href="../php/get_orders.php">Visualizar Órdenes</a></button>
                <div id="orderContainer"></div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
