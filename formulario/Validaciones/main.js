// Función para generar un número de orden aleatorio
function generarNumeroOrden() {
    const numeroOrden = 'ORD-' + Math.floor(Math.random() * 1000000);
    document.getElementById('numeroOrden').value = numeroOrden;
}

let signaturePadTienda = null;

window.addEventListener('load', async () => {
    // Inicializar SignaturePad para el canvas de la tienda
    const canvasTienda = document.getElementById('canvas-tienda');
    canvasTienda.height = canvasTienda.offsetHeight;
    canvasTienda.width = canvasTienda.offsetWidth;
    signaturePadTienda = new SignaturePad(canvasTienda, {});
});

// Función para asignar las firmas a los inputs ocultos antes de enviar el formulario
function guardarFirmas() {
    const firmaTiendaInput = document.getElementById('canvas-data-tienda');

    // Obtener las imágenes en base64 de los canvases y asignarlas a los inputs ocultos
    firmaTiendaInput.value = signaturePadTienda.toDataURL('image/png');

    return true; // Permitir que el formulario se envíe
}

// Llamar a guardarFirmas cuando se envíe el formulario
const formulario = document.getElementById('formulario'); // Cambia 'formulario' por el id correcto de tu formulario
formulario.addEventListener('submit', function (event) {
    if (!guardarFirmas()) {
        // Prevenir el envío del formulario si no se completan las firmas
        event.preventDefault();
    }
});


// Función para validar el formulario antes de enviar
function validarFormulario() {
    const servicio = document.getElementById('servicio').value;
    const razonSocial = document.getElementById('razonSocial').value;
    const solicitante = document.getElementById('solicitante').value;
    const locacion = document.getElementById('locacion').value;
    const direccion = document.getElementById('direccion').value;
    const telefono = document.getElementById('telefono').value;

    if (!servicio || !razonSocial || !solicitante || !locacion || !direccion || !telefono) {
        alert('Por favor, complete todos los campos requeridos.');
        return false; // Evita que el formulario se envíe si faltan campos
    }

    // Validación de fecha
    const date = document.getElementById('date').value;
    if (!date) {
        alert('Por favor, seleccione una fecha.');
        return false;
    }

    // Validación de horas y kilómetros
    const horaEntrada = document.getElementById('horaEntrada').value;
    const horaSalida = document.getElementById('horaSalida').value;
    const kilometros = document.getElementById('kilometros').value;
    const operarios = document.getElementById('operarios').value;

    if (!horaEntrada || !horaSalida || !kilometros || !operarios) {
        alert('Por favor, ingrese todos los detalles de tiempo y operarios.');
        return false;
    }

    // Si todo está correcto, el formulario se envía
    return true;
}

// Evento que se ejecuta cuando la página carga
window.onload = function() {
    generarNumeroOrden();

    // Asignar validación al botón de enviar
    const form = document.querySelector('form');
    form.onsubmit = validarFormulario;
};
