document.addEventListener("DOMContentLoaded", function() {
    const dialog = document.getElementById("dialog");
    const openDialogBtn = document.getElementById("generarReporteBtn");
    const closeDialogBtn = document.querySelector(".close");
    const aceptarBtn = document.getElementById("aceptarBtn");
    const cancelarBtn = document.getElementById("cancelarBtn");
    const cedulaInput = document.getElementById("cedula");
    const hiddenCedulaInput = document.getElementById("cedulaInput");
    const reporteForm = document.getElementById("reporteForm");

    openDialogBtn.onclick = function() {
        dialog.style.display = "block";
    }

    closeDialogBtn.onclick = function() {
        dialog.style.display = "none";
    }

    aceptarBtn.onclick = function() {
        hiddenCedulaInput.value = cedulaInput.value;
        reporteForm.style.display = "block";
        dialog.style.display = "none";
        reporteForm.submit();
    }

    cancelarBtn.onclick = function() {
        dialog.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == dialog) {
            dialog.style.display = "none";
        }
    }
});
