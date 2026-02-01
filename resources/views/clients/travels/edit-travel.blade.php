@extends('main')
@section('showSearch', false)

@section('title', 'Editar Parte de viajero')
<style>
    .option-label-select-materialize{
        display: none;
    }
</style>
@section('content')
    <!-- FORMULARIOS -->
    <div class="container">
        <div class="row"  style="margin-top: 4.5em;">
            <div class="col s12 m12 l12 lx12">
                <h3 class="left" >Editar partes de viajero {{ $travelWk->firstName.' '.$travelWk->subName}} </h3>
            </div>
        </div>
        <form>
            <div class="row">
<!-- TITLES PERSONAL DATA -->
<div class="col s12 m12 l12 lx12">
                    <h5 class="left" >Datos personales</h5>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{$travelWk->firstName}}" name="travel-name"  type="text" id="travel-name" required class="validate" />
                    <label for="travel-name">Nombre *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{$travelWk->subName}}" name="travel-apellido" required type="text" id="travel-apellido" class="validate" />
                    <label for="travel-apellido">1º Apellido *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{$travelWk->lastName != null? $travelWk->lastName :''}}" name="travel-apellido-2"  type="text" id="travel-do-apellido" class="validate" />
                    <label for="travel-do-apellido">2º Apellido</label>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <select id="country-selector">
                    <option class="option-label-select-materialize" disabled value="">Nacionalidad</option>
                    <option value="{{$travelWk->countrySelected}}" disabled selected>{{$travelWk->countrySelected}}</option>
                        @foreach ($allCountry as $country)
                            <option value="{{$country['name']}}">{{$country['name']}}</option>
                        @endforeach
                    </select>
                    <label class="label-select-materialize">Nacionalidad *</label>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input  value="{{$travelWk->emailAddress}}" name="travel-email-address" required type="text" id="travel-email-address" class="validate" />
                    <label for="travel-email-address">E-mail *</label>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input  value="{{$travelWk->phoneNumber}}" name="travel-phone-number" type="tel" id="travel-phone" class="validate" />
                    <label for="travel-phone">Telefono contacto *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                    
                <div class="input-field col s6 m6 l4 lx4">
                <select class="select-materialize" id="travel-sex">
                    <option class="option-label-select-materialize" disabled value="">Sexo</option>
                    <option selected value="{{$travelWk->sex}}">{{ $travelWk->sex }}</option>
                    <option value="M">M</option>
                    <option value="H">H</option>
                    <option value="O">O</option>
                </select>
                    <label class="label-select-materialize">Sexo</label>
                </div>
                <div class="input-field col s6 m6 l4 lx4">
                    <input value="{{ $travelWk->birthdate }}" name="fecha-de-nacimiento" required type="date" id="travel-fecha-de-nacimiento" class="validate" />
                    <label for="travel-fecha-de-nacimiento">Fecha de nacimiento *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l4 lx4" id="div-parentesco-alojamiento">
                    <select class="select-materialize" id="travel-parentesco-alojamiento">
                        <option class="option-label-select-materialize" disabled value="">Parentesco alojamiento</option>
                        <option value="{{ $travelWk->kinshipLodging }}" selected disabled>{{ $travelWk->kinshipLodging }}</option>
                        <option value="Padres y Madre">Padres y Madre</option>
                        <option value="Abuelos">Abuelos</option>
                        <option value="Bisabuelos">Bisabuelos</option>
                        <option value="Cónyuge">Cónyuge</option>
                        <option value="Cuñado/Cuñada">Cuñado/Cuñada</option>
                        <option value="Hermano/Hermana">Hermano/Hermana</option>
                        <option value="Hijo/Hija">Hijo/Hija</option>
                        <option value="Nieto/Nieta">Nieto/Nieta</option>
                        <option value="Sobrino/Sobrina">Sobrino/Sobrina</option>
                        <option value="Suegros/Suegra">Suegros/Suegra</option>
                        <option value="Tío/Tía">Tío/Tía</option>
                        <option value="Yernos">Yernos</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <label class="label-select-materialize">Parentesco alojamiento *</label>                
                </div>
<!-- DOCUMENTS DATA -->
                <div class="col s12 m12 l12 lx12">
                    <h5 class="left" >Datos de documento</h5>
                </div>
                <div class="input-field col s6 m6 l6 lx6">
                    <select class="select-materialize" id="travel-type-of-documents">
                    <option class="option-label-select-materialize" disabled value="">Tipo de documento</option>
                        <option value="{{ $travelWk->typeDocument }}" selected disabled>{{ $travelWk->typeDocument }}</option>
                        <option value="OTRO">DNI</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="NIF">NIF</option>
                        <option value="NIE">NIE</option>
                        <option value="CIF">CIF</option>
                        <option value="OTRO">OTRO</option>
                    </select>
                    <label class="label-select-materialize">Tipo de documento</label>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{ $travelWk->documentNumber }}" name="number-of-document" required type="text" id="travel-numero-documento" class="validate" />
                    <label for="travel-numero-documento">Numero de documento *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s6 m6 l6 lx6">
                    <input value="{{ $travelWk->dateExpedition }}" name="fecha-de-expedicion" required type="date" id="travel-fecha-de-expedicion" class="validate" />
                    <label for="travel-fecha-de-expedicion">Fecha de expedición *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div id="div-numero-soporte" class="input-field col s12 m6 l6 lx6">
                    <input value="{{ $travelWk->suportNumber }}" name="numero-soporte" required  type="text" id="travel-number-support" class="validate" />
                    <label for="travel-number-support">Numero de Soporte*</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>

<!-- TITLES ADDRESS DATA -->
                <div class="col s12 m12 l12 lx12">
                    <h5 class="left" >Datos de Dirección</h5>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{  json_decode( $travelWk->address, true)[0]['address'] }}" name="travel-direction" required type="text" id="travel-direction" class="validate" />
                    <label for="travel-direction">Dirección *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{  json_decode( $travelWk->address, true)[0]['addressNumber'] }}" name="travel-number" required type="number" id="travel-number" class="validate" />
                    <label for="travel-number">Número *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
               <div class="input-field col s12 m6 l6 lx6">
                    <select class="select-materialize" id="country-select-adrress">
                        <option class="option-label-select-materialize" disabled value="">País</option>
                        <option value="{{  isset(json_decode( $travelWk->address, true)[0]['country']) ? json_decode( $travelWk->address, true)[0]['country'] : ''}}" disabled selected>{{ isset(json_decode( $travelWk->address, true)[0]['country']) ? json_decode( $travelWk->address, true)[0]['country'] : 'Pais'}}</option>
                        @foreach ($allCountry as $country)
                            <option value="{{$country['name']}}">{{$country['name']}}</option>
                        @endforeach
                    </select>
                    <label class="label-select-materialize">Pais *</label>
                </div>  
                    
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{  json_decode( $travelWk->address, true)[0]['addressMunicipality'] }}" name="travel-address-municipality" required type="text" id="travel-address-municipality" class="validate" />
                    <label for="travel-address-municipality">Municipio *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{  json_decode( $travelWk->address, true)[0]['addressProvince'] }}" name="travel-province" type="text" id="travel-province" class="validate" />
                    <label for="travel-province">Província *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="{{ $travelWk->postalCode }}"  name="travel-code-postal" required type="text" id="travel-code-postal" class="validate" />
                    <label for="travel-code-postal">Codigo Postal*</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
<!-- OTHER DATA -->
                <div class="col s12 m12 l12 lx12">
                    <h5 class="left" >Otros Datos</h5>
                </div>
                <div class="input-field col s6 m4 l4 lx4">
                    <input value="{{ $travelWk->entryDate }}" name="entry-date-hotel" type="date" required id="travel-entry-date-hotel" class="validate" />
                    <label for="travel-entry-date-hotel">Fecha de Entrada *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s6 m4 l4 lx4">
                    <input name="final-date-hotel" type="date"value="{{ $travelWk->finalDate }}" required id="travel-final-date-hotel" class="validate" />
                    <label for="travel-final-date-hotel">Fecha de Salida *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s6 m6 l4 lx4">
                    <select id="travel-method-of-payment">
                        <option class="option-label-select-materialize" disabled value="">Forma de pago</option>
                        <option value="{{$travelWk->methodOfPayment}}" selected disabled>{{$travelWk->methodOfPayment}}</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                    <label class="label-select-materialize">Forma de Pago</label>
                </div>
                <div class="input-field col s12 m12 l12 lx12 left">
                    <label>
                        <input id="travel-fature-data-checkbox" {{ $travelWk->travelFatureData == 0 ? '' : 'checked' }} type="checkbox" />
                        <span>Desea facturación</span>
                    </label>
                </div>
                <div  id="div-travel-fature-data-ask-checkbox" class="input-field col s12 m12 l12 lx12 left">
                    <label>
                        <input id="travel-fature-data-ask-1" type="checkbox" {{ $travelWk->usePersonalDataInInvoice == 0 ? '' : 'checked' }}/>
                        <span>Desea Usar Sus datos</span>
                    </label>
                </div>
                
                
                <div class="col s12 m12 l12 lx12" id="div-travel-fature-data-form">
                    <div class="input-field col s12 m6 l6 lx6">
                        <input  value="{{$travelWk->nameResponsibleToBilling}}" name="name-responsible-to-billing"  type="text" id="name-responsible-to-billing" required class="validate" />
                        <label for="name-responsible-to-billing">Nombre Responsable *</label>
                    </div>
                
                    <div class="input-field col s6 m6 l6 lx6">
                        <select id="travel-type-of-entity-fiscal">
                            <option class="option-label-select-materialize" disabled value="">Tipo de Entidad</option>
                            @if ($travelWk->typeOfEntity == 'PF')
                                <option value="PF" selected>Persona fisica</option>
                                <option value="PJ">Empresa</option>
                            @else
                                <option value="PF">Persona fisica</option>
                                <option value="PJ" selected>Empresa</option>
                            @endif
                           
                        </select>
                        <label class="label-select-materialize">Tipo de Entidad</label>
                    </div>
                    <div id="div-travel-cif" class="input-field col s12 m6 l6 lx6">
                        <input  value="{{ $travelWk->documentOfEntity }}" name="travel-CIF" required type="text" id="travel-document-cif" class="validate" />
                        <label for="travel-document-cif">CIF*</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div id="div-travel-document-nif" class="input-field col s12 m6 l6 lx6">
                        <input value="{{ $travelWk->documentOfEntity }}" name="travelNIF" required type="text" id="travel-document-fature-nif" class="validate" />
                        <label for="travel-document-fature-nif">NIF*</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{  json_decode( $travelWk->address, true)[0]['address'] }}" name="travel-address-feature" required type="text" id="travel-address-fature" class="validate" />
                        <label for="travel-address-fature">Dirección *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input  value="{{  json_decode( $travelWk->address, true)[0]['addressNumber'] }}" name="travel-fature-number" required type="number" id="travel-fature-number" class="validate" />
                        <label for="travel-fature-number">Número *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    addressNumber
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{  json_decode( $travelWk->address, true)[0]['addressMunicipality'] }}" name="travel-fature-address-municipality" required type="text" id="travel-fature-address-municipality" class="validate" />
                        <label for="travel-fature-address-municipality">Municipio *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{  json_decode( $travelWk->address, true)[0]['addressProvince'] }}" name="travel-fature-province" required type="text" id="travel-fature-province" class="validate" />
                        <label for="travel-fature-province">Província *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{ $travelWk->postalCodeOfFacture }}" name="travelPostalCodeDataFature" required  type="text" id="travel-postal-code-fature-1" class="validate" />
                        <label for="travel-postal-code-fature1">Codigo postal *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                </div>

<!-- E-FIRMA  -->
            <div class="col s12 m12 l12 lx12" style="margin-top:4em;">
                    <h5 class="left" >Firmar</h5>
            </div>
            <div class="col s12 m12 l12 lx12"style="margin-top:2em;" >
                <!-- <div class="contenedor"> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-12">
                            <canvas id="draw-canvas">
                                No tienes un buen navegador.
                            </canvas>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
                <!-- <div class="row"> -->
                    <!-- <div class="col-md-12"> -->
                        <a class="btn waves-effect waves-light button" id="draw-submitBtn" style="background-color: var(--color-button);">Ok
                            <i class="material-icons right">send</i>
                        </a>
                        <a class="btn waves-effect waves-light button"  id="draw-clearBtn" style="color: black; background-color: var(--color-button-error);">Borrar firma
                            <i class="material-icons right">backspace</i>
                        </a>
                    <!-- </div> -->
                <!-- </div> -->
            </div>

        </div>   
<!-- BUTTON TO SAVE -->
            <div class="row center-align" style="margin-top:3em;">
                <a class="btn waves-effect waves-light" onclick="sendForm()" style="background-color: var(--color-button);">Entrar
                    <i class="material-icons right">send</i>
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>

         var eFirma = '{{ $travelWk->eFirma }}';

         // Verifica si eFirma ya tiene una imagen guardada
        
      
        /*
		El siguiente codigo en JS Contiene mucho codigo
		de las siguietes 3 fuentes:
		https://stipaltamar.github.io/dibujoCanvas/
		https://developer.mozilla.org/samples/domref/touchevents.html - https://developer.mozilla.org/es/docs/DOM/Touch_events
		http://bencentra.com/canvas/signature/signature.html - https://bencentra.com/code/2014/12/05/html5-canvas-touch-events.html
*/

    (function() { // Comenzamos una funcion auto-ejecutable
        // Obtenenemos un intervalo regular(Tiempo) en la pamtalla
        window.requestAnimFrame = (function (callback) {
            return window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        window.msRequestAnimaitonFrame ||
                        function (callback) {
                            window.setTimeout(callback, 1000/60);
                // Retrasa la ejecucion de la funcion para mejorar la experiencia
                        };
        })();

        // Traemos el canvas mediante el id del elemento html
        var canvas = document.getElementById("draw-canvas");
        var ctx = canvas.getContext("2d");
        if (eFirma && eFirma !== '') {
            cargarImagenEnCanvas(eFirma);
        }
  // Función para cargar imagen en el canvas sin bloquear la edición
        function cargarImagenEnCanvas(dataUrl) {
            var img = new Image();
            img.onload = function() {
                // Dibuja la imagen en el canvas sin limpiar lo que se dibuje después
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            }
            img.src = dataUrl;
        }

        // Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
        //var drawText = document.getElementById("draw-dataUrl");
        //var drawImage = document.getElementById("draw-image");
        var clearBtn = document.getElementById("draw-clearBtn");
        var submitBtn = document.getElementById("draw-submitBtn");
        clearBtn.addEventListener("click", function (e) {
            // Definimos que pasa cuando el boton draw-clearBtn es pulsado
            clearCanvas();
            eFirma = null;
        //   drawImage.setAttribute("src", "");
        }, false);
            // Definimos que pasa cuando el boton draw-submitBtn es pulsado
        submitBtn.addEventListener("click", function (e) {
        var dataUrl = canvas.toDataURL();
        eFirma = dataUrl;
        //drawText.innerHTML = dataUrl;
        //drawImage.setAttribute("src", dataUrl);
        }, false);

        // Activamos MouseEvent para nuestra pagina
        var drawing = false;
        var mousePos = { x:0, y:0 };
        var lastPos = mousePos;
        canvas.addEventListener("mousedown", function (e)
        {
        /*
        Mas alla de solo llamar a una funcion, usamos function (e){...}
        para mas versatilidad cuando ocurre un evento
        */
            var tint = '#000000';
            var punta = 1;
            console.log(e);
            drawing = true;
            lastPos = getMousePos(canvas, e);
        }, false);
        canvas.addEventListener("mouseup", function (e)
        {
            drawing = false;
        }, false);
        canvas.addEventListener("mousemove", function (e)
        {
            mousePos = getMousePos(canvas, e);
        }, false);

        // Activamos touchEvent para nuestra pagina
        canvas.addEventListener("touchstart", function (e) {
            mousePos = getTouchPos(canvas, e);
        console.log(mousePos);
        e.preventDefault(); // Prevent scrolling when touching the canvas
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchend", function (e) {
        e.preventDefault(); // Prevent scrolling when touching the canvas
            var mouseEvent = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchleave", function (e) {
        // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
        e.preventDefault(); // Prevent scrolling when touching the canvas
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchmove", function (e) {
        e.preventDefault(); // Prevent scrolling when touching the canvas
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);

        // Get the position of the mouse relative to the canvas
        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
        /*
        Devuelve el tamaño de un elemento y su posición relativa respecto
        a la ventana de visualización (viewport).
        */
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        // Get the position of a touch relative to the canvas
        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
        console.log(touchEvent);
        /*
        Devuelve el tamaño de un elemento y su posición relativa respecto
        a la ventana de visualización (viewport).
        */
            return {
                x: touchEvent.touches[0].clientX - rect.left, // Popiedad de todo evento Touch
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        // Draw to the canvas
        function renderCanvas() {
            if (drawing) {
        var tint = '#000000';
        var punta = 1;
        ctx.strokeStyle = tint;
        ctx.beginPath();
                ctx.moveTo(lastPos.x, lastPos.y);
                ctx.lineTo(mousePos.x, mousePos.y);
        console.log(punta.value);
            ctx.lineWidth = punta.value;
                ctx.stroke();
        ctx.closePath();
                lastPos = mousePos;
            }
        }

        function clearCanvas() {
            canvas.width = canvas.width;
        }

        // Allow for animation
        (function drawLoop () {
            requestAnimFrame(drawLoop);
            renderCanvas();
        })();

    })();


    var  travelFatureDataSaved = '{{ $travelWk->travelFatureData == 0 ? false :true }}';
    var usePersonalDataInInvoiceSaved ='{{ $travelWk->usePersonalDataInInvoice == 0 ? false :true}}';
    var selectedTypeEntity = '{{ $travelWk->typeOfEntity}}';
    var divtraveNIF = document.getElementById("div-travel-document-nif");
    var divtraveCIF = document.getElementById("div-travel-cif");
    var divParentescoAlojamiento = document.getElementById("div-parentesco-alojamiento");
    var divNumeroSoporte1 = document.getElementById("div-numero-soporte");
    if(selectedTypeEntity == "PJ"){
        divtraveNIF.style.display = "none";
        document.getElementById("travel-document-fature-nif").value = '';
        divtraveCIF.style.display = "block";
    }else{
        divtraveCIF.style.display = "none";
        document.getElementById("travel-document-cif").value = '';
        divtraveNIF.style.display = "block";    
    }

    if(esMenorDe18(document.getElementById("travel-fecha-de-nacimiento").value)){
        divParentescoAlojamiento.style.display = "block";
    }else{
        divParentescoAlojamiento.style.display = "none";
        document.getElementById('travel-parentesco-alojamiento').value = '';
    }

      
    if(document.getElementById("travel-type-of-documents").value == 'Pasaporte'){
        divNumeroSoporte1.style.display = "none";
    }else{
        divNumeroSoporte1.style.display = "block";
    }   

    document.getElementById("travel-fature-data-checkbox").checked = travelFatureDataSaved;
    document.getElementById("travel-fature-data-ask-1").checked = usePersonalDataInInvoiceSaved;
    document.addEventListener('DOMContentLoaded', function() {
    // INITIAL SELECT
        initialSelectMaterialize();
// VERIFY IF DATA INVOICE
        var divTravelFatureDataAskForm1 = document.getElementById('div-travel-fature-data-form');
        var divTravelFatureDataAsk1 = document.getElementById('div-travel-fature-data-ask-checkbox');
        var checkboxFatureData = document.getElementById('travel-fature-data-ask-1');
        if(travelFatureDataSaved){
            divTravelFatureDataAsk1.style.display = 'block';
            if(!checkboxFatureData.checked){
                divTravelFatureDataAskForm1.style.display = 'block';
            }  
        }else{
            divTravelFatureDataAsk1.style.display = 'none';
            divTravelFatureDataAskForm1.style.display = 'none';
        }

        if(usePersonalDataInInvoiceSaved){
            divTravelFatureDataAskForm1.style.display = 'none';
        }else{
            divTravelFatureDataAskForm1.style.display = 'block';  
        }

// VERIFY TRAVELS INVOICE
        document.getElementById("travel-fature-data-checkbox").addEventListener("change", function() {
            divTravelFatureDataAskForm1 = document.getElementById('div-travel-fature-data-form');
            divTravelFatureDataAsk1 = document.getElementById('div-travel-fature-data-ask-checkbox');
            checkboxFatureData = document.getElementById('travel-fature-data-ask-1');
            if (this.checked) {
                divTravelFatureDataAsk1.style.display = 'block';
                if(!checkboxFatureData.checked){
                    divTravelFatureDataAskForm1.style.display = 'block';
                }  
            } else {
                divTravelFatureDataAsk1.style.display = 'none';
                divTravelFatureDataAskForm1.style.display = 'none';
            }
        });
        document.getElementById("travel-fature-data-ask-1").addEventListener("change", function() {
            const  divTravelFatureDataAskForm1 = document.getElementById('div-travel-fature-data-form');
            if (this.checked) {
                divTravelFatureDataAskForm1.style.display = 'none';
            } else {
                divTravelFatureDataAskForm1.style.display = 'block';  
            }
        });




// CHANGE INPUT TO NIF TO CIF
        document.getElementById("travel-type-of-entity-fiscal").addEventListener("change", function() {
            if(this.value == "PJ"){
                divtraveNIF.style.display = "none";
                document.getElementById("travel-document-fature-nif").value = '';
                divtraveCIF.style.display = "block";
            }else{
                divtraveCIF.style.display = "none";
                document.getElementById("travel-document-cif").value = '';
                divtraveNIF.style.display = "block";    
            }
        });

        
        document.getElementById("travel-fecha-de-nacimiento").addEventListener("change", function() {
            divParentescoAlojamiento = document.getElementById("div-parentesco-alojamiento");
            if(esMenorDe18(this.value)){
                divParentescoAlojamiento.style.display = "block";
            }else{
                divParentescoAlojamiento.style.display = "none";
                document.getElementById('travel-parentesco-alojamiento').value = '';
            }
        });

// VERIFY TYPE OF DOCUMENTS
        document.getElementById("travel-type-of-documents").addEventListener("change", function() {
            const divNumeroSoporte1 = document.getElementById("div-numero-soporte");
            if(this.value == 'Pasaporte'){
                divNumeroSoporte1.style.display = "none";
            }else{
                divNumeroSoporte1.style.display = "block";
            }
        });        

    });




       



        /*
         * Send comment  and save in server
         * @author SGV
         * @version 1.0 - 20230215 - initial release
         * @return <HTML>
         **/
        function sendForm(){
            var isUser = "{{Session::has('user')}}";
            if(!isUser){
                if(!document.getElementById('information-validated').checked){
                    showToastComponent("Por favor confirme que las informaciones son verdaderas", null ,'error');
                    return; 
                }
                if(!document.getElementById('politic-and-privacity').checked){
                    showToastComponent("Por favor confirme que esta ciente de las politicas y privacidad", null ,'error');
                    return; 
                }
            }
            let firstName = document.getElementById('travel-name').value.trim();
            let subName = document.getElementById('travel-apellido').value.trim();
            let lastName = document.getElementById('travel-do-apellido').value.trim();
            let countrySelected = document.getElementById("country-selector").value.trim();
            // let typeOfContact = document.getElementById("travel-type-of-contact-1").value.trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let email = document.getElementById('travel-email-address').value.trim();
            let contactPhoneNumber = document.getElementById("travel-phone").value;
            let sex = document.getElementById('travel-sex').value.trim(); 
            let birthdate = document.getElementById("travel-fecha-de-nacimiento").value.trim();
            let kinshipLodging = document.getElementById('travel-parentesco-alojamiento').value.trim();
            let typeOfDocuments = document.getElementById('travel-type-of-documents').value.trim();
            let documentNumber = document.getElementById('travel-numero-documento').value.trim();  
            let dateExpedition = document.getElementById('travel-fecha-de-expedicion').value.trim();  
            let suportNumber = document.getElementById('travel-number-support').value.trim();  
            let address = document.getElementById('travel-direction').value.trim();  
            let addressNumber = document.getElementById('travel-number').value.trim();  
            let addressMunicipality = document.getElementById('travel-address-municipality').value.trim(); 
            let addressProvince =  document.getElementById('travel-province').value.trim();   
            let postalCode = document.getElementById('travel-code-postal').value.trim();  
            let entryDate = document.getElementById('travel-entry-date-hotel').value.trim(); 
            let finalDate = document.getElementById('travel-final-date-hotel').value.trim(); 
            let methodOfPayment = document.getElementById('travel-method-of-payment').value.trim(); 
            let typeOfEntity = document.getElementById('travel-type-of-entity-fiscal').value.trim();  
            let postalCodeOfFacture = document.getElementById('travel-postal-code-fature-1').value.trim();  
            let addressOfFacture = document.getElementById('travel-address-fature').value.trim(); 
            let travelFatureAddressNumber = document.getElementById('travel-fature-number').value.trim();
            let travelFatureAddressMunicipality = document.getElementById('travel-fature-address-municipality').value.trim(); 
            let travelFatureAddressProvince = document.getElementById('travel-fature-province').value.trim();  
            let nameResponsibleToBilling = document.getElementById('name-responsible-to-billing').value.trim();  
            let changeDataOfFature = document.getElementById('travel-fature-data-ask-1'); 
            let travelCif1 = document.getElementById('travel-document-cif').value.trim(); 
            let travelNif1 = document.getElementById('travel-document-fature-nif').value.trim(); 
            let documentOfEntity = typeOfEntity == 'PF' ? travelNif1:travelCif1;
            let travelFatureData = document.getElementById('travel-fature-data-checkbox').checked ? 1 : 0;
            let usePersonalDataInInvoice = document.getElementById('travel-fature-data-ask-1').checked ? 1 : 0;
            let countrySelectAdrress = document.getElementById('country-select-adrress').value.trim();
            // if(typeOfContact == 'email'){
                if (email != null) {
                    if (!emailRegex.test(email)) {
                        showToastComponent("Correo electronico invalido", null ,'error');
                        return; 
                    }
                }else{
                    showToastComponent("Por favor colocar un correo electronico valido", null ,'error');
                    return; 
                }
                if (!firstName) {
                 showToastComponent("Por favor ingresar un nombre", null ,'error');
                return;  
            }
            if (!subName) {
                 showToastComponent("Por favor ingresar un 1º apellido valido", null ,'error');
                return;  
            }
            // if (!lastName) {
            //      showToastComponent("Por favor ingresar un 2º apellido valido", null ,'error');
            //     return;  
            // }
            
            if (!countrySelected) {
                showToastComponent("Por favor seleccione su pais", null ,'error');
                return;  
            }
            if (!sex) {
                showToastComponent("Por favor seleccione genero", null ,'error');
                return;  
            }
            if(!birthdate){
                showToastComponent("Por favor coloque una fecha de nacimiento valida", null ,'error');
                return;  
            }
            if(!esMenorDe18(birthdate)){
                kinshipLodging = '';
            }else{
                if(!kinshipLodging){
                    showToastComponent("Por favor coloque parentesco", null ,'error');
                    return;    
                }
            }
            if(typeOfDocuments == 'Pasaporte'){
                suportNumber = '';
            }else{
                if(!suportNumber){
                    showToastComponent("Por favor coloque Número de soporte valido", null ,'error');
                    return;  
                }
            }
            if(!documentNumber){
                showToastComponent("Por favor coloque Número de documento valido", null ,'error');
                return;  
            }
            if(!dateExpedition){
                showToastComponent("Por favor coloque fecha de expedición valida", null ,'error');
                return;  
            }
            if(!address){
                showToastComponent("Por favor coloque dirección valida", null ,'error');
                return;  
            }
            if(!addressNumber){
                showToastComponent("Por favor coloque Número valido", null ,'error');
                return;  
            }
            if(!countrySelectAdrress){
                showToastComponent("Campo de pais es obligatorio", null ,'error');
                return;
            }
            if(!addressMunicipality){
                showToastComponent("Por favor coloque un Municipio valido", null ,'error');
                return;  
            }
            if(!addressProvince){
                showToastComponent("Por favor coloque una Provincia valida", null ,'error');
                return;  
            }
            
            if(!postalCode){
                showToastComponent("Por favor coloque un codigo postal valido", null ,'error');
                return;  
            }
            if(!entryDate){
                showToastComponent("Por favor coloque una fecha de entrada valida", null ,'error');
                return;  
            }
            if(!finalDate){
                showToastComponent("Por favor coloque una fecha de salida valida", null ,'error');
                return;   
            }
            var mydateInitial = new Date(entryDate);
            const initialDate = normalizeDate(mydateInitial);
            var mydatefinal = new Date(finalDate);
            const validateFinalDate = normalizeDate(mydatefinal);
            // Verificar si ambas fechas son válidas
            if (!isNaN(initialDate.getTime()) && !isNaN(validateFinalDate.getTime())) {
                // Validar que la fecha inicial no sea mayor que la final
                if (initialDate > validateFinalDate) {
                    showToastComponent("Fecha inicial no puede ser mayor que fecha de salida", null ,'error');
                    return;   
                } 
            }


            if(document.getElementById('travel-fature-data-checkbox').checked){
                if(changeDataOfFature.checked){
                    addressOfFacture = '';
                    postalCodeOfFacture = '';
                    typeOfEntity = '';
                    documentOfEntity = '';
                    travelFatureAddressNumber ='';
                    travelFatureAddressMunicipality ='';
                    travelFatureAddressProvince = '';
                    nameResponsibleToBilling ='';
                }else{
                    if(!document.getElementById('travel-fature-data-ask-1').checked){
                        if(!nameResponsibleToBilling){
                            showToastComponent("Por favor coloque el nombre responsable de factura valido", null ,'error');
                            return;
                        }
                        if(!addressOfFacture){
                            showToastComponent("Por favor coloque una dirección valida", null ,'error');
                            return;
                        }
                        if(!postalCodeOfFacture){
                            showToastComponent("Por favor coloque un codigo postal valido", null ,'error');
                            return;
                        }
                        if(!typeOfEntity){
                            showToastComponent("Por favor coloque un tipo de entidad valida", null ,'error');
                            return;
                        }
                        if(!documentOfEntity){
                            let nameOfTypeEntity = typeOfEntity == 'PF' ? 'NIF' : 'CIF';
                            showToastComponent("Por favor coloque un número de" +nameOfTypeEntity+ "valida", null ,'error');
                            return;
                        }
                        if(!travelFatureAddressNumber){
                            showToastComponent("Por favor Colocar un Número valido", null ,'error');
                            return;
                        }
                        if(!travelFatureAddressMunicipality){
                            showToastComponent("Por favor Colocar un Municio valido", null ,'error');
                            return;
                        }
                        if(!travelFatureAddressProvince){
                            showToastComponent("Por favor Colocar una Província valida", null ,'error');
                            return;
                        }
                        
                    }
                }
            }
          
            if(!methodOfPayment){
                showToastComponent("Por favor coloque un tipo de metodo de pago valido", null ,'error');
                return;
            }
            if(!eFirma){
                showToastComponent("Por favor colocar su firma", null ,'error');
                return;
            }

            const url = "{{route('editTravel', ['useruuid'=>Session::get('user')->uuid, 'traveluuid'=>$travelWk->uuid]) }}";
            let fullAddress = [{
                "address": address,
                "addressNumber": addressNumber,
                "addressMunicipality": addressMunicipality,
                "addressProvince":addressProvince,
                "country":countrySelectAdrress
            }]
            
            let fullAddressFature = [{
                "address": addressOfFacture,
                "addressNumber": travelFatureAddressNumber,
                "addressMunicipality": travelFatureAddressMunicipality,
                "addressProvince":travelFatureAddressProvince
            }]
            let jsonFullAddress = JSON.stringify(fullAddress);
            let jsonFullAddressFature = JSON.stringify(fullAddressFature);
            const formData = new FormData();
            formData.append('uuid', '{{ $travelWk->uuid }}');
            formData.append('firstName', firstName);
            formData.append('subName', subName);
            formData.append('lastName', lastName);
            formData.append('phoneNumber', contactPhoneNumber);
            formData.append('emailAddress', email);
            formData.append('sex', sex);
            formData.append('typeDocument', typeOfDocuments);
            formData.append('documentNumber', documentNumber);
            formData.append('suportNumber', suportNumber);
            formData.append('dateExpedition', dateExpedition);
            formData.append('birthdate', birthdate);
            formData.append('countrySelected', countrySelected);
            formData.append('kinshipLodging', kinshipLodging);
            formData.append('address', jsonFullAddress);
            formData.append('postalCode', postalCode);
            formData.append('entryDate', entryDate);
            formData.append('finalDate',finalDate);
            formData.append('methodOfPayment', methodOfPayment);
            formData.append('typeOfEntity', typeOfEntity);
            formData.append('addressOfFacture', jsonFullAddressFature);
            formData.append('postalCodeOfFacture', postalCodeOfFacture);
            formData.append('documentOfEntity', documentOfEntity);
            formData.append('nameResponsibleToBilling', nameResponsibleToBilling);
            formData.append('status', "pending");
            formData.append('eFirma', eFirma);
            formData.append('isTrash', 0);
            formData.append('travelFatureData',travelFatureData);
            formData.append('usePersonalDataInInvoice',usePersonalDataInInvoice);
            
            ajaxRequest(url, "POST", formData, onSuccess, onError);
        }
        /*
         * Success ajax request and get cards of comments
         * @author SGV
         * @version 1.0 - 20230215 - initial release
         * @param <obj> response of server
         * @return <HTML>
         **/
        function onSuccess(response) {
            console.log(response);
            showToastComponent("Parte de registro de viajero creado con suceso", null,null);
            window.location = "{{ Session::has('user') ? route('travelerRegistration',  Session::get('user')['uuid']) : route('pageSuccessRegisterTravel') }}";
            return; 
        }

         // Callback de error
         function onError(status, textStatus, errorThrown, response) {
            // console.log(status,textStatus, errorThrown, response);
            showToastComponent("<?php echo  ucfirst('error sending information, please try again later'); ?>", null,'error');
            return; 
        }
    </script>
@endpush

