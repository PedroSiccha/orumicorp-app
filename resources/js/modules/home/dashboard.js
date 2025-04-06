// resources/js/modules/home/dashboard.js
import updateClock from '@/helpers/updateClock';
import registerAssitance from '@/modules/partTime/registerAssitance';
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
  const canvas = document.getElementById('lineChart');
  if (!ventasRoute || !canvas) return;

  fetch(ventasRoute)
    .then(res => res.json())
    .then(data => {
      const ctx = canvas.getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: data.datasets,
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
      // 🔥 Ocultar shimmer después de cargar
      const shimmerChart = document.getElementById('shimmer-line-chart');
      if (shimmerChart) shimmerChart.remove();
    })
    .catch(err => console.error('Error cargando gráfico:', err));
}


// Inicialización
document.addEventListener('DOMContentLoaded', () => {
  updateClock();

  cargarGraficoVentas(); // ✅ Llamamos ahora correctamente

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

  setTimeout(() => {
    const shimmerRanking = document.getElementById('shimmer-ranking');
    const rankingReal = document.getElementById('ranking-real');

    if (shimmerRanking) shimmerRanking.remove();
    if (rankingReal) rankingReal.classList.remove('d-none');
  }, 500);
});

