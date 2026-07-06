$(document).ready(function(){
    /*------- funcion de el boton para salir del sistema -------*/
    $('.btn-exit-system').on('click', function(e){
        e.preventDefault();

        // Llamar a un archivo PHP para destruir las variables de sesión
    
        alert.fire({
            title: 'Estas Seguro(a)?',
            text: "Se cerrará la sesión",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: ' Sí, Salir!',
            cancelButtonText: ' No, Cancelar!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="../controller/logout.php";
            }
        });
    });

});