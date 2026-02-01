@extends('main')

@section('title', 'Parte de viajero')
<style>
    .page-title {
        margin: 0;
        font-weight: 800;
    }

    .page-subtitle {
        margin-top: 4px;
        font-size: 14px;
    }

    .card {
        border-radius: var(--border-radius) !important;
        overflow: hidden;
       
    }

    .table-wrap {
        overflow-x: auto;
    }

    table thead {
        background: rgba(100, 181, 246, 0.12);
    }

    table thead th {
        font-weight: 800;
    }

    td {
        font-size: 13px;
        padding: 10px 10px !important;
    }

    td.actions {
        white-space: nowrap;
    }

    .muted {
        color: rgba(0, 0, 0, .35);
    }

    .no-results {
        padding: 34px 12px;
        text-align: center;
        color: rgba(0, 0, 0, .55);
    }

    .no-results i {
        font-size: 44px;
        color: rgba(0, 0, 0, .30);
    }

    .no-title {
        margin-top: 10px;
        font-weight: 800;
        color: rgba(0, 0, 0, .70);
    }

    .no-subtitle {
        margin-top: 4px;
        font-size: 14px;
    }
</style>
@section('content')
<section class="section section-stats">
    <div class="row center">
        <div class="col s12 m12 l12">
            <div class="left">
                <h5 class="page-title">Partes de viajeros</h5>
                <div class="left grey-text">
                    Total: {{ count($alltravelersRegisted) }}
                </div>
            </div>

            <div class="card col s12 m12 l12">
                <div class="card-content">
                    <div class="table-wrap">
                        <table class="highlight striped responsive-table" id="travelersTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>N° Parte</th>
                                    <th>Fecha de ingreso</th>
                                    <th>Fecha de salida</th>
                                    <th class="right-align">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($alltravelersRegisted as $travel)
                                <tr data-row="1">
                                    <td>
                                        {{ strtoupper($travel->firstName).' '.strtoupper($travel->subName) }}
                                    </td>

                                    <td>{{ $travel->npart }}</td>

                                    <td>
                                        {{ \DateTime::createFromFormat('Y-m-d', $travel->entryDate)->format('d/m/Y') }}
                                    </td>

                                    @php
                                    // Ajusta este sentinel si tu backend usa "0001-11-30" o similar
                                    $invalidDate = in_array($travel->finalDate, [null, '', '0001-11-30', '30/11/-0001'], true);
                                    @endphp

                                    <td class="{{ $invalidDate ? 'muted' : '' }}">
                                        {{ $invalidDate ? '—' : \DateTime::createFromFormat('Y-m-d', $travel->finalDate)->format('d/m/Y') }}
                                    </td>

                                    <td class="right-align actions">
                                        <a style="background-color:var(--color-button);"
                                            href="{{ route('getFormToEditTravel', [Session::get('user')->uuid, $travel->uuid]) }}"
                                            class="waves-effect waves-light btn-small tooltipped"
                                            data-position="left" data-tooltip="Editar">
                                            <i class="material-icons">border_color</i>
                                        </a>

                                        <a style="background-color:var(--color-button-error);"
                                            onclick="deleteTravel(this)"
                                            data-travel-uuid="{{ $travel->uuid }}"
                                            class="waves-effect waves-light btn-small tooltipped"
                                            data-position="top" data-tooltip="Eliminar">
                                            <i class="material-icons">delete_forever</i>
                                        </a>

                                        <a style="background-color:var(--color-button);"
                                            href="{{ route('getSpecificTravel', [Session::get('user')->uuid, $travel->uuid]) }}"
                                            class="waves-effect waves-light btn-small tooltipped"
                                            data-position="top" data-tooltip="Ver">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>

                                        <a onclick="convertAndDownloadXML(this)"
                                            data-travel-uuid="{{ $travel->uuid }}"
                                            data-travel-name="{{ $travel->firstName }}"
                                            class="waves-effect waves-light btn-small tooltipped"
                                            data-position="top" data-tooltip="Descargar XML">
                                            <i class="material-icons">unarchive</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr data-empty="1">
                                    <td colspan="5">
                                        <div class="no-results">
                                            <i class="material-icons">inbox</i>
                                            <div class="no-title">Aún no hay registros</div>
                                            <div class="no-subtitle">Crea tu primer parte con el botón +.</div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse

                                {{-- fila “sin resultados” para búsqueda --}}
                                <tr id="no-results" style="display:none;">
                                    <td colspan="5">
                                        <div class="no-results">
                                            <i class="material-icons">search_off</i>
                                            <div class="no-title">Sin resultados</div>
                                            <div class="no-subtitle">Prueba con otro nombre o N° parte.</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- tu float button lo puedes dejar igual --}}
<div class="fixed-action-btn">
    <a class="btn-floating btn-large" style="background-color:var(--color-button);">
        <i class="material-icons">add</i>
    </a>
    <ul>
        <li>
            <a href="{{ route('showFormRegisterTravel', Session::get('user')->uuid) }}"
                class="btn-floating tooltipped"
                style="background-color:var(--color-button);"
                data-position="left" data-tooltip="Registrar viajero">
                <i class="material-icons">mode_edit</i>
            </a>
        </li>
    </ul>
</div>

{{-- modal igual --}}
<div id="modal-delete-travel" class="modal">
    <div class="modal-content">
        <h4>Confirmación de eliminación</h4>
        <p>¿Está seguro de que desea eliminar este registro? Esta acción no se puede deshacer.</p>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-grey btn-flat">Cancelar</a>
        <a id="confirm-button-delete-travel" class="waves-effect waves-red red-text btn-flat">Eliminar</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var modelDeleteTravel;
    var nameTravelToDocument = "";
    document.addEventListener('DOMContentLoaded', function() {
        // INITIAL MODAL
        initalModal();
        var modalElement = document.querySelector('#modal-delete-travel');
        modelDeleteTravel = M.Modal.getInstance(modalElement);

        // FLOAT BUTTON INITIAL
        var elemsFloatButton = document.querySelectorAll('.fixed-action-btn');
        M.FloatingActionButton.init(elemsFloatButton, {
            hoverEnabled: false

        });
        //TOOLTIPPED
        var elemsTooltipped = document.querySelectorAll('.tooltipped');
        M.Tooltip.init(elemsTooltipped, {});

        // SEARCH 
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('table tbody tr');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let noResults = true;

            tableRows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(1)'); // Selecciona la primera columna (Nombre)
                const nameText = nameCell ? nameCell.innerText.toLowerCase() : '';

                if (nameText.includes(query)) {
                    row.style.display = '';
                    noResults = false;
                } else {
                    row.style.display = 'none';
                }
            });

            // Mostrar u ocultar mensaje de no resultados
            document.getElementById('no-results').style.display = noResults ? '' : 'none';
        });


    });


    function convertAndDownloadXML(button) {
        // Obtener el valor desde el atributo data-travel-uuid
        const travelUuid = button.getAttribute('data-travel-uuid');
        nameTravelToDocument = button.getAttribute('data-travel-name');
        // Crear la URL usando el valor obtenido dinámicamente
        const url = `{{ route('downloadXML', ['useruuid' => Session::get('user')->uuid, 'traveluuid' => '__TRAVEL_UUID__']) }}`.replace('__TRAVEL_UUID__', travelUuid);
        console.log(url);
        // return;
        const formData = new FormData();
        formData.append('traveluuid', travelUuid);
        ajaxRequest(url, "POST", formData, onSuccessResponseDonwloadXML, onErrorResponseDownloadXLM);
    }

    /*
     * Success ajax request and get cards of comments
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @param <obj> response of server
     * @return <HTML>
     **/
    function onSuccessResponseDonwloadXML(response) {
        if (response.success === false) {
            showToastComponent(response.message, null, 'error');
            return;
        }
        const timestampSeconds = Math.floor(Date.now() / 1000);
        // Si la respuesta es exitosa, descargamos el archivo
        // Supongamos que el backend devuelve la URL del archivo XML generado
        var fileUrl = response.file_url; // Asumiendo que la respuesta tiene la URL del archivo
        // Crear un enlace de descarga temporal
        var downloadLink = document.createElement('a');
        downloadLink.href = fileUrl; // Asignamos la URL del archivo
        downloadLink.download = 'parte_de_viajero_' + nameTravelToDocument + '' + timestampSeconds + '.xml'; // Nombre del archivo a descargar
        // Simular un clic en el enlace
        document.body.appendChild(downloadLink); // Añadir el enlace al DOM
        downloadLink.click(); // Hacer clic en el enlace para iniciar la descarga
    }

    // Callback de error
    function onErrorResponseDownloadXLM(status, textStatus, errorThrown, response) {
        // console.log(status,textStatus, errorThrown, response);
        showToastComponent("<?php echo  ucfirst('error sending information, please try again later'); ?>", null, 'error');
        return;
    }


    /*
     * Delete Travels
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @param <this> element
     * @return <HTML>
     **/
    function deleteTravel(element) {
        let travelUuid = element.getAttribute("data-travel-uuid");
        modelDeleteTravel.open();
        document.getElementById('confirm-button-delete-travel').addEventListener('click', function() {
            if (travelUuid != null) {
                const formData = new FormData();
                formData.append('traveluuid', travelUuid);
                const url = "{{route('deleteTravel',Session::get('user')['uuid'] ) }}";
                ajaxRequest(url, "POST", formData, onSuccess, onError);
            } else {
                modelDeleteTravel.close();
                showToastComponent("No se puede eliminar ese viajero, por favor intente mas tarde o comuniquese con soporte", null, 'notification');
                return;
            }
        });
    }

    // Callback de success
    function onSuccess(response) {
        modelDeleteTravel.close();
        showToastComponent("Registro de viajero eliminado con exito", null, null);
        window.location.reload();
        return;
    }

    // Callback de error
    function onError(status, textStatus, errorThrown, response) {
        showToastComponent("El registro de viajero no pudo ser eliminado, por favor intente mas tarde, o contacte a soporte", null, 'error');
        return;
    }
</script>
@endpush