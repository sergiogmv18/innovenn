 /**
 * Detecta si el navegador es Safari en un dispositivo iOS (iPhone, iPad o iPod),
 * incluyendo iPadOS 13+ que reporta plataforma "MacIntel" pero tiene pantalla táctil.
 */
function isIOSSafari() {
  const ua = navigator.userAgent;
  const platform = navigator.platform;
  const hasTouch = navigator.maxTouchPoints && navigator.maxTouchPoints > 1;

  // Dispositivos iPhone, iPad (antiguo) o iPod con Safari
  const isiPadOld = /iP(hone|ad|od)/.test(platform) && /Safari/.test(ua);

  // iPadOS 13+ identifica plataforma como "MacIntel" pero con touch y Safari
  const isiPadNew =
    platform === 'MacIntel' &&               // reporta plataforma de Mac
    hasTouch &&                              // tiene pantalla táctil
    /Safari/.test(ua) &&                     // es Safari
    !/CriOS|FxiOS|OPiOS|Chrome/.test(ua);    // no sea Chrome, Firefox u otros

  // Devuelve true si coincide con cualquiera de los casos anteriores
  return isiPadOld || isiPadNew;
}

/**
 * Inicializa los <select> de la página según el navegador.
 * - En iOS Safari (incluido iPadOS): oculta los estilos de Materialize y fuerza
 *   el select nativo.
 * - En otros navegadores: inicializa el plugin de Materialize con opciones de dropdown.
 */
function initialSelectMaterialize() {
  const isiOSSafari = isIOSSafari();
  // Recorre todos los elementos <select> de la página
  document.querySelectorAll('select').forEach(el => {
    if (isiOSSafari) {
      // iOS Safari: ocultamos las labels de Materialize
      document.querySelectorAll('.label-select-materialize')
              .forEach(lb => lb.style.display = 'none');
      // y mostramos las labels alternativas si las tuvieras
      document.querySelectorAll('.option-label-select-materialize')
              .forEach(lb => lb.style.display = 'block');
      // forzamos uso del select nativo del navegador
      el.classList.add('browser-default');
    } else {
      // Otros navegadores: inicializamos Materialize para estilizar el select
      M.FormSelect.init(el, {
        dropdownOptions: {
          coverTrigger: false,       // no tapa el input al abrir el dropdown
          container: document.body,  // añade el dropdown al body
          constrainWidth: false,     // ancho libre, no lo ajusta al select
          alignment: 'left'          // alineación del dropdown a la izquierda
        }
      });
    }
  });
}



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

/*
 * Show Toast Component
 * @author SGV
 * @version 1.0     - 20230215  - initial release
 * @param <String>  - title     - Title to show 
 * @param <int>     - time      - Sample time
 * @param <String>  - classesType - Class html to change style
 * @return <Toas>
**/
function showToastComponent(title, time, classesType){
    let classes = 'rounded green darken-1'
    if(classesType != null){
        switch(classesType){
            case 'error':
                classes = 'rounded red darken-1';
                break;
            case 'notification':
                classes = 'rounded blue darken-1';
                break;
        }
    }
    M.toast({
        html: title, 
        displayLength: time != null ? time : 4000,
        classes: classes,
        completeCallback: function() {
            console.log('Toast cerrado.');
        }
    }); 
}



/*
 * Initial Modal Materialize
 * @author SGV
 * @version 1.0 - 20230215 - initial release
 * @return <void>
**/
function initalModal(){
    let elems = document.querySelectorAll('.modal');
    let options = {
        opacity: 0.7,
        inDuration: 300,
        outDuration: 200,
        dismissible: false,
        startingTop: '10%',
        endingTop: '20%'
    };
    M.Modal.init(elems, options);
}


function topFunction() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Desplazamiento suave
    });
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


/*
 * Get all Countries
 * @author SGV
 * @version 1.0 - 20230215 - initial release
 * @return <array>
**/
function allCountries() { 
    return [
        { name: "España", code: "ES",  codeAlfa3:'ESP', flags: "https://flagcdn.com/es.svg", phoneNumber: "+34" },
        { name: "Afghanistan", code: "AF", codeAlfa3:'AFG', flags: "https://upload.wikimedia.org/wikipedia/commons/5/5c/Flag_of_the_Taliban.svg", phoneNumber: "+93" },
        { name: "Åland Islands", code: "AX", codeAlfa3:'ALA', flags: "https://flagcdn.com/ax.svg", phoneNumber: "+35818" },
        { name: "Albania", code: "AL", codeAlfa3:'ALB', flags: "https://flagcdn.com/al.svg", phoneNumber: "+355" },
        { name: "Algeria", code: "DZ", codeAlfa3:'DZA', flags: "https://flagcdn.com/dz.svg", phoneNumber: "+213" },
        { name: "American Samoa", code: "AS", codeAlfa3:'ASM', flags: "https://flagcdn.com/as.svg", phoneNumber: "+1684" },
        { name: "Andorra", code: "AD", codeAlfa3:'AND', flags: "https://flagcdn.com/ad.svg", phoneNumber: "+376" },
        { name: "Angola", code: "AO", codeAlfa3:'AGO', flags: "https://flagcdn.com/ao.svg", phoneNumber: "+244" },
        { name: "Anguilla", code: "AI", codeAlfa3:'AIA', flags: "https://flagcdn.com/ai.svg", phoneNumber: "+1264" },
        { name: "Antarctica", code: "AQ", codeAlfa3:'ATA', flags: "https://flagcdn.com/aq.svg", phoneNumber: "undefinedundefined" },
        { name: "Antigua and Barbuda", code: "AG", codeAlfa3:'ATG', flags: "https://flagcdn.com/ag.svg", phoneNumber: "+1268" },
        { name: "Argentina", code: "AR", codeAlfa3:'', flags: "https://flagcdn.com/ar.svg", phoneNumber: "+54" },
        { name: "Armenia", code: "AM", codeAlfa3:'', flags: "https://flagcdn.com/am.svg", phoneNumber: "+374" },
        { name: "Aruba", code: "AW", codeAlfa3:'', flags: "https://flagcdn.com/aw.svg", phoneNumber: "+297" },
        { name: "Australia", code: "AU", codeAlfa3:'', flags: "https://flagcdn.com/au.svg", phoneNumber: "+61" },
        { name: "Austria", code: "AT", codeAlfa3:'', flags: "https://flagcdn.com/at.svg", phoneNumber: "+43" },
        { name: "Azerbaijan", code: "AZ", codeAlfa3:'', flags: "https://flagcdn.com/az.svg", phoneNumber: "+994" },
        { name: "Bahamas", code: "BS", codeAlfa3:'', flags: "https://flagcdn.com/bs.svg", phoneNumber: "+1242" },
        { name: "Bahrain", code: "BH", codeAlfa3:'', flags: "https://flagcdn.com/bh.svg", phoneNumber: "+973" },
        { name: "Bangladesh", code: "BD", codeAlfa3:'', flags: "https://flagcdn.com/bd.svg", phoneNumber: "+880" },
        { name: "Barbados", code: "BB", codeAlfa3:'', flags: "https://flagcdn.com/bb.svg", phoneNumber: "+1246" },
        { name: "Belarus", code: "BY", codeAlfa3:'', flags: "https://flagcdn.com/by.svg", phoneNumber: "+375" },
        { name: "Belgium", code: "BE", codeAlfa3:'', flags: "https://flagcdn.com/be.svg", phoneNumber: "+32" },
        { name: "Belize", code: "BZ", codeAlfa3:'', flags: "https://flagcdn.com/bz.svg", phoneNumber: "+501" },
        { name: "Benin", code: "BJ", codeAlfa3:'', flags: "https://flagcdn.com/bj.svg", phoneNumber: "+229" },
        { name: "Bermuda", code: "BM", codeAlfa3:'', flags: "https://flagcdn.com/bm.svg", phoneNumber: "+1441" },
        { name: "Bhutan", code: "BT", codeAlfa3:'', flags: "https://flagcdn.com/bt.svg", phoneNumber: "+975" },
        { name: "Bolivia", code: "BO", codeAlfa3:'', flags: "https://flagcdn.com/bo.svg", phoneNumber: "+591" },
        { name: "Bosnia and Herzegovina", code: "BA", codeAlfa3:'', flags: "https://flagcdn.com/ba.svg", phoneNumber: "+387" },
        { name: "Botswana", code: "BW", codeAlfa3:'', flags: "https://flagcdn.com/bw.svg", phoneNumber: "+267" },
        { name: "Bouvet Island", code: "BV", codeAlfa3:'', flags: "https://flagcdn.com/bv.svg", phoneNumber: "+47" },
        { name: "Brazil", code: "BR", codeAlfa3:'', flags: "https://flagcdn.com/br.svg", phoneNumber: "+55" },
        { name: "British Indian Ocean Territory", code: "IO", codeAlfa3:'', flags: "https://flagcdn.com/io.svg", phoneNumber: "+246" },
        { name: "British Virgin Islands", code: "VG", codeAlfa3:'', flags: "https://flagcdn.com/vg.svg", phoneNumber: "+1284" },
        { name: "Brunei", code: "BN", codeAlfa3:'', flags: "https://flagcdn.com/bn.svg", phoneNumber: "+673" },
        { name: "Bulgaria", code: "BG", codeAlfa3:'', flags: "https://flagcdn.com/bg.svg", phoneNumber: "+359" },
        { name: "Burkina Faso", code: "BF", codeAlfa3:'', flags: "https://flagcdn.com/bf.svg", phoneNumber: "+226" },
        { name: "Burundi", code: "BI", codeAlfa3:'', flags: "https://flagcdn.com/bi.svg", phoneNumber: "+257" },
        { name: "Cambodia", code: "KH", codeAlfa3:'', flags: "https://flagcdn.com/kh.svg", phoneNumber: "+855" },
        { name: "Cameroon", code: "CM", codeAlfa3:'', flags: "https://flagcdn.com/cm.svg", phoneNumber: "+237" },
        { name: "Canada", code: "CA", codeAlfa3:'', flags: "https://flagcdn.com/ca.svg", phoneNumber: "+1" },
        { name: "Cape Verde", code: "CV", codeAlfa3:'', flags: "https://flagcdn.com/cv.svg", phoneNumber: "+238" },
        { name: "Caribbean Netherlands", code: "BQ", codeAlfa3:'', flags: "https://flagcdn.com/bq.svg", phoneNumber: "+599" },
        { name: "Cayman Islands", code: "KY", codeAlfa3:'', flags: "https://flagcdn.com/ky.svg", phoneNumber: "+1345" },
        { name: "Central African Republic", code: "CF", codeAlfa3:'', flags: "https://flagcdn.com/cf.svg", phoneNumber: "+236" },
        { name: "Chad", code: "TD", codeAlfa3:'', flags: "https://flagcdn.com/td.svg", phoneNumber: "+235" },
        { name: "Chile", code: "CL", codeAlfa3:'', flags: "https://flagcdn.com/cl.svg", phoneNumber: "+56" },
        { name: "China", code: "CN", codeAlfa3:'', flags: "https://flagcdn.com/cn.svg", phoneNumber: "+86" },
        { name: "Christmas Island", code: "CX", codeAlfa3:'', flags: "https://flagcdn.com/cx.svg", phoneNumber: "+61" },
        { name: "Cocos (Keeling) Islands", code: "CC", codeAlfa3:'', flags: "https://flagcdn.com/cc.svg", phoneNumber: "+61" },
        { name: "Colombia", code: "CO", codeAlfa3:'', flags: "https://flagcdn.com/co.svg", phoneNumber: "+57" },
        { name: "Comoros", code: "KM", codeAlfa3:'', flags: "https://flagcdn.com/km.svg", phoneNumber: "+269" },
        { name: "Cook Islands", code: "CK", codeAlfa3:'', flags: "https://flagcdn.com/ck.svg", phoneNumber: "+682" },
        { name: "Costa Rica", code: "CR", codeAlfa3:'', flags: "https://flagcdn.com/cr.svg", phoneNumber: "+506" },
        { name: "Croatia", code: "HR", codeAlfa3:'', flags: "https://flagcdn.com/hr.svg", phoneNumber: "+385" },
        { name: "Cuba", code: "CU", codeAlfa3:'', flags: "https://flagcdn.com/cu.svg", phoneNumber: "+53" },
        { name: "Curaçao", code: "CW", codeAlfa3:'', flags: "https://flagcdn.com/cw.svg", phoneNumber: "+599" },
        { name: "Cyprus", code: "CY", codeAlfa3:'', flags: "https://flagcdn.com/cy.svg", phoneNumber: "+357" },
        { name: "Czechia", code: "CZ", codeAlfa3:'', flags: "https://flagcdn.com/cz.svg", phoneNumber: "+420" },
        { name: "Denmark", code: "DK", codeAlfa3:'', flags: "https://flagcdn.com/dk.svg", phoneNumber: "+45" },
        { name: "Djibouti", code: "DJ", codeAlfa3:'', flags: "https://flagcdn.com/dj.svg", phoneNumber: "+253" },
        { name: "Dominica", code: "DM", codeAlfa3:'', flags: "https://flagcdn.com/dm.svg", phoneNumber: "+1767" },
        { name: "Dominican Republic", code: "DO", codeAlfa3:'', flags: "https://flagcdn.com/do.svg", phoneNumber: "+1809,829,849" },
        { name: "DR Congo", code: "CD", codeAlfa3:'', flags: "https://flagcdn.com/cd.svg", phoneNumber: "+243" },
        { name: "Ecuador", code: "EC", codeAlfa3:'', flags: "https://flagcdn.com/ec.svg", phoneNumber: "+593" },
        { name: "Egypt", code: "EG", codeAlfa3:'', flags: "https://flagcdn.com/eg.svg", phoneNumber: "+20" },
        { name: "El Salvador", code: "SV", codeAlfa3:'', flags: "https://flagcdn.com/sv.svg", phoneNumber: "+503" },
        { name: "Equatorial Guinea", code: "GQ", codeAlfa3:'', flags: "https://flagcdn.com/gq.svg", phoneNumber: "+240" },
        { name: "Eritrea", code: "ER", codeAlfa3:'', flags: "https://flagcdn.com/er.svg", phoneNumber: "+291" },
        { name: "Estonia", code: "EE", codeAlfa3:'', flags: "https://flagcdn.com/ee.svg", phoneNumber: "+372" },
        { name: "Eswatini", code: "SZ", codeAlfa3:'', flags: "https://flagcdn.com/sz.svg", phoneNumber: "+268" },
        { name: "Ethiopia", code: "ET", codeAlfa3:'', flags: "https://flagcdn.com/et.svg", phoneNumber: "+251" },
        { name: "Falkland Islands", code: "FK", codeAlfa3:'', flags: "https://flagcdn.com/fk.svg", phoneNumber: "+500" },
        { name: "Faroe Islands", code: "FO", codeAlfa3:'', flags: "https://flagcdn.com/fo.svg", phoneNumber: "+298" },
        { name: "Fiji", code: "FJ", codeAlfa3:'', flags: "https://flagcdn.com/fj.svg", phoneNumber: "+679" },
        { name: "Finland", code: "FI", codeAlfa3:'', flags: "https://flagcdn.com/fi.svg", phoneNumber: "+358" },
        { name: "France", code: "FR", codeAlfa3:'', flags: "https://flagcdn.com/fr.svg", phoneNumber: "+33" },
        { name: "French Guiana", code: "GF", codeAlfa3:'', flags: "https://flagcdn.com/gf.svg", phoneNumber: "+594" },
        { name: "French Polynesia", code: "PF", codeAlfa3:'', flags: "https://flagcdn.com/pf.svg", phoneNumber: "+689" },
        { name: "French Southern and Antarctic Lands", code: "TF", codeAlfa3:'', flags: "https://flagcdn.com/tf.svg", phoneNumber: "+262" },
        { name: "Gabon", code: "GA", codeAlfa3:'', flags: "https://flagcdn.com/ga.svg", phoneNumber: "+241" },
        { name: "Gambia", code: "GM", codeAlfa3:'', flags: "https://flagcdn.com/gm.svg", phoneNumber: "+220" },
        { name: "Georgia", code: "GE", codeAlfa3:'', flags: "https://flagcdn.com/ge.svg", phoneNumber: "+995" },
        { name: "Germany", code: "DE", codeAlfa3:'', flags: "https://flagcdn.com/de.svg", phoneNumber: "+49" },
        { name: "Ghana", code: "GH", codeAlfa3:'', flags: "https://flagcdn.com/gh.svg", phoneNumber: "+233" },
        { name: "Gibraltar", code: "GI", codeAlfa3:'', flags: "https://flagcdn.com/gi.svg", phoneNumber: "+350" },
        { name: "Greece", code: "GR", codeAlfa3:'', flags: "https://flagcdn.com/gr.svg", phoneNumber: "+30" },
        { name: "Greenland", code: "GL", codeAlfa3:'', flags: "https://flagcdn.com/gl.svg", phoneNumber: "+299" },
        { name: "Grenada", code: "GD", codeAlfa3:'', flags: "https://flagcdn.com/gd.svg", phoneNumber: "+1473" },
        { name: "Guadeloupe", code: "GP", codeAlfa3:'', flags: "https://flagcdn.com/gp.svg", phoneNumber: "+590" },
        { name: "Guam", code: "GU", codeAlfa3:'', flags: "https://flagcdn.com/gu.svg", phoneNumber: "+1671" },
        { name: "Guatemala", code: "GT", codeAlfa3:'', flags: "https://flagcdn.com/gt.svg", phoneNumber: "+502" },
        { name: "Guernsey", code: "GG", codeAlfa3:'', flags: "https://flagcdn.com/gg.svg", phoneNumber: "+44" },
        { name: "Guinea", code: "GN", codeAlfa3:'', flags: "https://flagcdn.com/gn.svg", phoneNumber: "+224" },
        { name: "Guinea-Bissau", code: "GW", codeAlfa3:'', flags: "https://flagcdn.com/gw.svg", phoneNumber: "+245" },
        { name: "Guyana", code: "GY", codeAlfa3:'', flags: "https://flagcdn.com/gy.svg", phoneNumber: "+592" },
        { name: "Haiti", code: "HT", codeAlfa3:'', flags: "https://flagcdn.com/ht.svg", phoneNumber: "+509" },
        { name: "Heard Island and McDonald Islands", code: "HM", codeAlfa3:'', flags: "https://flagcdn.com/hm.svg", phoneNumber: "undefinedundefined" },
        { name: "Honduras", code: "HN", codeAlfa3:'', flags: "https://flagcdn.com/hn.svg", phoneNumber: "+504" },
        { name: "Hong Kong", code: "HK", codeAlfa3:'', flags: "https://flagcdn.com/hk.svg", phoneNumber: "+852" },
        { name: "Hungary", code: "HU", codeAlfa3:'', flags: "https://flagcdn.com/hu.svg", phoneNumber: "+36" },
        { name: "Iceland", code: "IS", codeAlfa3:'', flags: "https://flagcdn.com/is.svg", phoneNumber: "+354" },
        { name: "India", code: "IN", codeAlfa3:'', flags: "https://flagcdn.com/in.svg", phoneNumber: "+91" },
        { name: "Indonesia", code: "ID", codeAlfa3:'', flags: "https://flagcdn.com/id.svg", phoneNumber: "+62" },
        { name: "Iran", code: "IR", codeAlfa3:'', flags: "https://flagcdn.com/ir.svg", phoneNumber: "+98" },
        { name: "Iraq", code: "IQ", codeAlfa3:'', flags: "https://flagcdn.com/iq.svg", phoneNumber: "+964" },
        { name: "Ireland", code: "IE", codeAlfa3:'', flags: "https://flagcdn.com/ie.svg", phoneNumber: "+353" },
        { name: "Isle of Man", code: "IM", codeAlfa3:'', flags: "https://flagcdn.com/im.svg", phoneNumber: "+44" },
        { name: "Israel", code: "IL", codeAlfa3:'', flags: "https://flagcdn.com/il.svg", phoneNumber: "+972" },
        { name: "Italy", code: "IT", codeAlfa3:'', flags: "https://flagcdn.com/it.svg", phoneNumber: "+39" },
        { name: "Ivory Coast", code: "CI", codeAlfa3:'', flags: "https://flagcdn.com/ci.svg", phoneNumber: "+225" },
        { name: "Jamaica", code: "JM", codeAlfa3:'', flags: "https://flagcdn.com/jm.svg", phoneNumber: "+1876" },
        { name: "Japan", code: "JP", codeAlfa3:'', flags: "https://flagcdn.com/jp.svg", phoneNumber: "+81" },
        { name: "Jersey", code: "JE", codeAlfa3:'', flags: "https://flagcdn.com/je.svg", phoneNumber: "+44" },
        { name: "Jordan", code: "JO", codeAlfa3:'', flags: "https://flagcdn.com/jo.svg", phoneNumber: "+962" },
        { name: "Kazakhstan", code: "KZ", codeAlfa3:'', flags: "https://flagcdn.com/kz.svg", phoneNumber: "+76,7" },
        { name: "Kenya", code: "KE", codeAlfa3:'', flags: "https://flagcdn.com/ke.svg", phoneNumber: "+254" },
        { name: "Kiribati", code: "KI", codeAlfa3:'', flags: "https://flagcdn.com/ki.svg", phoneNumber: "+686" },
        { name: "Kosovo", code: "XK", codeAlfa3:'', flags: "https://flagcdn.com/xk.svg", phoneNumber: "+383" },
        { name: "Kuwait", code: "KW", codeAlfa3:'', flags: "https://flagcdn.com/kw.svg", phoneNumber: "+965" },
        { name: "Kyrgyzstan", code: "KG", codeAlfa3:'', flags: "https://flagcdn.com/kg.svg", phoneNumber: "+996" },
        { name: "Laos", code: "LA", codeAlfa3:'', flags: "https://flagcdn.com/la.svg", phoneNumber: "+856" },
        { name: "Latvia", code: "LV", codeAlfa3:'', flags: "https://flagcdn.com/lv.svg", phoneNumber: "+371" },
        { name: "Lebanon", code: "LB", codeAlfa3:'', flags: "https://flagcdn.com/lb.svg", phoneNumber: "+961" },
        { name: "Lesotho", code: "LS", codeAlfa3:'', flags: "https://flagcdn.com/ls.svg", phoneNumber: "+266" },
        { name: "Liberia", code: "LR", codeAlfa3:'', flags: "https://flagcdn.com/lr.svg", phoneNumber: "+231" },
        { name: "Libya", code: "LY", codeAlfa3:'', flags: "https://flagcdn.com/ly.svg", phoneNumber: "+218" },
        { name: "Liechtenstein", code: "LI", codeAlfa3:'', flags: "https://flagcdn.com/li.svg", phoneNumber: "+423" },
        { name: "Lithuania", code: "LT", codeAlfa3:'', flags: "https://flagcdn.com/lt.svg", phoneNumber: "+370" },
        { name: "Luxembourg", code: "LU", codeAlfa3:'', flags: "https://flagcdn.com/lu.svg", phoneNumber: "+352" },
        { name: "Macau", code: "MO", codeAlfa3:'', flags: "https://flagcdn.com/mo.svg", phoneNumber: "+853" },
        { name: "Madagascar", code: "MG", codeAlfa3:'', flags: "https://flagcdn.com/mg.svg", phoneNumber: "+261" },
        { name: "Malawi", code: "MW", codeAlfa3:'', flags: "https://flagcdn.com/mw.svg", phoneNumber: "+265" },
        { name: "Malaysia", code: "MY", codeAlfa3:'', flags: "https://flagcdn.com/my.svg", phoneNumber: "+60" },
        { name: "Maldives", code: "MV", codeAlfa3:'', flags: "https://flagcdn.com/mv.svg", phoneNumber: "+960" },
        { name: "Mali", code: "ML", codeAlfa3:'', flags: "https://flagcdn.com/ml.svg", phoneNumber: "+223" },
        { name: "Malta", code: "MT", codeAlfa3:'', flags: "https://flagcdn.com/mt.svg", phoneNumber: "+356" },
        { name: "Marshall Islands", code: "MH", codeAlfa3:'', flags: "https://flagcdn.com/mh.svg", phoneNumber: "+692" },
        { name: "Martinique", code: "MQ", codeAlfa3:'', flags: "https://flagcdn.com/mq.svg", phoneNumber: "+596" },
        { name: "Mauritania", code: "MR", codeAlfa3:'', flags: "https://flagcdn.com/mr.svg", phoneNumber: "+222" },
        { name: "Mauritius", code: "MU", codeAlfa3:'', flags: "https://flagcdn.com/mu.svg", phoneNumber: "+230" },
        { name: "Mayotte", code: "YT", codeAlfa3:'', flags: "https://flagcdn.com/yt.svg", phoneNumber: "+262" },
        { name: "Mexico", code: "MX", codeAlfa3:'', flags: "https://flagcdn.com/mx.svg", phoneNumber: "+52" },
        { name: "Micronesia", code: "FM", codeAlfa3:'', flags: "https://flagcdn.com/fm.svg", phoneNumber: "+691" },
        { name: "Moldova", code: "MD", codeAlfa3:'', flags: "https://flagcdn.com/md.svg", phoneNumber: "+373" },
        { name: "Monaco", code: "MC", codeAlfa3:'', flags: "https://flagcdn.com/mc.svg", phoneNumber: "+377" },
        { name: "Mongolia", code: "MN", codeAlfa3:'', flags: "https://flagcdn.com/mn.svg", phoneNumber: "+976" },
        { name: "Montenegro", code: "ME", codeAlfa3:'', flags: "https://flagcdn.com/me.svg", phoneNumber: "+382" },
        { name: "Montserrat", code: "MS", codeAlfa3:'', flags: "https://flagcdn.com/ms.svg", phoneNumber: "+1664" },
        { name: "Morocco", code: "MA", codeAlfa3:'', flags: "https://flagcdn.com/ma.svg", phoneNumber: "+212" },
        { name: "Mozambique", code: "MZ", codeAlfa3:'', flags: "https://flagcdn.com/mz.svg", phoneNumber: "+258" },
        { name: "Myanmar", code: "MM", codeAlfa3:'', flags: "https://flagcdn.com/mm.svg", phoneNumber: "+95" },
        { name: "Namibia", code: "NA", codeAlfa3:'', flags: "https://flagcdn.com/na.svg", phoneNumber: "+264" },
        { name: "Nauru", code: "NR", codeAlfa3:'', flags: "https://flagcdn.com/nr.svg", phoneNumber: "+674" },
        { name: "Nepal", code: "NP", codeAlfa3:'', flags: "https://flagcdn.com/np.svg", phoneNumber: "+977" },
        { name: "Netherlands", code: "NL", codeAlfa3:'', flags: "https://flagcdn.com/nl.svg", phoneNumber: "+31" },
        { name: "New Caledonia", code: "NC", codeAlfa3:'', flags: "https://flagcdn.com/nc.svg", phoneNumber: "+687" },
        { name: "New Zealand", code: "NZ", codeAlfa3:'', flags: "https://flagcdn.com/nz.svg", phoneNumber: "+64" },
        { name: "Nicaragua", code: "NI", codeAlfa3:'', flags: "https://flagcdn.com/ni.svg", phoneNumber: "+505" },
        { name: "Niger", code: "NE", codeAlfa3:'', flags: "https://flagcdn.com/ne.svg", phoneNumber: "+227" },
        { name: "Nigeria", code: "NG", codeAlfa3:'', flags: "https://flagcdn.com/ng.svg", phoneNumber: "+234" },
        { name: "Niue", code: "NU", codeAlfa3:'', flags: "https://flagcdn.com/nu.svg", phoneNumber: "+683" },
        { name: "Norfolk Island", code: "NF", codeAlfa3:'', flags: "https://flagcdn.com/nf.svg", phoneNumber: "+672" },
        { name: "North Korea", code: "KP", codeAlfa3:'', flags: "https://flagcdn.com/kp.svg", phoneNumber: "+850" },
        { name: "North Macedonia", code: "MK", codeAlfa3:'', flags: "https://flagcdn.com/mk.svg", phoneNumber: "+389" },
        { name: "Northern Mariana Islands", code: "MP", codeAlfa3:'', flags: "https://flagcdn.com/mp.svg", phoneNumber: "+1670" },
        { name: "Norway", code: "NO", codeAlfa3:'', flags: "https://flagcdn.com/no.svg", phoneNumber: "+47" },
        { name: "Oman", code: "OM", codeAlfa3:'', flags: "https://flagcdn.com/om.svg", phoneNumber: "+968" },
        { name: "Pakistan", code: "PK", codeAlfa3:'', flags: "https://flagcdn.com/pk.svg", phoneNumber: "+92" },
        { name: "Palau", code: "PW", codeAlfa3:'', flags: "https://flagcdn.com/pw.svg", phoneNumber: "+680" },
        { name: "Palestine", code: "PS", codeAlfa3:'', flags: "https://flagcdn.com/ps.svg", phoneNumber: "+970" },
        { name: "Panama", code: "PA", codeAlfa3:'', flags: "https://flagcdn.com/pa.svg", phoneNumber: "+507" },
        { name: "Papua New Guinea", code: "PG", codeAlfa3:'', flags: "https://flagcdn.com/pg.svg", phoneNumber: "+675" },
        { name: "Paraguay", code: "PY", codeAlfa3:'', flags: "https://flagcdn.com/py.svg", phoneNumber: "+595" },
        { name: "Peru", code: "PE", codeAlfa3:'', flags: "https://flagcdn.com/pe.svg", phoneNumber: "+51" },
        { name: "Philippines", code: "PH", codeAlfa3:'', flags: "https://flagcdn.com/ph.svg", phoneNumber: "+63" },
        { name: "Pitcairn Islands", code: "PN", codeAlfa3:'', flags: "https://flagcdn.com/pn.svg", phoneNumber: "+64" },
        { name: "Poland", code: "PL", codeAlfa3:'', flags: "https://flagcdn.com/pl.svg", phoneNumber: "+48" },
        { name: "Portugal", code: "PT", codeAlfa3:'', flags: "https://flagcdn.com/pt.svg", phoneNumber: "+351" },
        { name: "Puerto Rico", code: "PR", codeAlfa3:'', flags: "https://flagcdn.com/pr.svg", phoneNumber: "+1787,939" },
        { name: "Qatar", code: "QA", codeAlfa3:'', flags: "https://flagcdn.com/qa.svg", phoneNumber: "+974" },
        { name: "Republic of the Congo", code: "CG", codeAlfa3:'', flags: "https://flagcdn.com/cg.svg", phoneNumber: "+242" },
        { name: "Réunion", code: "RE", codeAlfa3:'', flags: "https://flagcdn.com/re.svg", phoneNumber: "+262" },
        { name: "Romania", code: "RO", codeAlfa3:'', flags: "https://flagcdn.com/ro.svg", phoneNumber: "+40" },
        { name: "Russia", code: "RU", codeAlfa3:'', flags: "https://flagcdn.com/ru.svg", phoneNumber: "+73,4,5,8,9" },
        { name: "Rwanda", code: "RW", codeAlfa3:'', flags: "https://flagcdn.com/rw.svg", phoneNumber: "+250" },
        { name: "Saint Barthélemy", code: "BL", codeAlfa3:'', flags: "https://flagcdn.com/bl.svg", phoneNumber: "+590" },
        { name: "Saint Helena, Ascension and Tristan da Cunha", code: "SH", codeAlfa3:'', flags: "https://flagcdn.com/sh.svg", phoneNumber: "+290,47" },
        { name: "Saint Kitts and Nevis", code: "KN", codeAlfa3:'', flags: "https://flagcdn.com/kn.svg", phoneNumber: "+1869" },
        { name: "Saint Lucia", code: "LC", codeAlfa3:'', flags: "https://flagcdn.com/lc.svg", phoneNumber: "+1758" },
        { name: "Saint Martin", code: "MF", codeAlfa3:'', flags: "https://flagcdn.com/mf.svg", phoneNumber: "+590" },
        { name: "Saint Pierre and Miquelon", code: "PM", codeAlfa3:'', flags: "https://flagcdn.com/pm.svg", phoneNumber: "+508" },
        { name: "Saint Vincent and the Grenadines", code: "VC", codeAlfa3:'', flags: "https://flagcdn.com/vc.svg", phoneNumber: "+1784" },
        { name: "Samoa", code: "WS", codeAlfa3:'', flags: "https://flagcdn.com/ws.svg", phoneNumber: "+685" },
        { name: "San Marino", code: "SM", codeAlfa3:'', flags: "https://flagcdn.com/sm.svg", phoneNumber: "+378" },
        { name: "São Tomé and Príncipe", code: "ST", codeAlfa3:'', flags: "https://flagcdn.com/st.svg", phoneNumber: "+239" },
        { name: "Saudi Arabia", code: "SA", codeAlfa3:'', flags: "https://flagcdn.com/sa.svg", phoneNumber: "+966" },
        { name: "Senegal", code: "SN", codeAlfa3:'', flags: "https://flagcdn.com/sn.svg", phoneNumber: "+221" },
        { name: "Serbia", code: "RS", codeAlfa3:'', flags: "https://flagcdn.com/rs.svg", phoneNumber: "+381" },
        { name: "Seychelles", code: "SC", codeAlfa3:'', flags: "https://flagcdn.com/sc.svg", phoneNumber: "+248" },
        { name: "Sierra Leone", code: "SL", codeAlfa3:'', flags: "https://flagcdn.com/sl.svg", phoneNumber: "+232" },
        { name: "Singapore", code: "SG", codeAlfa3:'', flags: "https://flagcdn.com/sg.svg", phoneNumber: "+65" },
        { name: "Sint Maarten", code: "SX", codeAlfa3:'', flags: "https://flagcdn.com/sx.svg", phoneNumber: "+1721" },
        { name: "Slovakia", code: "SK", codeAlfa3:'', flags: "https://flagcdn.com/sk.svg", phoneNumber: "+421" },
        { name: "Slovenia", code: "SI", codeAlfa3:'', flags: "https://flagcdn.com/si.svg", phoneNumber: "+386" },
        { name: "Solomon Islands", code: "SB", codeAlfa3:'', flags: "https://flagcdn.com/sb.svg", phoneNumber: "+677" },
        { name: "Somalia", code: "SO", codeAlfa3:'', flags: "https://flagcdn.com/so.svg", phoneNumber: "+252" },
        { name: "South Africa", code: "ZA", codeAlfa3:'', flags: "https://flagcdn.com/za.svg", phoneNumber: "+27" },
        { name: "South Georgia", code: "GS", codeAlfa3:'', flags: "https://flagcdn.com/gs.svg", phoneNumber: "+500" },
        { name: "South Korea", code: "KR", codeAlfa3:'', flags: "https://flagcdn.com/kr.svg", phoneNumber: "+82" },
        { name: "South Sudan", code: "SS", codeAlfa3:'', flags: "https://flagcdn.com/ss.svg", phoneNumber: "+211" },
        { name: "Sri Lanka", code: "LK", codeAlfa3:'', flags: "https://flagcdn.com/lk.svg", phoneNumber: "+94" },
        { name: "Sudan", code: "SD", codeAlfa3:'', flags: "https://flagcdn.com/sd.svg", phoneNumber: "+249" },
        { name: "Suriname", code: "SR", codeAlfa3:'', flags: "https://flagcdn.com/sr.svg", phoneNumber: "+597" },
        { name: "Svalbard and Jan Mayen", code: "SJ", codeAlfa3:'', flags: "https://flagcdn.com/sj.svg", phoneNumber: "+4779" },
        { name: "Sweden", code: "SE", codeAlfa3:'', flags: "https://flagcdn.com/se.svg", phoneNumber: "+46" },
        { name: "Switzerland", code: "CH", codeAlfa3:'', flags: "https://flagcdn.com/ch.svg", phoneNumber: "+41" },
        { name: "Syria", code: "SY", codeAlfa3:'', flags: "https://flagcdn.com/sy.svg", phoneNumber: "+963" },
        { name: "Taiwan", code: "TW", codeAlfa3:'', flags: "https://flagcdn.com/tw.svg", phoneNumber: "+886" },
        { name: "Tajikistan", code: "TJ", codeAlfa3:'', flags: "https://flagcdn.com/tj.svg", phoneNumber: "+992" },
        { name: "Tanzania", code: "TZ", codeAlfa3:'', flags: "https://flagcdn.com/tz.svg", phoneNumber: "+255" },
        { name: "Thailand", code: "TH", codeAlfa3:'', flags: "https://flagcdn.com/th.svg", phoneNumber: "+66" },
        { name: "Timor-Leste", code: "TL", codeAlfa3:'', flags: "https://flagcdn.com/tl.svg", phoneNumber: "+670" },
        { name: "Togo", code: "TG", codeAlfa3:'', flags: "https://flagcdn.com/tg.svg", phoneNumber: "+228" },
        { name: "Tokelau", code: "TK", codeAlfa3:'', flags: "https://flagcdn.com/tk.svg", phoneNumber: "+690" },
        { name: "Tonga", code: "TO", codeAlfa3:'', flags: "https://flagcdn.com/to.svg", phoneNumber: "+676" },
        { name: "Trinidad and Tobago", code: "TT", codeAlfa3:'', flags: "https://flagcdn.com/tt.svg", phoneNumber: "+1868" },
        { name: "Tunisia", code: "TN", codeAlfa3:'', flags: "https://flagcdn.com/tn.svg", phoneNumber: "+216" },
        { name: "Turkey", code: "TR", codeAlfa3:'', flags: "https://flagcdn.com/tr.svg", phoneNumber: "+90" },
        { name: "Turkmenistan", code: "TM", codeAlfa3:'', flags: "https://flagcdn.com/tm.svg", phoneNumber: "+993" },
        { name: "Turks and Caicos Islands", code: "TC", codeAlfa3:'', flags: "https://flagcdn.com/tc.svg", phoneNumber: "+1649" },
        { name: "Tuvalu", code: "TV", codeAlfa3:'', flags: "https://flagcdn.com/tv.svg", phoneNumber: "+688" },
        { name: "Uganda", code: "UG", codeAlfa3:'', flags: "https://flagcdn.com/ug.svg", phoneNumber: "+256" },
        { name: "Ukraine", code: "UA", codeAlfa3:'', flags: "https://flagcdn.com/ua.svg", phoneNumber: "+380" },
        { name: "United Arab Emirates", code: "AE", codeAlfa3:'', flags: "https://flagcdn.com/ae.svg", phoneNumber: "+971" },
        { name: "United Kingdom", code: "GB", codeAlfa3:'', flags: "https://flagcdn.com/gb.svg", phoneNumber: "+44" },
        { name: "United States", code: "US", codeAlfa3:'', flags: "https://flagcdn.com/us.svg", phoneNumber: "+1" },
        { name: "United States Minor Outlying Islands", code: "UM", codeAlfa3:'', flags: "https://flagcdn.com/um.svg", phoneNumber: "+268" },
        { name: "United States Virgin Islands", code: "VI", codeAlfa3:'', flags: "https://flagcdn.com/vi.svg", phoneNumber: "+1340" },
        { name: "Uruguay", code: "UY", codeAlfa3:'', flags: "https://flagcdn.com/uy.svg", phoneNumber: "+598" },
        { name: "Uzbekistan", code: "UZ", codeAlfa3:'', flags: "https://flagcdn.com/uz.svg", phoneNumber: "+998" },
        { name: "Vanuatu", code: "VU", codeAlfa3:'', flags: "https://flagcdn.com/vu.svg", phoneNumber: "+678" },
        { name: "Vatican City", code: "VA", codeAlfa3:'', flags: "https://flagcdn.com/va.svg", phoneNumber: "+3906698,79" },
        { name: "Venezuela", code: "VE", codeAlfa3:'', flags: "https://flagcdn.com/ve.svg", phoneNumber: "+58" },
        { name: "Vietnam", code: "VN", codeAlfa3:'', flags: "https://flagcdn.com/vn.svg", phoneNumber: "+84" },
        { name: "Wallis and Futuna", code: "WF", codeAlfa3:'', flags: "https://flagcdn.com/wf.svg", phoneNumber: "+681" },
        { name: "Western Sahara", code: "EH", codeAlfa3:'', flags: "https://flagcdn.com/eh.svg", phoneNumber: "+2125288,125289" },
        { name: "Yemen", code: "YE", codeAlfa3:'', flags: "https://flagcdn.com/ye.svg", phoneNumber: "+967" },
        { name: "Zambia", code: "ZM",  codeAlfa3:'', flags: "https://flagcdn.com/zm.svg", phoneNumber: "+260" },
        { name: "Zimbabwe", code: "ZW",  codeAlfa3:'', flags: "https://flagcdn.com/zw.svg", phoneNumber: "+263"  }
    ];
}



