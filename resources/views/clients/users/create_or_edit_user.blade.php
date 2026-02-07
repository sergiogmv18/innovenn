@extends('main')

@section('showSearch', false)
@section('title', $isEdit ? 'Editar Usuario' : 'Crear Usuario')

@section('content')
<div class="space-y-8">

  {{-- Card --}}
  <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <form id="user-form" method="POST" action="{{ $formAction }}" class="p-6 lg:p-8 space-y-8">
      @csrf
      @if($formMethod !== 'POST')
        @method($formMethod)
      @endif

      @if($isEdit)
        <input type="hidden" name="uuid" value="{{ old('uuid', $userWk->uuid ?? '') }}">
      @endif

      <input type="hidden" name="address_uuid" value="{{ old('address_uuid', $addressWk->uuid ?? ($userWk->address_uuid ?? '')) }}">

      {{-- Datos --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div>
          <label for="first_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Nombre *</label>
          <input id="first_name" name="first_name" type="text" required
            value="{{ old('first_name', $userWk->first_name ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('first_name') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('first_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="sub_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Primer apellido *</label>
          <input id="sub_name" name="sub_name" type="text" required
            value="{{ old('sub_name', $userWk->sub_name ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('sub_name') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('sub_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="last_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Segundo apellido</label>
          <input id="last_name" name="last_name" type="text"
            value="{{ old('last_name', $userWk->last_name ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('last_name') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('last_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="email_address" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Email *</label>
          <input id="email_address" name="email_address" type="email" required autocomplete="email"
            value="{{ old('email_address', $userWk->email_address ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('email_address') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('email_address') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="phone_number" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Telefono *</label>
          <input id="phone_number" name="phone_number" type="text" required
            value="{{ old('phone_number', $userWk->phone_number ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('phone_number') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('phone_number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="relative">
          <label for="type" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Tipo *</label>
          <select id="type" name="type" required
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-semibold text-slate-900 dark:text-slate-100 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('type') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
            <option value="" disabled @selected(old('type', $userWk->type ?? '') == '')>Selecciona un tipo</option>
            @foreach($types ?? [] as $label => $value)
              <option value="{{ $value }}" @selected(old('type', $userWk->type ?? '') == $value)>{{ $label }}</option>
            @endforeach
          </select>
          @error('type') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
            Contrasena {{ $isEdit ? '' : '*' }}
          </label>
          <input id="password" name="password" type="password" autocomplete="new-password" {{ $isEdit ? '' : 'required' }}
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('password') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
            Confirmar contrasena {{ $isEdit ? '' : '*' }}
          </label>
          <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" {{ $isEdit ? '' : 'required' }}
            class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                   px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                   placeholder:text-slate-400 shadow-sm
                   focus:border-primary focus:ring-primary
                   @error('password_confirmation') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
          @error('password_confirmation') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Dirección --}}
      <div>
        <div class="flex items-center justify-between">
          <h2 class="text-sm font-extrabold tracking-wide text-slate-800 dark:text-white uppercase">Dirección</h2>
        </div>
        <div class="mt-3 border-t border-slate-200 dark:border-slate-800"></div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div>
            <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Direccion *</label>
            <input id="address" name="address" type="text" required
              value="{{ old('address', $addressWk->address ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary
                     @error('address') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror">
            @error('address') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="number" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Numero</label>
            <input id="number" name="number" type="text"
              value="{{ old('number', $addressWk->number ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div>
            <label for="postalCode" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Codigo postal</label>
            <input id="postalCode" name="postalCode" type="text"
              value="{{ old('postalCode', $addressWk->postalCode ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div>
            <label for="city" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Ciudad</label>
            <input id="city" name="city" type="text"
              value="{{ old('city', $addressWk->city ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div>
            <label for="state" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Estado / Provincia</label>
            <input id="state" name="state" type="text"
              value="{{ old('state', $addressWk->state ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div>
            <label for="country" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Pais</label>
            <input id="country" name="country" type="text"
              value="{{ old('country', $addressWk->country ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div>
            <label for="district" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Distrito / Barrio</label>
            <input id="district" name="district" type="text"
              value="{{ old('district', $addressWk->district ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div class="lg:col-span-2">
            <label for="complement" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
              Complemento (apto/piso/referencia)
            </label>
            <input id="complement" name="complement" type="text"
              value="{{ old('complement', $addressWk->complement ?? '') }}"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">
          </div>

          <div class="lg:col-span-3">
            <label for="notes" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Notas</label>
            <textarea id="notes" name="notes" rows="4"
              class="mt-2 w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950
                     px-3 py-3 text-sm font-medium text-slate-900 dark:text-slate-100
                     placeholder:text-slate-400 shadow-sm
                     focus:border-primary focus:ring-primary">{{ old('notes', $addressWk->notes ?? '') }}</textarea>
          </div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <button type="submit"
          class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-extrabold text-white
                 shadow-lg shadow-primary/25 hover:bg-primary/90 transition">
          <span class="material-symbols-outlined text-[18px]">save</span>
          {{ $isEdit ? 'Guardar cambios' : 'Guardar' }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ✅ Ya NO inicializamos Materialize selects (M.FormSelect) porque ahora es Tailwind.

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
