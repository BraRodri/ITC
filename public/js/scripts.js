$('#boton_cerrar_sesion').on('click', function() {
    Swal.fire({
        title: 'Cerrar Sesión',
        text: "¿Estas seguro de cerrar la sesión actual?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, salir'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form_cerrar_sesion').submit();
        }
    });
});
