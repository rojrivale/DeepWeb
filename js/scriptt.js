// DeepWebb JavaScript

// Mostrar alerta si el navegador es viejo
if (!window.fetch) {
  alert(
    "Tu navegador es muy antiguo. Algunas funciones pueden no funcionar correctamente."
  );
}

// Ejemplo: Confirmación antes de eliminar favoritos (si se implementa)
document.addEventListener("DOMContentLoaded", () => {
  const botonesEliminar = document.querySelectorAll(".btn-eliminar-favorito");
  botonesEliminar.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      if (!confirm("¿Seguro que deseas eliminar este favorito?")) {
        e.preventDefault();
      }
    });
  });

  // Scroll automático al final de la página si se responde a un hilo
  if (window.location.href.includes("view_topic.php")) {
    const respuestaBox = document.querySelector("textarea[name='contenido']");
    if (respuestaBox) respuestaBox.scrollIntoView({ behavior: "smooth" });
  }

  // Modo Oscuro
  const toggle = document.getElementById("modoGamerToggle");
  const body = document.body;
  const titulo = document.querySelector("h1.text-primary");

  function activarModoGamer() {
    body.classList.remove("bg-light", "text-dark");
    body.classList.add("bg-dark", "text-light");
    if (titulo) {
      titulo.classList.remove("text-primary");
      titulo.classList.add("text-white");
    }
  }

  function desactivarModoGamer() {
    body.classList.remove("bg-dark", "text-light");
    body.classList.add("bg-light", "text-dark");
    if (titulo) {
      titulo.classList.remove("text-white");
      titulo.classList.add("text-primary");
    }
  }

  // Aplicar modo guardado para que guarde aun que recarguemos
  if (localStorage.getItem("modoGamer") === "on") {
    activarModoGamer();
    if (toggle) toggle.checked = true;
  }

  // Escuchar cambios
  if (toggle) {
    toggle.addEventListener("change", () => {
      if (toggle.checked) {
        activarModoGamer();
        localStorage.setItem("modoGamer", "on");
      } else {
        desactivarModoGamer();
        localStorage.setItem("modoGamer", "off");
      }
    });
  }
});
