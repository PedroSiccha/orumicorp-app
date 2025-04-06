// resources/js/modules/home/dashboard.js
import updateClock from '@/helpers/updateClock';
import registerAssitance from '@/partTime/registerAssitance';
import mostrarNuevoModal from '@/helpers/mostrarNuevoModal';
import { mostrarMensaje } from '@/helpers/mostrarMensaje';
import Chart from 'chart.js/auto';

// Variables globales definidas en Blade
const registerAssitanceRoute = window.registerAssitanceRoute;
const ventasRoute = window.ventasDataRoute;
const token = window.token;
const dateIn = window.dateIn;

// Mostrar modal de asistencia si no marcó
if (!dateIn) {
  document.addEventListener('DOMContentLoaded', () => {
    mostrarNuevoModal('#myModal');
  });
}

// Cargar gráfico de ventas
function cargarGraficoVentas() {
  fetch(ventasRoute)
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('lineChart')?.getContext('2d');
      if (!ctx) return;

      const chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
          ],
          datasets: data.datasets,
        },
        options: {
          responsive: true,
        },
      });

      updateClock(); // Reloj en el modal
    })
    .catch(error => {
      console.error('Error al cargar gráfico de ventas:', error);
      mostrarMensaje({ tipo: 'error', mensaje: 'No se pudo cargar el gráfico' });
    });
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
  cargarGraficoVentas();

  // Botón de asistencia
  const btnMarcar = document.getElementById('btnMarcarAsistencia');
  if (btnMarcar) {
    btnMarcar.addEventListener('click', () => {
      registerAssitance(
        btnMarcar.dataset.fecha,
        '#comentario',
        'IN',
        '#panelButton',
        '#tabAssistance',
        '#myModal'
      );
    });
  }

  // Simular carga (puedes usar delay de 500ms si lo deseas)
  setTimeout(() => {
    const shimmerRanking = document.getElementById('shimmer-ranking');
    const rankingReal = document.getElementById('ranking-real');

    if (shimmerRanking) shimmerRanking.remove();
    if (rankingReal) rankingReal.classList.remove('d-none');
  }, 500); // tiempo estimado de carga visual


});
