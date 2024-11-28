let signaturePad;

window.addEventListener('load', () => {
    const canvas = document.querySelector("#firmaTiendaCanvas");
    signaturePad = new SignaturePad(canvas, {});

    const form = document.querySelector('form');
    const firmaTiendaInput = document.getElementById('firmaTiendaInput');

    form.addEventListener('submit', (event) => {
        if (signaturePad.isEmpty()) {
            event.preventDefault();
            alert("Por favor, firme en el cuadro antes de enviar.");
        } else {
            const dataURL = signaturePad.toDataURL('image/jpg');
            firmaTiendaInput.value = dataURL;
        }
    });
});
