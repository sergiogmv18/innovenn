
/*
 * Ajax request https
 * @author SGV
 * @version 1.0 - 20230215 - initial release
 * @return 
**/
function ajaxRequest(url, method = 'POST', data = null, successCallback, errorCallback) {
    showLoading();
    $.ajax({
        url: url,
        type: method,
        data: data,
        processData: false,  // No procesar datos automáticamente
        contentType: false,  // No establecer content-type automáticamente
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Agregar el token CSRF
        },
        success: function(response) {
            hideLoading();
            successCallback(response);
        },
        error: function(jqXHR, textStatus, errorThrown,response) {
            hideLoading();
            errorCallback(jqXHR.status, textStatus, errorThrown, response);
        }
    });
}

/*
 * Show Loading Component
 * @author SGV
 * @version 1.0     - 20230215  - initial release
 * @return <html>
**/
function showLoading() {
    document.getElementById("loading").style.display = "block"; // Muestra el loading
}

/*
 * Hide Loading Component
 * @author SGV
 * @version 1.0     - 20230215  - initial release
 * @return <html>
**/
function hideLoading() {
    document.getElementById("loading").style.display = "none"; // Oculta el loading
}


function esMenorDe18(fechaNacimiento) {
    // Convertir la cadena a un objeto Date
    const fechaNac = new Date(fechaNacimiento);

    // Obtener la fecha actual
    const fechaActual = new Date();

    // Calcular la diferencia de años
    const edad = fechaActual.getFullYear() - fechaNac.getFullYear();

    // Verificar si ya cumplió los años este año
    const cumpleAniosEsteAno = (fechaActual.getMonth() > fechaNac.getMonth()) || 
                               (fechaActual.getMonth() === fechaNac.getMonth() && fechaActual.getDate() >= fechaNac.getDate());

    // Si no ha cumplido años este año, restar 1
    return (edad - (cumpleAniosEsteAno ? 0 : 1)) < 18;
}


 // Función para normalizar la fecha (sin horas)
 function normalizeDate(date) {
    return new Date(date.getFullYear(), date.getMonth(), date.getDate());
}



