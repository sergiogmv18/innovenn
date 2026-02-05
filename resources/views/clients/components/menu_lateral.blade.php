
<ul id="sidenav-1" style="background-color: var(--color-button);" class="sidenav sidenav-fixed">
    <li>
        <div class="user-view">
            <div class="background">
                <img style="width: -webkit-fill-available; opacity: 0.4;" src="{{asset('img/background-circle.png') }}" alt="background logo of hotel">
            </div>
            <a><img class="circle" src="{{Session::get("billingData")?->photoPath != null ? Storage::url(Session::get('billingData')?->photoPath) : asset('img/logo.png') }}" alt="logo of hotel"></a>
            <h5 class="center-align white-text">Bienvenido!</h5>
            <span class="white-text name">{{Session::get('user')->name}}</span>
        </div>
    </li>
<!-- HOME -->
        <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text"  href="{{route('travelersRegisterHome', Session::get('user')->uuid) }}">Inicio <i class="fa-solid fa-home white-text"></i></a>
                <div class="collapsible-body"></div>
            </li>
        </ul>
    </li>
<!-- REGISTER TRAVELS -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="collapsible-item">
            <a class="collapsible-header white-text">Registros viajeros <i class="fa-solid fa-hotel white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                        <li><a class="white-text" href="{{route('travelerRegistration', Session::get('user')->uuid) }}">Todos los registos</a></li>
                        <li><a class="white-text" href="{{route('showFormRegisterTravel', parameters: Session::get('user')->uuid) }}">Crear registo</a></li>
                        <li><a onclick="generateTemporaryUrl()" style="cursor: pointer;"  class="white-text">Crear URL para checkin</a></li>  
                        <li><a class="white-text" href="">Descargar registro vacio</a></li>  
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <!-- CALENDARY  -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text"  href="{{route('bookingIndex', Session::get('user')->uuid) }}">Calendario <i class="fa-solid fa-calendar-days white-text"></i></a>
                <div class="collapsible-body"></div>
            </li>
        </ul>
    </li>
<!-- Admin -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text">Administración<i class="fa-solid fa-file-invoice white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                        <li><a class="white-text"  href="{{route('homeInvoice', Session::get('user')->uuid) }}">Facturas ventas</a></li>
                        <li><a class="white-text"  href="{{route('homeInvoice', Session::get('user')->uuid) }}">Facturas Gastos</a></li>
                        <li><a class="white-text" href="{{route('getFormOfRegisterInvoice') }}">Crear Factura</a></li>
                        <li><a  href="{{route('billingData', Session::get('user')->uuid) }}" class="white-text" href="">Información de facturación</a></li>
                        <li><a class="white-text" href="">Configuración de serie de factura</a></li>
                        <li><a class="white-text" href="">Historico de pagos</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
<!-- INVENTARY -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text">Inventario<i class="fa-solid fa-file-invoice white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                    <li><a class="white-text"  href="{{route('homeInvoice', Session::get('user')->uuid) }}">Proveedores</a></li>
                    <li><a class="white-text"  href="{{route('homeInvoice', Session::get('user')->uuid) }}">Crear inventario</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>

<!-- CONFIG -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text">Configuración<i class="fa-solid fa-gear white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                        <li><a class="white-text" href="">Configuración del hotel</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <!-- HOTEL -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text">Hotel<i class="fa-solid fa-hotel white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                        <li><a class="white-text" href="{{route('roomIndex',   Session::get('user')->hotel_uuid )}}">Recepcionar habitaciones</a></li>
                        <li><a class="white-text" href="{{route('getAllRooms',   Session::get('user')->hotel_uuid )}}">Todas habitaciones</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <!-- USER -->
     <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text">Usuarios<i class="fa-solid fa-users white-text"></i></a>
                <div class="collapsible-body">
                    <ul style="background-color: var(--color-button);">
                        <li><a class="white-text" href="{{route('allUserHome', Session::get('user')->uuid) }}">Todos los usuarios</a></li>
                        <li><a class="white-text" href="{{route('createOrEditUserIndex', Session::get('user')->uuid) }}">Crear usuario</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
 <!-- CERRAR SESSION -->
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header white-text" href="{{route('signOut') }}">Cerrar session <i class="material-icons white-text">exit_to_app</i></a>
                <div class="collapsible-body"></div>
            </li>
        </ul>
    </li>
  </ul>
