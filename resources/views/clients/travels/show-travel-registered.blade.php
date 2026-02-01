@extends('main')
@section('showSearch', false)

@section('title', 'Datos de Viajero')
<style>
   .main-data-to-invoice{
    display: flex;
    align-items: center;
    display: flex; 
    border: 2px solid #000; 
    padding:0em !important;
    border-top: none; 
    border-right: none;
   }
    .auto-size-text {
        display: inline-block;
        text-align: center;
        transition: font-size 0.3s;
    }
    .border-radius-custon-left-rigth{
        border-left: 2px solid #000;
        border-right: 2px solid #000;
        padding: 0em !important;
    }
    .body-invoice{
        width:100%; 
        border-bottom: 2px solid #000; 
        
    }
    .border-radius-custon-top-bottom{
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
        padding: 0em !important;
    }
    .border-radius-custon-left-rigth-body{
        border-left: 2px solid #000;
        border-right: 2px solid #000;
        border-bottom: 2px solid #000;
    }
    .body-footer{
        border-left: 2px solid #000;
        border-right: 2px solid #000;
        padding: 0em !important;
    }

    .body-footer-left{
        border-right: 2px solid #000;
        border-bottom: 2px solid #000;

    }
    .body{
        border-bottom: 2px solid #000; 
    }    
</style>
@section('content')
    <section class="section section-stats center">
        <div class="container">
            <div id="contentPDF" class="row">
                <div class="col s12 m12 l12 lx12" style="border: 2px solid #000; border-bottom: none;">
                    <h6 class="auto-size-text">Parte de viajeros Hostal ** Cielo De Cebreros</h6>
                </div>
                <div class="col s12 m12 l12 lx12" style="border: 2px solid #000;">
                    <h6 class="auto-size-text">Antonio Ruiz Muñoz. 50301330P</h6>
                </div>
<!-- DATOS DE FACTURA -->
                @if ($travel->travelFatureData)
                    <div class="col s12 m12 l12 lx12 main-data-to-invoice"> 
                        <div class="col s12 m6 l6 lx6 data-invoice">
                            <span class="auto-size-text" >Datos de facturación</span> 
                        </div>
                        <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth">
                            <div class="col s12 body-invoice">
                                <span class="auto-size-text">{{strtoupper($travel->nameResponsibleToBilling)  }}</span>
                            </div>
                            <div class="col s12 body-invoice">
                                    <span class="auto-size-text">{{$travel->typeOfEntity == 'PJ' ? 'CIF'.$travel->documentOfEntity :'NIF'.$travel->documentOfEntity }}</span>
                            </div>
                            <div class="col s12 body-invoice">
                                <span class="auto-size-text">{{strtoupper($travel->formatAddressBilling()) }}</span>
                            </div>
                            <div>
                                <span class="auto-size-text">{{ $travel->postalCodeOfFacture }}</span>  
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12 lx12 border-radius-custon-left-rigth-body">
                    <span class="auto-size-text white-text left">.</span>
                </div>
                @endif
<!-- FECHA -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="auto-size-text left">Fecha de entrada</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{ DateTime::createFromFormat('Y-m-d', $travel->entryDate)->format('d/m/Y')}}</span>
                </div>
<!-- PAIS -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left  auto-size-text">Pais de nacionalidad</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">{{$travel->countrySelected}}</span>
                </div>
<!-- TIPO DE DOCUMENTO -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text">Tipo de documento</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">{{ strtoupper($travel->typeDocument)}}</span>
                </div>
<!-- NUMERO DE DOCUMENTO -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Número de documento</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">{{$travel->documentNumber}}</span>
                </div>
<!-- NUMERO DE SOPORTE -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Número de soporte</span>
                </div>
                @if ($travel->suportNumber)
                    <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text">{{$travel->suportNumber}}</span>
                    </div>
                @else
                    <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text white-text">.</span>
                    </div>
                @endif
               
                
<!-- FECHA DE EXPEDICION -->
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Fecha de expedición</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text auto-size-text" >{{ DateTime::createFromFormat('Y-m-d', $travel->dateExpedition )->format('d/m/Y')}}</span>
                </div>
<!-- FECHA DE NACIMIENTO -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Fecha de nacimiento</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{ DateTime::createFromFormat('Y-m-d', $travel->birthdate )->format('d/m/Y')}}</span>
                </div>
<!-- NOMBRE -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Nombre</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{strtoupper($travel->firstName)}}</span>
                </div>
<!-- 1ER APELLIDO -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">1º Apellido</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{ strtoupper($travel->subName)}}</span>
                </div>
<!-- 2DO APELLIDO -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">2º Apellido</span>
                </div>
                @if($travel->lastName != null)
                    <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text" >{{strtoupper($travel->lastName)}}</span>
                    </div>
                @else
                    <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text white-text" >.</span>
                    </div>
                @endif
<!-- SEXO -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Sexo</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{ $travel->sex}}</span>
                </div>
<!-- DIRECCION -->
                <div class="col s12 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Dirección</span>
                </div>
                <div class="col s12 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{strtoupper($travel->formatAddress())}}</span>
                </div>
<!-- CODIGO POSTAL -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Codigo postal</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{ $travel->postalCode}}</span>
                </div>
<!-- NUMERO DE CELULAR -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Número de telefono</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    
                    <span class="left auto-size-text" >{{ $travel->phoneNumber ??'.'}}</span>
                </div>
<!-- EMAIL -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Email</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{strtoupper($travel->emailAddress)}}</span>
                    
                </div>
<!-- PARENTESCO -->
                @if ($travel->kinshipLodging)
                    <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text">Parentesco Alojamiento</span>
                    </div>
                    <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                        <span class="left auto-size-text" >{{strtoupper($travel->kinshipLodging)}}</span>
                    </div>
                @endif
                
<!-- FORMA DE PAGAMENTO -->
                <div class="col s6 m6 l6 lx6  border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text">Forma de pagamento</span>
                </div>
                <div class="col s6 m6 l6 lx6 border-radius-custon-left-rigth-body">
                    <span class="left auto-size-text" >{{strtoupper($travel->methodOfPayment)}}</span>
                </div>
<!-- IMG AND PARTE DE VIAJERO -->
                <div class="col s12 m6 l8 lx8 body-footer" style="padding: 0em;"> 
                    <div class="col s12 m12 l12 lx12" style="padding: 0em;">
                        <div class="col s7 m7 l7 lx7 body-footer-left">
                            <span class="left auto-size-text" >Parte N°</span>
                        </div>
                        <div class="col s5 m5 l5 lx5 body">
                            <span class="left auto-size-text">{{ $travel->npart }}</span>
                        </div>
                        <div class="col s6 m6 l7 lx7 body-footer-left">
                            <span class="left auto-size-text" >N° Noches</span>
                        </div>
                        <div class="col s5 m5 l5 lx5 body">
                            <span class="left auto-size-text">{{ $travel->calculateDaysBetween() }}</span>
                        </div>
                        <div class="col s6 m6 l7 lx7 body-footer-left">
                        <span class="left auto-size-text">Hospederia</span>
                        </div>
                        <div class="col s5 m5 l5 lx5 body">
                            <span class="left auto-size-text">.</span>
                        </div>
                        <div class="col s6 m6 l7 lx7 body-footer-left">
                            <span class="left auto-size-text">Facturado</span>
                        </div>
                        <div class="col s5 m5 l5 lx5 body">
                            <span class="left auto-size-text">.</span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4 lx4" style="border: dashed;">
                    <span class="left" >Firma</span>
                    <img style="width: 100%;" src="{{ $travel->eFirma}}" alt="">   
                </div>
            </div>
        </div>
        <h3> Descargar </h3>
        <a class="btn waves-effect waves-light button"  onclick="showTravel()" style="background-color: var(--color-button);">PDF
            <i class="material-icons right">unarchive</i>
        </a>
        <a class="btn waves-effect waves-light button"  onclick="convertAndDownloadXML()" style="background-color: var(--color-button);">XML
            <i class="material-icons right">unarchive</i>
        </a>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function ajustarTextos() {
            var textos = document.querySelectorAll(".auto-size-text");
            textos.forEach(function(texto) {
                var nuevoTamano = window.innerWidth / 20; // Ajusta el divisor según tu necesidad
                if (nuevoTamano < 12) nuevoTamano = 12; // Tamaño mínimo
                if (nuevoTamano > 16) nuevoTamano = 16; // Tamaño máximo
                texto.style.fontSize = nuevoTamano + "px";
            });
        }

        window.addEventListener("resize", ajustarTextos);
        ajustarTextos(); // Ejecuta al cargar la página
        
        function showTravel(){
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            html2canvas(document.getElementById('contentPDF')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 10, 190, 0);
                doc.save('parte_de_viajero_de_{{$travel->getFullNameToDocument()}}.pdf');
            });
        }


        function convertAndDownloadXML() {
            const url = "{{route('downloadXML', parameters: ['useruuid'=>Session::get('user')->uuid,'traveluuid'=>$travel->uuid]) }}";
            const formData = new FormData();
            formData.append('traveluuid','{{$travel->uuid }}');
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
            console.log('response', response);
            if (response.success === false) {
                showToastComponent(response.message, null,'error');
                return;
            }
            const timestampSeconds = Math.floor(Date.now() / 1000);
            // Si la respuesta es exitosa, descargamos el archivo
            // Supongamos que el backend devuelve la URL del archivo XML generado
            var fileUrl = response.file_url;  // Asumiendo que la respuesta tiene la URL del archivo
            // Crear un enlace de descarga temporal
            var downloadLink = document.createElement('a');
            downloadLink.href = fileUrl;  // Asignamos la URL del archivo
            downloadLink.download = 'parte_de_viajero_{{$travel->firstName}}_'+timestampSeconds+'.xml';  // Nombre del archivo a descargar
            // Simular un clic en el enlace
            document.body.appendChild(downloadLink);  // Añadir el enlace al DOM
            downloadLink.click();  // Hacer clic en el enlace para iniciar la descarga
        }

         // Callback de error
         function onError(status, textStatus, errorThrown, response) {
            // console.log(status,textStatus, errorThrown, response);
            showToastComponent("<?php echo  ucfirst('error sending information, please try again later'); ?>", null,'error');
            return; 
        }

        

    </script>
@endpush
