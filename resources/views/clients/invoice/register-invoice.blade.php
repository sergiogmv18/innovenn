@extends('main')
@section('showSearch', false)

@section('title', 'Registrar Viajeros')
<style>
    #div-invoice-coment{
        display: none;
    }
    .option-label-select-materialize{
        display: none;
    }
</style>
@section('content')
<!-- FORMULARIOS -->
    <section class="section section-stats center">
        <div class="container">
            <form>
                <div class="row">
                    <div class="input-field col s12 m6 l6 lx6">
                        <input name="travelName" value="{{$numberOfInvoice}}" disabled type="number" id="travel-name-1" class="validate" />
                        <label for="travel-name-1">Numero *</label>
                    </div>
                    <div class="input-field col s6 m6 l6 lx6">
                        <select id="type-invoice-selected">
                            <option class="option-label-select-materialize" disabled value="">Tipo de Factura</option>
                            <option value="Simplificada" selected>Simplificada</option>
                            <option value="Ordinaria">Ordinaria</option>
                            <option value="Abonadas">Abonadas</option>
                        </select>
                        <label class="label-select-materialize">Tipo de Factura</label>
                    </div> 
                    <div class="input-field col s6 m6 l4 lx4">
                        <select id="travel-uuid-selected">
                            <option class="option-label-select-materialize" value="" disabled selected>Seleccione el viajero</option>
                            @foreach ($allTravels as $travel)
                                <option value="{{$travel->uuid}}">{{$travel->firstName}} {{$travel->subName}} - {{ DateTime::createFromFormat('Y-m-d', $travel->entryDate)->format('d/m/Y')}}</option>
                            @endforeach
                        </select>
                        <label class="label-select-materialize">Viajero</label>
                    </div> 
                    <div class="input-field col s6 m6 l4 lx4">
                        <select id="method-of-payment">
                            <option class="option-label-select-materialize" disabled value="">Forma de Pago</option>
                            <option value="Efectivo" selected>Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                        <label class="label-select-materialize">Forma de Pago</label>
                    </div>
                    <div class="input-field col s6 m6 l4 lx4">
                        <select id="relate-invoice-uuid-selected">
                            <option class="option-label-select-materialize" value="" selected>Seleccione la factura a ser cambiada</option>
                            @foreach ($allInvoices as $invoice)
                                <option value="{{$invoice->uuid}}">{{$invoice->number}}</option>
                            @endforeach
                        </select>
                        <label class="label-select-materialize">Factura a ser cambiada</label>
                    </div> 
                    <div id="div-invoice-coment" class="input-field col s12 m12 l12 lx12">
                        <input name="invoice-coment" type="text" id="invoice-coment" class="validate" />
                        <label for="invoice-coment">Comentario</label>
                    </div>

                    
<!-- SERVICES  -->
                    <table class="highlight centered">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Dto</th>
                                <th>Total Dto</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            <tr>
                                <td><input type="text" class="validate" name="descripcion[]"></td>
                                <td><input type="number" class="validate cantidad" name="cantidad[]" min="1" value="1" onchange="calculateTotals(this)"></td>
                                <td><input type="number" class="validate precio" name="precio[]" step="0.01" onchange="calculateTotals(this, 'precio')"></td>
                                <td><input type="number" class="validate descuento" name="descuento[]" step="0.01" onchange="calculateTotals(this)"></td>
                                <td><input type="text" class="validate total_descuento" name="total_descuento[]" readonly></td>
                                <td><input type="number" class="validate total" name="total[]" step="0.01" onchange="calculateTotals(this, 'total')"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col s12 m12 l12 lx12">
                        <a class="btn right waves-effect waves-light" onclick="createLine()" style="background-color: var(--color-button);">
                            Adicionar Servicios <i class="fa-solid fa-file-invoice-dollar"></i>
                        </a>
                    </div>
                </div> 
<!-- total  -->
                <table class="centered">
                    <thead>
                        <tr>
                            <th>Impuesto -IVA</th>
                            <th>B.I</th>
                            <th>Importe</th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="summary-table-body">
                        <tr>
                            <td><input type="number" value="Cáceres" disabled name="impuesto-iva"></td>
                            <td><input type="number" id="base-imponible" disabled step="0.01"></td>
                            <td><input type="number" id="importe" readonly step="0.01"></td>
                            <td></td>
                            <td></td>
                            <td><input type="number" id="total-general" readonly step="0.01"></td>
                        </tr>
                    </tbody>
            </table>

<!-- BUTTON TO SAVE -->
                <div class="row center-align" style="margin-top:3em;">
                    <a class="btn waves-effect waves-light" onclick="sendForm()" style="background-color: var(--color-button);">Entrar
                        <i class="material-icons right">send</i>
                    </a>
                </div>
            </form>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById("relate-invoice-uuid-selected").addEventListener("change", function() {
                const selectRelateInvoice = document.getElementById("relate-invoice-uuid-selected").value;
                console.log(selectRelateInvoice);
                if(selectRelateInvoice != ''){
                    document.getElementById("div-invoice-coment").style.display = "block";  
                }else{
                    document.getElementById("div-invoice-coment").style.display = "none";    
                }
             });

            // INITIAL SELECT
            initialSelectMaterialize();
        });



        // Nueva función para actualizar la tabla de resumen
        function updateSummaryTable() {
            let baseImponible = 0; // Suma de los precios sin IVA
            let importeIVA = 0;    // IVA calculado
            let totalGeneral = 0;  // Suma total (B.I. + IVA)

            const porcentajeIVA = 10; // IVA del 10%

            // Iterar sobre cada fila de la tabla principal
            document.querySelectorAll('#table-body tr').forEach(row => {
                let total = parseFloat(row.querySelector(".total").value) || 0;
                baseImponible += total; // Acumular el total (sin IVA) de cada fila
            });

            // Calcular el importe del IVA y el total general
            importeIVA = baseImponible * (porcentajeIVA / 100);
            totalGeneral = baseImponible;

            let totalBaseImponible = (baseImponible /(100+porcentajeIVA)) * 100;
            console.log(totalBaseImponible);
            // Actualizar los valores en la tabla de resumen
            document.getElementById('base-imponible').value = totalBaseImponible.toFixed(2);
            document.getElementById('importe').value = importeIVA.toFixed(2);
            document.getElementById('total-general').value = totalGeneral.toFixed(2);
        }



        function createLine() {
            let tableBody = document.getElementById("table-body");

            let newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td><input type="text" class="validate" name="descripcion[]"></td>
                <td><input type="number" class="validate cantidad" name="cantidad[]" min="1" value="1" onchange="calculateTotals(this)"></td>
                <td><input type="number" class="validate precio" name="precio[]" step="0.01" onchange="calculateTotals(this, 'precio')"></td>
                <td><input type="number" class="validate descuento" name="descuento[]" step="0.01" onchange="calculateTotals(this)"></td>
                <td><input type="text" class="validate total_descuento" name="total_descuento[]" readonly></td>
                <td><input type="number" class="validate total" name="total[]" step="0.01" onchange="calculateTotals(this, 'total')"></td>
            `;

            tableBody.appendChild(newRow);
        }


        function calculateTotals(input, changedField = '') {
            let row = input.closest("tr");
            let cantidad = parseFloat(row.querySelector(".cantidad").value) || 1;
            let precio = parseFloat(row.querySelector(".precio").value) || 0;
            let descuento = parseFloat(row.querySelector(".descuento").value) || 0;
            let totalField = row.querySelector(".total");
            let totalDescuentoField = row.querySelector(".total_descuento");

            descuento = Math.max(0, Math.min(descuento, 100));

            if (changedField === 'total') {
                let totalIngresado = parseFloat(totalField.value) || 0;
                let totalSinIVA = totalIngresado / 1.10;
                let totalBase = totalSinIVA / cantidad;
                let precioBase = totalBase / (1 - (descuento / 100));

                row.querySelector(".precio").value = precioBase.toFixed(2);
                precio = precioBase;
            }

            let totalDescuento = (precio * (descuento / 100)) * cantidad;
            let total = (precio * cantidad) - totalDescuento;
            let iva = total * 0.10;
            let totalConIVA = total + iva;

            totalDescuentoField.value = totalDescuento.toFixed(2);
            totalField.value = totalConIVA.toFixed(2);

            updateSummaryTable();
        }



       



        /*
         * Send invoice and save in server
         * @author SGV
         * @version 1.0 - 20230215 - initial release
         * @return <HTML>
         **/
        function sendForm(){
            let rows = document.querySelectorAll("#table-body tr");
            let dataServices = [];
            rows.forEach(row => {
                let inputs = row.querySelectorAll("input");
                let rowData = {
                    descripcion: inputs[0].value,
                    cantidad: inputs[1].value,
                    precio: inputs[2].value,
                    descuento: inputs[3].value,
                    total_descuento: inputs[4].value,
                    total: inputs[5].value
                };
                dataServices.push(rowData);
            });
            const selectRelateInvoice = document.getElementById("relate-invoice-uuid-selected").value;
            let taxableBase = document.getElementById('base-imponible').value;
            let importValue = document.getElementById('importe').value;
            let totalValue = document.getElementById('total-general').value;
            let invoiceComent = document.getElementById('invoice-coment').value.trim();
            let invoiceType = document.getElementById('type-invoice-selected').value.trim();
            let travelUuidSelected = document.getElementById('travel-uuid-selected').value.trim();
            let methodOfPayment = document.getElementById('method-of-payment').value.trim();
            
            if(!totalValue){
                showToastComponent("Valor total null, por favor Adicionar un servicio", null ,'error');
                return;  
            }
            if(!importValue){
                showToastComponent("Valor de importe null, por favor Adicionar un servicio", null ,'error');
                return;  
            }
            if(!taxableBase){
                showToastComponent("Valor Base Imponible null, por favor Adicionar un servicio", null ,'error');
            }
            const url = "{{route('registerInvoice', Session::get('user')['uuid']) }}";
            const creationDate = new Date().toISOString().split('T')[0];
            const formData = new FormData();
            formData.append('invoiceuuid', selectRelateInvoice);
            formData.append('taxableBase', taxableBase);
            formData.append('importValue', importValue);
            formData.append('totalValue', totalValue);
            formData.append('data', JSON.stringify(dataServices));
            formData.append('status', 'created');
            formData.append('traveluuid', travelUuidSelected);
            formData.append('type', invoiceType);
            formData.append('number', '{{$numberOfInvoice }}');
            formData.append('comentary', invoiceComent);
            formData.append('creationDate', creationDate);
            formData.append('methodOfPayment', methodOfPayment);
            
            formData.append('creationUserUUID', "{{ Session::get('user')['uuid'] }}");   
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
            showToastComponent("Factura creada con suceso", null,null);
            window.location = "{{ route('homeInvoice',  Session::get('user')['uuid'])}}";
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
