@php
use App\Models\Room;
use App\Models\User;
@endphp
@extends('main')

@section('title', 'Habitaciones')
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














    .action-btn {
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 18px;
        padding: 6px 10px;
        border-radius: 10px;
    }

    .action-btn:hover {
        background: rgba(0, 0, 0, .06);
    }

    .action-menu {
        position: fixed;
        /* 👈 clave: evita recorte por tablas */
        min-width: 190px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
        padding: 8px;
        z-index: 99999;
        display: none;
    }

    .action-menu a,
    .action-menu button {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 10px;
        border-radius: 10px;
        text-decoration: none;
        color: #222;
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 14px;
        text-align: left;
    }

    .action-menu a:hover,
    .action-menu button:hover {
        background: rgba(100, 181, 246, .12);
    }

    .action-menu .danger {
        color: #d32f2f;
    }

    .action-menu .danger:hover {
        background: rgba(211, 47, 47, .10);
    }

    .menu-divider {
        height: 1px;
        background: rgba(0, 0, 0, .08);
        margin: 6px 0;
    }

    button:focus {
    outline: none;
        background-color: var(--color-button) !important;
    }
</style>
@section('content')
<section class="section section-stats">
    <div class="row center">
        <div class="col s12 m12 l12">
            <div class="left">
                <h5 class="page-title">Lista de Habitaciones</h5>
                <div class="left grey-text">
                    Total: {{ $rooms->total() }}
                </div>
            </div>

            <div class="card col s12 m12 l12">
                <div class="card-content">
                    <div class="table-wrap">
                        <table class="highlight striped responsive-table" id="travelersTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Numero</th>
                                    <th>Estado</th>
                                    <th>N° Personas</th>
                                    <th>N° Camas</th>
                                    <th>Tipo de cama</th>
                                    <th class="right-align">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                <tr data-row="1">
                                    <td>
                                        {{ strtoupper($room->name) }}
                                    </td>

                                    <td>{{ $room->number}}</td>

                                    <td>
                                        {{ strtoupper($room->status) }}
                                    </td>
                                    <td>
                                        {{ strtoupper($room->people_count) }}
                                    </td>
                                    <td>
                                        {{ strtoupper($room->beds_count) }}
                                    </td>
                                     <td>
                                        {{ strtoupper($room->bed_type) }}
                                    </td>
                                    @if((int) Session::get('user')->type === User::ROLE_ADMIN)
                                        <td class="right-align actions" style="position: relative;">
                                            <button type="button"
                                                class="action-btn"
                                                onclick="toggleMenu(event, 'menu-{{ $room->uuid }}')">
                                               Acciones
                                            </button>
                                            <div id="menu-{{ $room->uuid }}" class="action-menu" aria-hidden="true">
                                                <a href="{{ route('editRoomForm', [Session::get('user')->uuid, $room->uuid]) }}"><i class="fa-regular fa-pen-to-square" style="color:var(--color-button);"></i> Editar</a>
                                                @if ($room->uuid == Room::STATUS_VL)
                                                    <div class="menu-divider"></div>
                                                    <button type="button"
                                                        class="danger"
                                                        onclick="deleteUser(this)"
                                                        data-user-uuid="{{ $room->uuid }}">
                                                        Eliminar
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                                @empty
                                    <tr data-empty="1">
                                        <td colspan="7">
                                            <div class="no-results">
                                                <i class="material-icons">inbox</i>
                                                <div class="no-title">Aún no hay registros</div>
                                                <div class="no-subtitle">Crea tu primer parte con el botón +.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@if ($rooms->hasPages())
<div class="row">
    <div class="col s12 center">
        @php
            $startPage = max(1, $rooms->currentPage() - 2);
            $endPage = min($rooms->lastPage(), $rooms->currentPage() + 2);
        @endphp
        <ul class="pagination">
            <li class="{{ $rooms->onFirstPage() ? 'disabled' : 'waves-effect' }}">
                <a href="{{ $rooms->previousPageUrl() ?? '#' }}"><i class="material-icons">chevron_left</i></a>
            </li>

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $rooms->currentPage())
                    <li class="active" style="background-color: var(--color-button);"><a href="#!">{{ $page }}</a></li>
                @else
                    <li class="waves-effect"><a href="{{ $rooms->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            <li class="{{ $rooms->hasMorePages() ? 'waves-effect' : 'disabled' }}">
                <a href="{{ $rooms->nextPageUrl() ?? '#' }}"><i class="material-icons">chevron_right</i></a>
            </li>
        </ul>
    </div>
</div>
@endif

{{-- tu float button lo puedes dejar igual --}}
<div class="fixed-action-btn">
    <a class="btn-floating btn-large" href="{{ route('createOrEditRoomIndex', Session::get('user')->uuid) }}" style="background-color:var(--color-button);">
        <i class="material-icons">add</i>
    </a>
</div>




{{-- modal igual --}}
<div id="modal-delete-user" class="modal">
    <div class="modal-content">
        <h4>Confirmación de eliminación</h4>
        <p>¿Está seguro de que desea eliminar este Usuario? Esta acción no se puede deshacer.</p>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-grey btn-flat">Cancelar</a>
        <a id="confirm-button-delete-user" class="waves-effect waves-red red-text btn-flat">Eliminar</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var modelDeleteUser;


    function closeAllMenus() {
        document.querySelectorAll('.action-menu').forEach(m => m.style.display = 'none');
    }

    function toggleMenu(e, menuId) {
        e.preventDefault();
        e.stopPropagation();
        const menu = document.getElementById(menuId);
        const isOpen = menu.style.display === 'block';
        closeAllMenus();
        if (isOpen) return;
        // Posicionar cerca del botón
        const rect = e.currentTarget.getBoundingClientRect();
        menu.style.display = 'block';
        // Por defecto: abajo a la derecha del botón
        let top = rect.bottom + 8;
        let left = rect.right - menu.offsetWidth;
        // Ajuste si se sale de pantalla
        const pad = 10;
        if (left < pad) left = pad;
        if (top + menu.offsetHeight > window.innerHeight - pad) {
            top = rect.top - menu.offsetHeight - 8;
        }
        if (top < pad) top = pad;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Cerrar al click afuera / scroll / resize / ESC
        document.addEventListener('click', closeAllMenus);
        document.addEventListener('scroll', closeAllMenus, true);
        window.addEventListener('resize', closeAllMenus);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAllMenus();
        });




        // INITIAL MODAL
        initalModal();
        var modalElement = document.querySelector('#modal-delete-user');
        modelDeleteUser = M.Modal.getInstance(modalElement);

        // FLOAT BUTTON INITIAL
        var elemsFloatButton = document.querySelectorAll('.fixed-action-btn');
        M.FloatingActionButton.init(elemsFloatButton, {
            hoverEnabled: false

        });
        //TOOLTIPPED
        // var elemsTooltipped = document.querySelectorAll('.tooltipped');
        // M.Tooltip.init(elemsTooltipped, {});

    });



    /*
     * Delete Travels
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @param <this> element
     * @return <HTML>
     **/
    function deleteUser(element) {
        let userUuid = element.getAttribute("data-user-uuid");
        modelDeleteUser.open();
        document.getElementById('confirm-button-delete-user').addEventListener('click', function() {
            if (userUuid != null) {
                const formData = new FormData();
                const url = "{{ route('deleteUser', [Session::get('user')->uuid, 'USER_UUID']) }}".replace('USER_UUID', userUuid);
                ajaxRequest(url, "POST", formData, onSuccess, onError);
            } else {
                modelDeleteUser.close();
                showToastComponent("No se puede eliminar ese usuario, por favor intente mas tarde o comuniquese con soporte", null, 'notification');
                return;
            }
        });
    }

    // Callback de success
    function onSuccess(response) {
        modelDeleteUser.close();
        showToastComponent("Usuario eliminado con exito", null, null);
        window.location.reload();
        return;
    }

    // Callback de error
    function onError(status, textStatus, errorThrown, response) {
        showToastComponent("El usuario no pudo ser eliminado, por favor intente mas tarde, o contacte a soporte", null, 'error');
        return;
    }
</script>
@endpush
