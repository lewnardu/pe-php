$(document).ready(function() {
    $('#cpf').mask('000.000.000-00', {
        reverse: true
    });
});

function maiuscula(z) {
    v = z.value.toUpperCase();
    z.value = v;
}