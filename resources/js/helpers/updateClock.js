// resources/js/helpers/updateClock.js
export default function updateClock() {
    const clock = document.getElementById('clock');
    if (!clock) return;
  
    const update = () => {
      const now = new Date();
  
      const hora = now.getHours().toString().padStart(2, '0');
      const minutos = now.getMinutes().toString().padStart(2, '0');
      const segundos = now.getSeconds().toString().padStart(2, '0');
  
      clock.textContent = `${hora}:${minutos}:${segundos}`;
    };
  
    update(); // Ejecutar inmediatamente
    return setInterval(update, 1000); // Actualizar cada segundo
  }
  