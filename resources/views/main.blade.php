<!DOCTYPE html>
<html>
@include('clients.components.head', ['title'=>'Registro de Viajeros'])
<style>
    /* label color */
    .input-field label {
        color: #000;
    }

    /* label focus color */
    .input-field input[type=text]:focus+label {
        color: rgb(100, 181, 246) !important;
    }

    /* label underline focus color */
    .input-field input[type=text]:focus {
        border-bottom: 1px solid rgb(100, 181, 246) !important;
        box-shadow: 0 1px 0 0 rgb(100, 181, 246) !important;
    }

    /* valid color */
    .input-field input[type=text].valid {
        border-bottom: 1px solid #000;
        box-shadow: 0 1px 0 0 #000;
    }

    /* invalid color */
    .input-field input[type=text].invalid {
        border-bottom: 1px solid #000;
        box-shadow: 0 1px 0 0 #000;
    }

    /* icon prefix focus color */
    .input-field .prefix.active {
        color: var(--color-button);
    }

    textarea:focus {
        border-bottom: 2px solid var(--color-button);
        box-shadow: 0 1px 0 0 var(--color-button);
    }

    /* Cambia el color del label cuando el input está enfocado */
    input:focus+label {
        color: #000 !important;
    }

    /* Cambia el color del borde y la sombra al hacer clic en el input */
    input:focus {
        border-bottom: 2px solid rgb(100, 181, 246) !important;
        /* Cambia a rojo o cualquier color */
        box-shadow: 0 1px 0 0 rgb(100, 181, 246) !important;
    }

    #div-parentesco-alojamiento {
        display: none;
    }

    #div-document-phone-number {
        display: flex;
    }

    #div-travel-fature-data-ask-checkbox {
        display: none;
    }

    #div-travel-fature-data-form {
        display: none;
        margin-top: 3em;
    }

    #div-travel-cif {
        display: none;
    }

    #draw-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 5px;
        cursor: crosshair;
    }

    #contentPDF-register-travels-empyt {
        display: none;
    }

    #div-travel-address-municipality-select {
        display: none;
    }
</style>

<body >

    @include('clients.components.nav')
<!-- MENU LATERAL -->
    @include('clients.components.menu_lateral')

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- MODAL GENERATE URL TO TRAVEL-->
    <div id="modal-generate-url-travel" class="modal">
        <div class="modal-content">
            <h4>URL Temporario</h4>
            <p>esta url puede ser conpartido para un cliente, tiene vigencia de 2 horas</p>
            <p id="p-input-url-generated"></p>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-red red-text btn-flat">Cancelar</a>
            <a id="copy-button-url-generated" class="waves-effect waves-green btn-flat">Copiar</a>
        </div>
    </div>

     @include('clients.components.loading')
    <!--Import jQuery before materialize.js-->
    @include('clients.components.scripts')

    @if (Session::has('user'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
     

        var modalGenerateUrlTravel;
        document.addEventListener('DOMContentLoaded', function() {
            initialSelectMaterialize();
            var elemsSidenav = document.querySelectorAll('.sidenav');
            M.Sidenav.init(elemsSidenav, {});
            //
            const isiOSSafari = /iP(hone|ad|od)/.test(navigator.platform) && /Safari/.test(navigator.userAgent);
            if (isiOSSafari) {
                document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
                    const dropdownId = trigger.getAttribute('data-target');
                    const menu = document.getElementById(dropdownId);
                    // Construimos un <select> nativo
                    const select = document.createElement('select');
                    select.classList.add('browser-default'); // navegador nativo

                    // Copiamos las opciones del <ul> al <select>
                    menu.querySelectorAll('li a').forEach(a => {
                        const opt = document.createElement('option');
                        opt.value = a.getAttribute('data-value') || a.textContent.trim();
                        opt.text = a.textContent.trim();
                        select.append(opt);
                    });

                    // Reemplazamos el trigger + menú por el <select>
                    trigger.replaceWith(select);
                    menu.remove();

                    // (Opcional) manejar el label flotante:
                    const label = document.querySelector(`label[for="${select.id}"]`);
                    select.addEventListener('change', () => {
                        if (select.value) label.classList.add('active');
                        else label.classList.remove('active');
                    });

                });
            } else {
                $(".dropdown-trigger").dropdown();
            }



            var elemCollapsible = document.querySelectorAll('.collapsible');
            M.Collapsible.init(elemCollapsible, {});

            // INITIAL MODAL
            initalModal();
            var modalElementGenerateUrl = document.querySelector('#modal-generate-url-travel');
            modalGenerateUrlTravel = M.Modal.getInstance(modalElementGenerateUrl);
        });



        function downloadPdfRegisterTravels() {
            document.getElementById('contentPDF-register-travels-empyt').style.display = 'block';
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            html2canvas(document.getElementById('contentPDF-register-travels-empyt')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 10, 190, 0);
                doc.save('parte_de_viajero_de_vacio.pdf');
            });
            document.getElementById('contentPDF-register-travels-empyt').style.display = 'none';
        }

        /*
         * Generate Temporary Url to travel
         * @author SGV
         * @version 1.0 - 20230215 - initial release
         * @param <this> element
         * @return <HTML>
         **/
        function generateTemporaryUrl() {
            const formData = new FormData();
            formData.append('traveluuid', '');
            const url = "{{route('generateTemporaryUrl',Session::get('user')->uuid ) }}";
            ajaxRequest(url, "POST", formData, onSuccessGenerateTemporaryUrl, onErrorGenerateTemporaryUrl);


        }
        // Callback de success
        function onSuccessGenerateTemporaryUrl(response) {
            // Abre el modal
            modalGenerateUrlTravel.open();
            // Selecciona todos los elementos con el ID
            var urlGenereted = document.querySelectorAll('#p-input-url-generated');
            // Recorre todos los elementos seleccionados y actualiza el contenido
            urlGenereted.forEach(function(element) {
                element.innerText = response.url; // Asumiendo que response contiene la URL
            });
            document.getElementById('copy-button-url-generated').addEventListener('click', function() {
                navigator.clipboard.writeText(response.url).then(function() {
                    modalGenerateUrlTravel.close();
                    showToastComponent("URL copiada al portapapeles", null, null);
                }).catch(function(error) {
                    console.error('Error al copiar al portapapeles: ', error);
                });
            });

        }

        // Callback de error
        function onErrorGenerateTemporaryUrl(status, textStatus, errorThrown, response) {
            showToastComponent("Por favor intente generar una url mas tarde o contacte a soporte", null, 'error');
            return;
        }
    </script>
    @endif
    <!-- Scripts Específicos -->
    @stack('scripts')
</body>

</html>