// Cargar encuestas
function loadEncuestas() {
  const container = document.getElementById("encuestasContainer")

  fetch("api/encuestas.php")
    .then((response) => response.json())
    .then((encuestas) => {
      if (encuestas.length === 0) {
        container.innerHTML = '<p class="loading">No hay encuestas disponibles</p>'
        return
      }

      container.innerHTML = encuestas
        .map(
          (encuesta) => `
                <div class="encuesta-card">
                    <h3>${encuesta.titulo}</h3>
                    <p>${encuesta.descripcion || "Participa en esta encuesta sobre el ODS 6"}</p>
                    <button class="btn-primary" onclick="alert('Funcionalidad de encuesta en desarrollo')">
                        Responder Encuesta
                    </button>
                </div>
            `,
        )
        .join("")
    })
    .catch((error) => {
      container.innerHTML = '<p class="loading">Error al cargar encuestas</p>'
      console.error("[v0] Error cargando encuestas:", error)
    })
}

document.addEventListener("DOMContentLoaded", () => {
  loadEncuestas()
})

