@extends('main')
@section('showSearch', false)

@section('title', 'Datos de facturación')
@section('content')
    <!-- FORMULARIOS -->
    <!-- <section class="section section-stats center"> -->
    <div class="container">
            <form>
                <div class="row">
                    <div class="col s12 m12 l12 lx12">
                        <h3 class="left" >Registrar Datos de factura</h3>
                    </div>
                    <div class="col s12 m12 l12 lx12">
                        <h6 class="left" >Todos los campos con (*) son obligatorios</h6>
                    </div>
                   

<!-- TITLES PERSONAL DATA -->
                    <div class="col s12 m12 l12 lx12">
                        <h5 class="left" >Datos personales</h5>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{$billingDataWk?->name}}" name="name" type="text" id="name" required class="validate" />
                        <label for="name">Nombre *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="footer" value="{{$billingDataWk?->footer}}" required type="text" id="footer" class="validate" />
                        <label for="footer">Pie de página *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="file-field input-field col s6 m12 l5">
                        <div class="btn" style="background-color: var(--color-button);">
                            <span>Logo</span>
                            <input type="file" id="imageInput" required accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                        <div id="image-preview">
                            <img id="previewImage"  src="{{ $billingDataWk? Storage::url($billingDataWk?->photoPath) : '' }}" alt="Vista previa" style="max-width: 100%; display: none; border-radius: 10px; max-width:13em;"/>
                        </div>
                    </div>
<!-- DOCUMENTS DATA -->
                    <div class="col s12 m12 l12 lx12">
                        <h5 class="left" >Datos de documento</h5>
                    </div>
                    <div class="input-field col s6 m6 l6 lx6">
                        <select id="type-of-document">
                            @if ( $billingDataWk?->typeBillingData == 'NIF')
                                <option value="NIF" selected>NIF</option>
                                <option value="CIF">CIF</option>
                            @else
                            <option value="NIF">NIF</option>
                            <option value="CIF" selected>CIF</option>
                            @endif
                                
                        </select>
                        <label>Tipo de documento</label>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input value="{{  $billingDataWk?->documentNumber  }}" name="number-of-document" required type="text" id="number-document" class="validate" />
                        <label for="number-document">Numero de documento *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
<!-- TITLES ADDRESS DATA -->
                    <div class="col s12 m12 l12 lx12">
                        <h5 class="left" >Datos de Dirección</h5>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="address" value="{{  $billingDataWk?->getAddress(isArray:true)['address'] }}" required type="text" id="address" class="validate" />
                        <label for="address">Dirección *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="address-number" required type="number" value="{{  $billingDataWk?->getAddress(isArray:true)['addressNumber'] }}" id="address-number" class="validate" />
                        <label for="address-number">Número *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="address-municipality"value="{{  $billingDataWk?->getAddress(isArray:true)['addressMunicipality'] }}"  required type="text" id="address-municipality" class="validate" />
                        <label for="address-municipality">Municipio *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="address-province"value="{{  $billingDataWk?->getAddress(isArray:true)['addressProvince'] }}" type="text" id="address-province" class="validate" />
                        <label for="address-province">Província *</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="address-code-postal" value="{{ $billingDataWk?->postalCode }}" required type="text" id="address-code-postal" class="validate" />
                        <label for="address-code-postal">Codigo Postal*</label>
                        <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                    </div>

            <!-- </div>    -->
<!-- BUTTON TO SAVE -->
                <div class="row center-align  col s12 m12 l12 lx12" style="margin-top:3em;">
                    <a class="btn waves-effect waves-light" onclick="sendForm()" style="background-color: var(--color-button);">Entrar
                        <i class="material-icons right">send</i>
                    </a>
                </div>
                </div>
            </form>
        </div>
@endsection

@push('scripts')
    <script>
        var reader = new FileReader();
        var base64StringGlobal = '{{ $billingDataWk == null? "" : $billingDataWk?->photoPath }}';
        var extensionOfIMG ='';
        document.addEventListener('DOMContentLoaded', function() {
            var elemsSelect = document.querySelectorAll('select');
            M.FormSelect.init(elemsSelect, {});
            if(base64StringGlobal){
                document.getElementById('previewImage').style.display = 'block';
                document.getElementById('image-preview').style.display = 'flex';
                document.getElementById('image-preview').style.justifyContent = 'center';
            }
            document.getElementById('imageInput').addEventListener('change', function() {
                var file = this.files[0]; // Obtiene el archivo seleccionado
                if (file) {
                    // Verifica si el archivo es una imagen
                    if (!file.type.startsWith('image/')) {
                        showToastComponent("Por favor, selecciona una imagen.", null ,'error');
                        return;
                    }
                    
                    // Obtener la extensión del archivo
                    extensionOfIMG = file.name.split('.').pop();
                    console.log('Extensión de la imagen:', extensionOfIMG); // Muestra la extensión en la consola
                    
                    // Convertir a Base64
                    reader.onloadend = function() {
                        base64StringGlobal = reader.result.split(',')[1]; // Almacena en la variable global
                        console.log('Base64:', base64StringGlobal); // Muestra el Base64 en la consola

                        // Mostrar vista previa de la imagen
                        var preview = document.getElementById('previewImage');
                        let divPreview = document.getElementById('image-preview');
                        preview.src = reader.result;
                        divPreview.style.display = 'flex';
                        divPreview.style.justifyContent = 'center';
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file); // Convierte la imagen a Base64
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
            let footer = document.getElementById('footer').value.trim();
            let typeOfDocuments = document.getElementById('type-of-document').value.trim();
            let documentNumber = document.getElementById('number-document').value.trim(); 
            let name = document.getElementById('name').value.trim();
            let address = document.getElementById('address').value.trim();  
            let addressNumber = document.getElementById('address-number').value.trim();  
            let addressMunicipality = document.getElementById('address-municipality').value.trim(); 
            let addressProvince =  document.getElementById('address-province').value.trim();   
            let postalCode = document.getElementById('address-code-postal').value.trim();

            if(!name){
                showToastComponent("Campo Nombre es Obligatorio", null ,'error');
                return;
            }
            if(!footer){
                showToastComponent("Campo Pie de página es Obligatorio", null ,'error');
                return;
            }
            if(base64StringGlobal == '' || base64StringGlobal == null){
                showToastComponent("Campo de imagen es Obligatorio", null ,'error');
                return;
            }
            if(!documentNumber){
                showToastComponent("Campo Numero de documento es Obligatorio", null ,'error');
                return;  
            }
            if(!address){
                showToastComponent("Campo Dirección es Obligatorio", null ,'error');
                return;  
            }
            if(!addressNumber){
                showToastComponent("Campo Número es Obligatorio", null ,'error');
                return;  
            }
            if(!addressMunicipality){
                showToastComponent("Campo Municipio es Obligatorio", null ,'error');
                return;  
            }
            if(!addressProvince){
                showToastComponent("Campo Província es Obligatorio", null ,'error');
                return;  
            }
            if(!postalCode){
                showToastComponent("Campo codigo postal es Obligatorio", null ,'error');
                return;
            }
            
            const url = "{{$billingDataWk == null ? route('registerBillingData', Session::get('user')->uuid): route('editBillingData', parameters: ['useruuid'=>Session::get('user')->uuid, 'billinguuid'=> $billingDataWk->uuid]) }}";
            let fullAddress = [{
                "address": address,
                "addressNumber": addressNumber,
                "addressMunicipality": addressMunicipality,
                "addressProvince":addressProvince
            }]
            let jsonFullAddress = JSON.stringify(fullAddress);
            const formData = new FormData();
            formData.append('name', name);
            formData.append('footer', footer);
            formData.append('postalCode', postalCode);
            formData.append('photoPath', base64StringGlobal);
            formData.append('address', jsonFullAddress);
            formData.append('typeBillingData',typeOfDocuments);
            formData.append('documentNumber', documentNumber);
            formData.append('extensionOfIMG', extensionOfIMG);
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
            showToastComponent("Parte de registro de viajero creado con suceso", null,null);
            window.location = "{{ Session::has('user') ? route('travelersRegisterHome',  Session::get('user')['uuid']) : route('pageSuccessRegisterTravel') }}";
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
