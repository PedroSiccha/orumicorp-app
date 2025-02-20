document.addEventListener("DOMContentLoaded", async function () {
    const canvas = document.getElementById("roulette");
    const ctx = canvas.getContext("2d");
    const spinButton = document.getElementById("spinButton");

    let prizes = [];

    // Obtener premios desde Laravel
    async function fetchPrizes() {
        const response = await fetch("/prizes");
        prizes = await response.json();
        drawRoulette();
    }

    function drawRoulette() {
        const totalPrizes = prizes.length;
        const anglePerPrize = (2 * Math.PI) / totalPrizes;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Dibujar cada sección de la ruleta
        prizes.forEach((prize, index) => {
            const startAngle = index * anglePerPrize;
            const endAngle = startAngle + anglePerPrize;

            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, 180, startAngle, endAngle);
            ctx.fillStyle = index % 2 === 0 ? "#007bff" : "#ffcc00"; // Alternar colores
            ctx.fill();
            ctx.strokeStyle = "#fff";
            ctx.lineWidth = 5;
            ctx.stroke();

            // Dibujar el texto del premio
            ctx.save();
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.rotate(startAngle + anglePerPrize / 2);
            ctx.fillStyle = "#fff";
            ctx.font = "bold 16px Arial";
            ctx.fillText(prize.name, 90, 10);
            ctx.restore();
        });

        // Dibujar el borde dorado
        ctx.beginPath();
        ctx.arc(canvas.width / 2, canvas.height / 2, 190, 0, 2 * Math.PI);
        ctx.strokeStyle = "#FFD700";
        ctx.lineWidth = 8;
        ctx.stroke();
    }

    async function spinRoulette() {
        const totalPrizes = prizes.length;
        const anglePerPrize = 360 / totalPrizes; // Ángulo por premio
    
        // Seleccionar premio ganador de forma aleatoria
        const selectedPrizeIndex = Math.floor(Math.random() * totalPrizes);
        const selectedPrize = prizes[selectedPrizeIndex];
        const prizeId = selectedPrize.id;
    
        // Calcular el ángulo exacto del premio seleccionado
        const finalAngle = (270 - (selectedPrizeIndex * anglePerPrize)) % 270;
    
        // Ajustar el ángulo para que el premio caiga exactamente en la parte superior
        const offsetAngle = anglePerPrize / 2; // Corrige el centro de la sección
        const correctedAngle = finalAngle - offsetAngle;

         // Resetear la rotación antes de cada giro (IMPORTANTE)
        canvas.style.transition = "none";
        canvas.style.transform = "rotate(0deg)";
    
        // Asegurar que el reset se aplique antes de la nueva animación
        setTimeout(() => {

            // Agregar varias vueltas antes de detenerse
            const totalRotation = correctedAngle + (360 * 5); // 5 vueltas completas
        
            // Aplicar la rotación con animación
            canvas.style.transition = "transform 3s ease-out";
            canvas.style.transform = `rotate(${totalRotation}deg)`;

            setTimeout(async () => {
                // Guardar el premio en Laravel
                await fetch("/prizes/winner", {
                    method: "POST",
                    headers: { 
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") 
                    },
                    credentials: "same-origin", // Asegura que se envíen cookies y sesión
                    body: JSON.stringify({ prize_id: prizeId })
                });
    
                // Cerrar el modal de la ruleta
                $('#myModal5').modal('hide'); // Bootstrap jQuery

                // Pequeño retraso para esperar a que el modal se cierre antes de mostrar la animación
                setTimeout(() => {
                    // Actualizar el mensaje con el premio ganado
                    document.getElementById("winner-message").innerText = `🎉 ¡Ganaste ${selectedPrize.name}! 🎉`;

                    // Mostrar la animación de celebración
                    document.getElementById("celebration").style.display = "flex";
                }, 500); // Esperar 500ms para que el modal se cierre antes de mostrar la animación

            }, 3000);
        }, 50); // Pequeño delay para asegurar el reset
    }
    
    

    spinButton.addEventListener("click", spinRoulette);
    await fetchPrizes();
});

function closeCelebration() {
    let celebration = document.getElementById("celebration");

    // Asegurar que el elemento existe antes de modificarlo
    if (celebration) {
        celebration.style.display = "none";
    }
}

