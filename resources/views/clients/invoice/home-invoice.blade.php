@extends('main')
@section('showSearch', false)

@section('title', 'Todas las Facturaciones')
<style>
    td {
        font-size: 1em;
        padding: 5px 5px !important;
    }
</style>
@section('content')
<div class="container">
    <section class="section section-stats center" style="margin-top: 4.5em;">
        <div class="row">
            <div class="col s12 m12 l12 lx12">
                <h3 class="left">Todas las Facturas</h3>
            </div>
            <div class="input-field col s6 m6 l4 lx4">
                <input name="initial-date" type="date" id="initial-date" class="validate" />
                <label for="initial-date">Fecha inicial</label>
                <span class="helper-text" id="error-initial-date" data-error="La fecha inicial no puede ser mayor que la fecha final"></span>

            </div>
            <div class="input-field col s6 m4 l4 lx4">
                <input name="final-date" type="date" id="final-date" class="validate" />
                <label for="final-date">Fecha final</label>
                <span class="helper-text" id="error-final-date" data-error="La fecha final no puede ser menor que la fecha inicial"></span>
            </div>
            <div class="input-field col s6 m4 l4 lx4">
                <select class="select-materialize" id="travel-method-of-payment">
                    <option class="option-label-select-materialize" value="" disabled>Forma de pago</option>
                    <option value="todos">Todos</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                    <option value="Transferencia">Transferencia</option>
                </select>
                <label class="label-select-materialize">Forma de Pago</label>
            </div>
            <div class="col s6 m4 l4 lx4">
                <a class="btn waves-effect waves-light button" onclick="imprimirTablet()" style="background-color: var(--color-button);">Descargar
                    <i class="material-icons right">unarchive</i>
                </a>
            </div>

        </div>


        <div id="contentPDF">
            <table class="highlight centered">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre viajero</th>
                        <th>Fecha de factura</th>
                        <th>Forma de Pago</th>
                        <th>Impuesto -IVA</th>
                        <th>B.I</th>
                        <th>Importe</th>
                        <th>Total</th>

                        <th class="title-action-buttom">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allInvoicesRegisted as $invoice)
                    <tr>
                        <td>{{$invoice->number}}</td>
                        <td>{{strtoupper($invoice->getTravelRelate()?->firstName)}} {{strtoupper($invoice->getTravelRelate()?->subName)}}</td>
                        <td>{{$invoice->getFromFormat()}}</td>
                        <td data-type-payment-value="{{$invoice->methodOfPayment }}">{{$invoice->methodOfPayment }}</td>
                        <td>10% IVA</td>
                        <td data-total-taxable-base="{{$invoice->taxableBase }}">{{ $invoice->taxableBase }}€</td>
                        <td data-total-import-value="{{$invoice->importValue }}">{{$invoice->importValue }}€</td>
                        <td data-total="{{$invoice->totalValue }}">{{$invoice->totalValue }}€</td>
                        <td class="action-buttom">
                            <a href="{{route('showSpecificInvoice', [Session::get('user')->uuid, $invoice->uuid ] )}}" class="modal-trigger waves-effect waves-light btn-small tooltipped" style="background-color:var(--color-button);" data-position="top" data-tooltip="Ver">
                                <i class="material-icons">remove_red_eye</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    <tr data-no-empy="true">
                        <td style="color: transparent;">.</td>
                        <td style="color: transparent;">.</td>
                        <td style="color: transparent;">.</td>
                        <td style="color: transparent;">.</td>
                        <td style="color: transparent;">.</td>
                        <td id="total-taxableBase">0€</td>
                        <td id="total-importValue">0€</td>
                        <td id="total-sum">0€</td>
                        <td class="action-buttom1"> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <br>

</div>
<!-- MODAL CONFIRMATION DELETE TRAVEL-->
<div id="modal-delete-travel" class="modal">
    <div class="modal-content">
        <h4>Confirmación de eliminación</h4>
        <p>¿Está seguro de que desea eliminar este registro de viajero? Esta acción no se puede deshacer.</p>

    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-grey btn-flat">Cancelar</a>
        <a id="confirm-button-delete-travel" class="waves-effect waves-red red-text btn-flat">Eliminar</a>
    </div>
</div>
<!-- MODAL GENERATE URL TO TRAVEL-->
<div id="modal-generate-url-travel" class="modal">
    <div class="modal-content">
        <h4>URL Temporario</h4>
        <p>esta url puede ser conpartido para un cliente, tiene vigencia de 2 horas</p>
        <p id="p-input-url-generated"></p>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-red red-text btn-flat">Cancelar</a>
        <a id="copy-button-url-generated" class="waves-effect waves-green  btn-flat">Copiar</a>
    </div>
</div>

<!-- float Button -->
<div class="fixed-action-btn">
    <a href="{{route('getFormOfRegisterInvoice') }}" class="btn-floating btn-large blue darken-2">
        <i class="material-icons">add</i>
    </a>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    var initialDateInput = document.getElementById('initial-date');
    var finalDateInput = document.getElementById('final-date');
    var paymentSelect = document.getElementById('travel-method-of-payment');

    document.addEventListener('DOMContentLoaded', function() {
        // INITIAL SELECT
        initialSelectMaterialize();
        // Obtener los inputs de fecha
        sumTotal();
        // Añadir evento para filtrar al cambiar las fechas
        initialDateInput.addEventListener('change', filterTable);
        finalDateInput.addEventListener('change', filterTable);

        // FILTRAR POR METODO DE PAGO 
        paymentSelect.addEventListener('change', filterTable);
    });

    function sumTotal() {
        var totalSum = 0;
        var totalImportValue = 0;
        var totalTaxableBase = 0;
        // Iterar solo sobre los td visibles con el atributo data-total y sumar los valores
        $('td[data-total]').each(function() {
            var row = $(this).closest('tr');
            if (row.is(':visible')) { // Verificar si la fila es visible
                let totalValue = parseFloat($(this).data('total'));
                totalSum += totalValue;
            }
        });
        // Colocar el resultado en el td con el id 'total-sum'
        $('#total-sum').text(totalSum.toFixed(2) + '€');

        // IMPORT VALUE TOTAL
        // IMPORT VALUE TOTAL
        $('td[data-total-import-value]').each(function() {
            var row = $(this).closest('tr');
            if (row.is(':visible')) { // Verificar si la fila es visible
                let totalValue = parseFloat($(this).data('totalImportValue')); // <--- Cambio aquí
                totalImportValue += totalValue;
            }
        });
        $('#total-importValue').text(totalImportValue.toFixed(2) + '€');

        // TAXABLE BASE TOTAL
        $('td[data-total-taxable-base]').each(function() {
            var row = $(this).closest('tr');
            if (row.is(':visible')) { // Verificar si la fila es visible
                let totalValue = parseFloat($(this).data('totalTaxableBase')); // <--- Cambio aquí
                totalTaxableBase += totalValue;
            }
        });
        $('#total-taxableBase').text(totalTaxableBase.toFixed(2) + '€');





    }

    function filterTable() {
        const paymentSelect = document.getElementById('travel-method-of-payment');
        const selectedPayment = (paymentSelect?.value || '').trim(); // todos / Efectivo / Tarjeta / Transferencia

        // Lee fechas (si están vacías, NO se filtra por fecha)
        const hasInitial = !!initialDateInput.value;
        const hasFinal = !!finalDateInput.value;

        // Si hay fechas y tu validación falla, recién ahí paras
        if ((hasInitial || hasFinal) && !validateDates()) return;

        const initialDate = hasInitial ? normalizeDate(new Date(initialDateInput.value)) : null;
        const finalDate = hasFinal ? normalizeDate(new Date(finalDateInput.value)) : null;

        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            // fila de totales o filas especiales
            if (row.getAttribute('data-no-empy') === 'true') {
                row.style.display = '';
                return;
            }

            // ====== FILTRO PAGO ======
            const paymentCell = row.querySelector('td[data-type-payment-value]');
            const rowPayment = (paymentCell?.dataset.typePaymentValue || '').trim();

            const passPayment =
                (selectedPayment === '' || selectedPayment === 'todos') ?
                true :
                rowPayment === selectedPayment;

            // ====== FILTRO FECHA (solo si hay fechas) ======
            let passDate = true;

            if (hasInitial || hasFinal) {
                const dateText = row.cells[2]?.innerText; // tu columna de fecha
                const rowDate = parseDate(dateText);

                const rowTime = rowDate.getTime();
                const initialTime = initialDate ? initialDate.getTime() : null;
                const finalTime = finalDate ? finalDate.getTime() : null;

                const afterInitial = initialTime === null ? true : rowTime >= initialTime;
                const beforeFinal = finalTime === null ? true : rowTime <= finalTime;

                passDate = afterInitial && beforeFinal;
            }

            row.style.display = (passPayment && passDate) ? '' : 'none';
        });

        sumTotal();
    }


    // Función para normalizar la fecha (sin horas)
    function normalizeDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    // Función para convertir DD/MM/YYYY a Date en JavaScript
    function parseDate(dateString) {
        if (!dateString) return NaN;
        const parts = dateString.split('/');
        // Formato esperado: DD/MM/YYYY
        const day = parts[0];
        const month = parts[1] - 1; // Los meses en JavaScript van de 0 a 11
        const year = parts[2];
        return new Date(year, month, day);
    }

    function validateDates() {
        // Normalizar fechas
        var mydateInitial = new Date(initialDateInput.value);
        const initialDate = normalizeDate(mydateInitial);
        var mydatefinal = new Date(finalDateInput.value);
        const finalDate = normalizeDate(mydatefinal);
        // Verificar si ambas fechas son válidas
        if (!isNaN(initialDate.getTime()) && !isNaN(finalDate.getTime())) {
            // Validar que la fecha inicial no sea mayor que la final
            if (initialDate > finalDate) {
                initialDateInput.classList.add('invalid');
                finalDateInput.classList.add('invalid');
                return false;
            }
            // Validar que la fecha final no sea menor que la inicial
            else if (finalDate < initialDate) {
                initialDateInput.classList.add('invalid');
                finalDateInput.classList.add('invalid');
                return false;

            }
            // Si todo es válido, limpiar errores
            else {
                initialDateInput.classList.remove('invalid');
                finalDateInput.classList.remove('invalid');
                initialDateInput.classList.add('valid');
                finalDateInput.classList.add('valid');
                return true;
            }
        }
        // Si alguna fecha está vacía, eliminar las clases de validación
        else {
            initialDateInput.classList.remove('invalid', 'valid');
            finalDateInput.classList.remove('invalid', 'valid');
            return true;
        }
    }


    async function imprimirTablet() {
        // Ocultar acciones
        document.querySelectorAll('.title-action-buttom, .action-buttom, .action-buttom1')
            .forEach(el => el.style.display = 'none');

        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4'); // ya viene con 1 página creada

        const table = document.querySelector('#contentPDF table');
        const tbody = table.querySelector('tbody');

        // Filas normales
        const rows = Array.from(tbody.querySelectorAll('tr'))
            .filter(r =>
                r.getAttribute('data-no-empy') !== 'true' &&
                getComputedStyle(r).display !== 'none'
            );

        // Fila de totales (la quieres en el PDF)
        const totalsRow = tbody.querySelector('tr[data-no-empy="true"]');

        // Ajusta esto según tu diseño. Si ves que corta antes, baja el número.
        const pageHeightPx = 1050;

        let currentRows = [];
        let currentHeight = 0;
        let pageIndex = 0;

        async function renderPage(rowsChunk, includeTotals = false) {
            // Clonar tabla completa (incluye thead automáticamente)
            const cloneTable = table.cloneNode(true);
            const cloneTbody = cloneTable.querySelector('tbody');
            cloneTbody.innerHTML = '';

            // Añadir filas del chunk
            rowsChunk.forEach(r => cloneTbody.appendChild(r.cloneNode(true)));

            // Si es la última página, añade totales al final
            if (includeTotals && totalsRow) {
                cloneTbody.appendChild(totalsRow.cloneNode(true));
            }

            // wrapper fuera de pantalla
            const wrapper = document.createElement('div');
            wrapper.style.position = 'absolute';
            wrapper.style.left = '-9999px';
            wrapper.style.top = '0';
            wrapper.style.background = '#fff';
            wrapper.appendChild(cloneTable);
            document.body.appendChild(wrapper);

            const canvas = await html2canvas(wrapper, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                scrollY: -window.scrollY,
            });

            const imgData = canvas.toDataURL('image/png');

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();

            const margin = 10;
            const footerSpace = 10; // espacio para "Página X / Y"
            const printableWidth = pageWidth - margin * 2;
            const printableHeight = pageHeight - margin * 2 - footerSpace;

            const imgWidth = printableWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // ✅ Evitar hoja en blanco al inicio:
            // Solo agregamos nueva página a partir de la segunda renderización
            if (pageIndex > 0) pdf.addPage();
            pageIndex++;

            // Si por algún motivo la imagen queda muy alta, se ajusta (mejor que cortar)
            const finalHeight = Math.min(imgHeight, printableHeight);

            pdf.addImage(imgData, 'PNG', margin, margin, imgWidth, finalHeight);

            document.body.removeChild(wrapper);
        }

        // Partir por filas sin cortar
        for (const row of rows) {
            currentRows.push(row);
            currentHeight = row.getBoundingClientRect().height || 40;

            if (currentHeight > pageHeightPx) {
                // renderiza página sin totales
                currentRows.pop();
                await renderPage(currentRows, false);

                // reinicia con la fila que no cupo
                currentRows = [row];
                currentHeight = row.getBoundingClientRect().height || 40;
            }
        }

        // Última página: incluye totales
        if (currentRows.length) {
            await renderPage(currentRows, true);
        }

        // ✅ Numeración de páginas "Página X / Y"
        const totalPages = pdf.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            pdf.setPage(i);
            const pageW = pdf.internal.pageSize.getWidth();
            const pageH = pdf.internal.pageSize.getHeight();

            pdf.setFontSize(10);
            pdf.text(`Página ${i} / ${totalPages}`, pageW - 10, pageH - 6, {
                align: 'right'
            });
        }

        pdf.save(`facturas-${initialDateInput.value || 'all'}-${finalDateInput.value || 'all'}.pdf`);

        // Restaurar acciones
        document.querySelectorAll('.title-action-buttom, .action-buttom, .action-buttom1')
            .forEach(el => el.style.display = 'block');
    }
</script>
@endpush