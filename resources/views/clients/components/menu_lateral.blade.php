@php
  $user = Session::get('user');
  $billing = Session::get('billingData');
  $photo = ($billing?->photoPath != null) ? Storage::url($billing->photoPath) : asset('img/logo.png');
@endphp

{{-- Backdrop móvil --}}
<div id="sidebar-backdrop"
     class="fixed inset-0 z-40 bg-slate-900/40 opacity-0 pointer-events-none transition-opacity lg:hidden"
     onclick="toggleSidebar(false)"></div>

<aside id="sidebar"
  class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col fixed h-full
         z-50 transform -translate-x-full transition-transform duration-200 ease-out
         lg:translate-x-0">


  {{-- NAV --}}
  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    {{-- Inicio --}}
    <a href="{{ route('travelersRegisterHome', $user->uuid) }}"
       class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl
              text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
      <span class="flex items-center gap-3">
        <i class="fa-solid fa-house text-slate-400"></i>
        <span class="text-sm font-semibold">Inicio</span>
      </span>
    </a>

    {{-- Registros viajeros (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-hotel text-slate-400"></i>
          <span class="text-sm font-semibold">Registros viajeros</span>
        </span>

        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('travelerRegistration', $user->uuid) }}">
          Todos los registros
        </a>

        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('showFormRegisterTravel', $user->uuid) }}">
          Crear registro
        </a>

        <button type="button"
                onclick="generateTemporaryUrl()"
                class="w-full text-left px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
          Crear URL para checkin
        </button>

        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="#">
          Descargar registro vacío
        </a>
      </div>
    </details>

    {{-- Calendario --}}
    <a href="{{ route('bookingIndex', $user->uuid) }}"
       class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl
              text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
      <span class="flex items-center gap-3">
        <i class="fa-solid fa-calendar-days text-slate-400"></i>
        <span class="text-sm font-semibold">Calendario</span>
      </span>
    </a>

    {{-- Administración (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-file-invoice text-slate-400"></i>
          <span class="text-sm font-semibold">Administración</span>
        </span>
        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('homeInvoice', $user->uuid) }}">
          Facturas ventas
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('homeInvoice', $user->uuid) }}">
          Facturas gastos
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('getFormOfRegisterInvoice') }}">
          Crear factura
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('billingData', $user->uuid) }}">
          Información de facturación
        </a>
      </div>
    </details>

    {{-- Inventario (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-boxes-stacked text-slate-400"></i>
          <span class="text-sm font-semibold">Inventario</span>
        </span>
        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="#">
          Proveedores
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="#">
          Crear inventario
        </a>
      </div>
    </details>

    {{-- Configuración (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-gear text-slate-400"></i>
          <span class="text-sm font-semibold">Configuración</span>
        </span>
        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="#">
          Configuración del hotel
        </a>
      </div>
    </details>

    {{-- Hotel (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-hotel text-slate-400"></i>
          <span class="text-sm font-semibold">Hotel</span>
        </span>
        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('roomIndex', $user->hotel_uuid) }}">
          Recepcionar habitaciones
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('getAllRooms', $user->hotel_uuid) }}">
          Todas habitaciones
        </a>
      </div>
    </details>

    {{-- Usuarios (collapsible) --}}
    <details class="group rounded-xl">
      <summary class="cursor-pointer list-none flex items-center justify-between px-3 py-2.5 rounded-xl
                      text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-users text-slate-400"></i>
          <span class="text-sm font-semibold">Usuarios</span>
        </span>
        <span class="text-slate-400 group-open:rotate-180 transition">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
      </summary>

      <div class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-1 py-2">
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('allUserHome', $user->uuid) }}">
          Todos los usuarios
        </a>
        <a class="block px-3 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800"
           href="{{ route('createOrEditUserIndex', $user->uuid) }}">
          Crear usuario
        </a>
      </div>
    </details>
  </nav>

  {{-- Footer / Cerrar sesión --}}
  <div class="p-4 border-t border-slate-200 dark:border-slate-800">
    <a href="{{ route('signOut') }}"
       class="w-full flex items-center justify-center gap-2 bg-primary text-white text-xs font-bold py-2.5 rounded-xl
              shadow-md shadow-primary/20 hover:bg-primary/90 transition uppercase tracking-wide">
      <i class="fa-solid fa-right-from-bracket"></i>
      Cerrar sesión
    </a>

    <div class="mt-3 flex items-center gap-3 px-2 py-1">
      <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
      <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">
        Fiscal Machine: Online
      </span>
    </div>
  </div>
</aside>







