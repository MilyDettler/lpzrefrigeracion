// Función para agregar la nueva dirección
function agregarDireccion() {
    var nuevaDireccion = document.getElementById('nuevaDireccion').value;
    
    if (nuevaDireccion.trim() !== "") {
        alert('Dirección agregada: ' + nuevaDireccion);
        // Aquí puedes agregar lógica adicional para almacenar la nueva dirección si es necesario
    } else {
        alert('Por favor, ingresa una dirección válida.');
    }
}
function agregarTienda() {
    var nuevaTienda = document.getElementById('nuevaTienda').value;
    if (nuevaTienda.trim() !== "") {
        alert('Tienda agregada: ' + nuevaTienda);
        // Aquí puedes agregar lógica adicional para almacenar la nueva dirección si es necesario
    } else {
        alert('Por favor, ingresa una tienda válida.');
    }
}
function agregarTicket() {
    var nuevoTicket = document.getElementById('nuevoTicket').value;
    if (nuevoTicket.trim() !== "") {
        alert('Ticket agregado: ' + nuevoTicket);
        // Aquí puedes agregar lógica adicional para almacenar la nueva dirección si es necesario
    } else {
        alert('Por favor, ingresa un ticket válido.');
    }
}
function agregarProvincia() {
    var nuevaProvincia = document.getElementById('nuevaProvincia').value;
    if (nuevaProvincia.trim() !== "") {
        alert('Provincia agregada: ' + nuevaProvincia);
        // Aquí puedes agregar lógica adicional para almacenar la nueva dirección si es necesario
    } else {
        alert('Por favor, ingresa una Provincia válida.');
    }
}
function agregarLocalidad() {
    var nuevaLocalidad = document.getElementById('nuevaLocalidad').value;
    if (nuevaLocalidad.trim() !== "") {
        alert('Localidad agregada: ' + nuevaLocalidad);
        // Aquí puedes agregar lógica adicional para almacenar la nueva dirección si es necesario
    } else {
        alert('Por favor, ingresa una Localidad válida.');
    }
}
