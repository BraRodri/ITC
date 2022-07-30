
//proceso de login
$('#formulario_login').on('submit', function(e) {
    event.preventDefault();
    if ($('#formulario_login')[0].checkValidity() === false) {
        event.stopPropagation();
    } else {

        // agregar data
        var $thisForm = $('#formulario_login');
        var formData = new FormData(this);

        //ruta
        var url = route('validar_login');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            type: "POST",
            encoding:"UTF-8",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            beforeSend:function(){
                Swal.fire({
                    title: 'Espera',
                    text: "Validando datos, espere por favor...",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            }
        }).done(function(respuesta){
            //console.log(respuesta);
            if (!respuesta.error) {
                Swal.fire({
                    text: "Inicio de Sesión Exitoso, redireccionando...",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 10000
                });
                location.reload();

            } else {
                setTimeout(function(){
                    Swal.fire({
                        title: "Se presento un error!",
                        text: respuesta.mensaje,
                        icon: 'error',
                    });
                },2000);
            }
        }).fail(function(resp){
            console.log(resp);
        });

    }
    $('#formulario_login').addClass('was-validated');

});
