var fecha = new Date();

var fechaFormateada = ('0' + fecha.getDate()).slice(-2) + '/' + ('0' + (fecha.getMonth() + 1)).slice(-2) + '/' + fecha.getFullYear();

document.getElementById('fecha_actual').textContent = fechaFormateada;
