@php
  use App\Models\User;
@endphp

@extends('main')

@section('title', 'Usuarios')

@section('content')
<div class="space-y-8">
  {{-- Header --}}
  <div class="flex items-start justify-between gap-4">
    <div>
      <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
        Total: {{ count($allUser) }}
      </p>
    </div>

    {{-- Botón crear (desktop) --}}
    <a href="{{ route('createOrEditUserIndex', Session::get('user')->uuid) }}"
       class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-extrabold text-white
              shadow-lg shadow-primary/25 hover:bg-primary/90 transition">
      <span class="material-symbols-outlined text-[18px]">add</span>
      Nuevo usuario
    </a>
  </div>

  {{-- Card Tabla --}}
  <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full table-fixed text-left">
        <thead class="bg-slate-50 dark:bg-slate-800/50">
          <tr class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
            <th class="px-6 py-4">Nombre completo</th>
            <th class="px-6 py-4">Correo electrónico</th>
            <th class="px-6 py-4">Teléfono</th>
            <th class="px-6 py-4">Rol</th>
            <th class="px-6 py-4 text-right">Acciones</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          @forelse ($allUser as $user)
            <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
              <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                {{ strtoupper($user->getFullName()) }}
              </td>

              <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                {{ $user->email_address }}
              </td>

              <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                {{ strtoupper($user->phone_number) }}
              </td>

              <td class="px-6 py-4">
                <span class="inline-flex items-center rounded-full dark:bg-slate-800 px-2.5 py-1 text-[11px] font-extrabold text-slate-700 dark:text-slate-200" style="background-color: {{ $user->getNameType(true) }}">
                  {{ strtoupper($user->getNameType()) }}
                </span>
              </td>

              <td class="px-6 py-4 text-right">
                @if((int) Session::get('user')->type === User::ROLE_ADMIN)
                  <button type="button"
                          class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-800
                                 bg-white dark:bg-slate-950 px-3 py-2 text-xs font-extrabold text-slate-700 dark:text-slate-200
                                 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                          onclick="toggleMenu(event, 'menu-{{ $user->uuid }}')">
                    Acciones
                    <span class="material-symbols-outlined text-[16px] text-slate-400">expand_more</span>
                  </button>

                  {{-- Menú flotante (fixed para no recortarse con overflow) --}}
                  <div id="menu-{{ $user->uuid }}"
                       class="action-menu fixed z-[9999] hidden min-w-[200px] rounded-2xl border border-slate-200 dark:border-slate-800
                              bg-white dark:bg-slate-900 shadow-xl shadow-slate-900/10 p-2">
                    <a class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200
                              hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                       href="{{ route('editUserForm', [Session::get('user')->uuid, $user->uuid]) }}">
                      <span class="material-symbols-outlined text-[18px] text-primary">edit</span>
                      Editar
                    </a>

                    @if ($user->uuid != Session::get('user')->uuid)
                      <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

                      <button type="button"
                              class="w-full flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-rose-600
                                     hover:bg-rose-50 dark:hover:bg-rose-500/10 transition"
                              onclick="openDeleteModal('{{ $user->uuid }}')">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Eliminar
                      </button>
                    @endif
                  </div>
                @else
                  <span class="text-xs text-slate-400">—</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12">
                <div class="text-center">
                  <div class="mx-auto mb-3 flex size-12 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800">
                    <span class="material-symbols-outlined text-slate-400">inbox</span>
                  </div>
                  <p class="font-extrabold text-slate-800 dark:text-white">Aún no hay registros</p>
                  <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Crea tu primer usuario con el botón +.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- FAB (+) móvil/desktop --}}

  <!-- <a href="{{ route('createOrEditUserIndex', Session::get('user')->uuid) }}"
     class="fixed bottom-6 right-6 inline-flex items-center justify-center size-14 rounded-full bg-primary text-white
            shadow-xl shadow-primary/30 hover:bg-primary/90 transition z-50">
    <span class="material-symbols-outlined text-[26px]">add</span>
  </a> -->

  {{-- Modal eliminar (Tailwind) --}}
  <div id="modal-delete-user" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50" onclick="closeDeleteModal()"></div>

    <div class="relative mx-auto mt-24 w-[92%] max-w-md rounded-2xl bg-white dark:bg-slate-900
                border border-slate-200 dark:border-slate-800 shadow-xl p-6">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Confirmación de eliminación</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            ¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.
          </p>
        </div>

        <button type="button" class="rounded-xl p-2 hover:bg-slate-100 dark:hover:bg-slate-800" onclick="closeDeleteModal()">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <div class="mt-6 flex items-center justify-end gap-2">
        <button type="button"
                class="rounded-xl border border-slate-200 dark:border-slate-800 px-4 py-2 text-sm font-extrabold
                       text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                onclick="closeDeleteModal()">
          Cancelar
        </button>

        <button id="confirm-button-delete-user" type="button"
                class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-extrabold text-black hover:bg-rose-700 transition">
          Eliminar
        </button>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  let deleteUserUuid = null;

  // ---- Menú acciones ----
  function closeAllMenus() {
    document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));
  }

  function toggleMenu(e, menuId) {
    e.preventDefault();
    e.stopPropagation();

    const menu = document.getElementById(menuId);
    const isOpen = !menu.classList.contains('hidden');

    closeAllMenus();
    if (isOpen) return;

    // Mostrar para medir
    menu.classList.remove('hidden');

    const rect = e.currentTarget.getBoundingClientRect();

    let top = rect.bottom + 8;
    let left = rect.right - menu.offsetWidth;

    const pad = 10;
    if (left < pad) left = pad;
    if (top + menu.offsetHeight > window.innerHeight - pad) {
      top = rect.top - menu.offsetHeight - 8;
    }
    if (top < pad) top = pad;

    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
  }

  document.addEventListener('click', closeAllMenus);
  document.addEventListener('scroll', closeAllMenus, true);
  window.addEventListener('resize', closeAllMenus);
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAllMenus(); });

  // ---- Modal eliminar ----
  function openDeleteModal(uuid) {
    closeAllMenus();
    deleteUserUuid = uuid;
    document.getElementById('modal-delete-user').classList.remove('hidden');
  }

  function closeDeleteModal() {
    deleteUserUuid = null;
    document.getElementById('modal-delete-user').classList.add('hidden');
  }

  document.getElementById('confirm-button-delete-user').addEventListener('click', function () {
    if (!deleteUserUuid) return;

    const formData = new FormData();
    const url = "{{ route('deleteUser', [Session::get('user')->uuid, 'USER_UUID']) }}".replace('USER_UUID', deleteUserUuid);

    ajaxRequest(url, "POST", formData,
      function () {
        closeDeleteModal();
       // showToastComponent("Usuario eliminado con éxito", null, null);
        window.location.reload();
      },
      function () {
        closeDeleteModal();
        showToastComponent("El usuario no pudo ser eliminado, intente más tarde o contacte a soporte", null, 'error');
      }
    );
  });

  // Toasts (si vienes con errores/flash)
  document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
      showToastComponent(@json($errors->first()), null, 'error');
    @elseif(session('message'))
      showToastComponent(@json(session('message')), null, null);
    @elseif(session('error'))
      showToastComponent(@json(session('error')), null, 'error');
    @endif
  });
</script>
@endpush
