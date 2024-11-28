// Función para validar el campo de fecha
function validarFecha() {
    const date = document.getElementById('date').value;
    if (!date) {
        alert('Por favor, seleccione una fecha.');
        return false;
    }
    return true;
}

// Función para validar campos de texto obligatorios
function validarCamposObligatorios() {
    const campos = ['servicio', 'razonSocial', 'solicitante', 'locacion', 'direccion', 'telefono', 'inconveniente', 'tareas'];
    for (let i = 0; i < campos.length; i++) {
        const campo = document.getElementById(campos[i]).value;
        if (!campo) {
            alert('Por favor, complete el campo ' + campos[i]);
            return false;
        }
    }
    return true;
}

// Función para validar el campo de número (horas, kilómetros y operarios)
function validarCamposNumericos() {
    const kilometros = document.getElementById('kilometros').value;
    const horaTotal = document.getElementById('horaTotal').value;
    const operarios = document.getElementById('operarios').value;

    if (!kilometros || kilometros <= 0) {
        alert('Por favor, ingrese una cantidad válida de kilómetros.');
        return false;
    }

    if (!horaTotal || horaTotal <= 0) {
        alert('Por favor, ingrese una cantidad válida de horas.');
        return false;
    }

    if (!operarios || operarios <= 0) {
        alert('Por favor, ingrese la cantidad de operarios.');
        return false;
    }

    return true;
}

// Función para validar las horas de entrada y salida
function validarHoras() {
    const horaEntrada = document.getElementById('horaEntrada').value;
    const horaSalida = document.getElementById('horaSalida').value;

    if (!horaEntrada) {
        alert('Por favor, ingrese la hora de entrada.');
        return false;
    }

    if (!horaSalida) {
        alert('Por favor, ingrese la hora de salida.');
        return false;
    }

    if (horaSalida <= horaEntrada) {
        alert('La hora de salida debe ser posterior a la hora de entrada.');
        return false;
    }

    return true;
}

// Función para validar las observaciones y estado del servicio
function validarObservacionesEstado() {
    const observaciones = document.getElementById('observaciones').value;
    const estadoResuelto = document.getElementById('resuelto').checked;
    const estadoPendiente = document.getElementById('pendiente').checked;
    const estadoPresupuestar = document.getElementById('presupuestar').checked;

    if (!observaciones) {
        alert('Por favor, ingrese alguna observación.');
        return false;
    }

    if (!estadoResuelto && !estadoPendiente && !estadoPresupuestar) {
        alert('Por favor, seleccione el estado del servicio.');
        return false;
    }

    return true;
}

// Función principal para validar el formulario
function validarFormulario(event) {
    event.preventDefault(); // Prevenir el envío del formulario hasta que se validen los campos

    if (validarFecha() &&
        validarCamposObligatorios() &&
        validarCamposNumericos() &&
        validarHoras() &&
        validarObservacionesEstado()) {
        // Si todas las validaciones son correctas, se envía el formulario
        alert('Formulario enviado correctamente');
        document.forms[0].submit();
    }
}

// Asignar el evento de validación al botón de enviar
document.querySelector('form').addEventListener('submit', validarFormulario);

document.getElementById('printOrdersBtn').onclick = function() {
    // Hacer una solicitud al servidor para obtener las órdenes
    fetch('get_orders.php')
        .then(response => response.text())
        .then(data => {
            // Insertar las órdenes en el contenedor
            document.getElementById('orderContainer').innerHTML = data;
            
            // Crear una nueva ventana para imprimir
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Órdenes</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(data);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        })
        .catch(error => console.error('Error al obtener las órdenes:', error));
};

