function advertencia(e) {
    e.preventDefault();
    console.log('advertencia function called'); // Debug message

    var url = e.currentTarget.getAttribute('href');
    console.log('URL:', url); // Debug message

    Swal.fire({
        title: '¿Está seguro?',
        text: '¡No podrá recuperar este registro!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2CB073',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Eliminar',
        cancelButtonText: 'No, Salir',
        reverseButtons: true,
        padding: '20px',
        backdrop: true,
        position: 'top',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: false,
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Confirmed'); // Debug message
            window.location.href = url;
        } else {
            console.log('Cancelled'); // Debug message
        }
    });
}

document.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed'); // Debug message

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert no está cargado.');
    }
    if (typeof $ === 'undefined') {
        console.error('jQuery no está cargado.');
    }
});
