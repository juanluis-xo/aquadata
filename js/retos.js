// Cargar retos
function loadRetos() {
  const container = document.getElementById("retosContainer")

  fetch("api/retos.php")
    .then((response) => response.json())
    .then((retos) => {
      if (retos.length === 0) {
        container.innerHTML = '<p class="loading">No hay retos disponibles</p>'
        return
      }

      container.innerHTML = retos
        .map(
          (reto) => `
                <div class="reto-card">
                    <div class="reto-badge">${reto.mes} ${reto.anio}</div>
                    <h3>${reto.titulo}</h3>
                    <p>${reto.descripcion}</p>
                    <div class="reto-info">
                        <span>🏆 ${reto.puntos} puntos</span>
                        <span>📅 ${formatDate(reto.fecha_inicio)} - ${formatDate(reto.fecha_fin)}</span>
                    </div>
                    <button class="btn-primary" onclick="alert('Funcionalidad de participación en desarrollo')">
                        Participar
                    </button>
                </div>
            `,
        )
        .join("")
    })
    .catch((error) => {
      container.innerHTML = '<p class="loading">Error al cargar retos</p>'
      console.error("[v0] Error cargando retos:", error)
    })
}

function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString("es-ES", {
    year: "numeric",
    month: "long",
    day: "numeric",
  })
}

document.addEventListener("DOMContentLoaded", () => {
  loadRetos()
})
