@extends('main')
@section('showSearch', false)
@php
$isEdit = isset($userWk);
$formAction = $formAction ?? '';
$formMethod = $formMethod ?? ($isEdit ? 'PUT' : 'POST');
$addressWk = $addressWk ?? null;
@endphp
@section('title', $isEdit ? 'Editar Usuario' : 'Crear Usuario')

<style>
    .page-wrap {
        background: var(--only-background-color);
        min-height: 100vh;
        padding: 26px;
    }

    .card {
        border-radius: var(--border-radius) !important;
    }
</style>

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col s12">
            <h5 style="font-weight:800;margin:0;">{{ $isEdit ? 'Editar usuario' : 'Crear usuario' }}</h5>
            <p class="grey-text" style="margin-top:6px;">
                {{ $isEdit ? 'Actualiza los datos del usuario' : 'Completa los datos para crear un nuevo usuario' }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card white z-depth-1">
                <div class="card-content">
                    <form id="user-form" method="POST" action="{{ $formAction }}">
                        @csrf
                        @if($formMethod !== 'POST')
                        @method($formMethod)
                        @endif
                        @if($isEdit)
                        <input type="hidden" name="uuid" value="{{ old('uuid', $userWk->uuid ?? '') }}">
                        @endif
                        <input type="hidden" name="address_uuid" value="{{ old('address_uuid', $addressWk->uuid ?? ($userWk->address_uuid ?? '')) }}">
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input id="first_name" name="first_name" type="text" class="validate"
                                    value="{{ old('first_name', $userWk->first_name ?? '') }}" required>
                                <label for="first_name">Nombre *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="sub_name" name="sub_name" type="text" class="validate"
                                    value="{{ old('sub_name', $userWk->sub_name ?? '') }}" required>
                                <label for="sub_name">Primer apellido *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="last_name" name="last_name" type="text" class="validate"
                                    value="{{ old('last_name', $userWk->last_name ?? '') }}">
                                <label for="last_name">Segundo apellido</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="email_address" name="email_address" type="email" class="validate"
                                    value="{{ old('email_address', $userWk->email_address ?? '') }}" required>
                                <label for="email_address">Email *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="phone_number" name="phone_number" type="text" class="validate"
                                    value="{{ old('phone_number', $userWk->phone_number ?? '') }}">
                                <label for="phone_number">Telefono *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <select id="type" name="type" required>
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    @foreach($types ?? [] as $label => $value)
                                    <option value="{{ $value }}" @selected(old('type', $userWk->type ?? '') == $value)>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                <label>Tipo *</label>
                            </div>

                             <div class="input-field col s12 m6 l4">
                                <input id="password" name="password" type="password" class="validate" {{ $isEdit ? '' : 'required' }}>
                                <label for="password">Contrasena {{ $isEdit ? '' : '*' }}</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="password_confirmation" name="password_confirmation" type="password" class="validate" {{ $isEdit ? '' : 'required' }}>
                                <label for="password_confirmation">Confirmar contrasena {{ $isEdit ? '' : '*' }}</label>
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px;">
                            <div class="col s12">
                                <h6 style="font-weight:800;margin:6px 0 10px;">Direccion</h6>
                                <div class="divider" style="margin-bottom:14px;"></div>
                            </div>

                            <div class="input-field col s12 m8 l4">
                                <input id="address" name="address" type="text" class="validate"
                                    value="{{ old('address', $addressWk->address ?? '') }}" required>
                                <label for="address">Direccion *</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="number" name="number" type="text" class="validate"
                                    value="{{ old('number', $addressWk->number ?? '') }}">
                                <label for="number">Numero</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="postalCode" name="postalCode" type="text" class="validate"
                                    value="{{ old('postalCode', $addressWk->postalCode ?? '') }}">
                                <label for="postalCode">Codigo postal</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="city" name="city" type="text" class="validate"
                                    value="{{ old('city', $addressWk->city ?? '') }}">
                                <label for="city">Ciudad</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="state" name="state" type="text" class="validate"
                                    value="{{ old('state', $addressWk->state ?? '') }}">
                                <label for="state">Estado / Provincia</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="country" name="country" type="text" class="validate"
                                    value="{{ old('country', $addressWk->country ?? '') }}">
                                <label for="country">Pais</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="district" name="district" type="text" class="validate"
                                    value="{{ old('district', $addressWk->district ?? '') }}">
                                <label for="district">Distrito / Barrio</label>
                            </div>

                            <div class="input-field col s12 l4">
                                <input id="complement" name="complement" type="text" class="validate"
                                    value="{{ old('complement', $addressWk->complement ?? '') }}">
                                <label for="complement">Complemento (apto/piso/referencia)</label>
                            </div>

                            <div class="input-field col s12">
                                <textarea id="notes" name="notes" class="materialize-textarea">{{ old('notes', $addressWk->notes ?? '') }}</textarea>
                                <label for="notes">Notas</label>
                            </div>
                        </div>

                        <div class="row" style="margin-top:18px;">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light"
                                    style="background-color: var(--color-button);"
                                    type="submit">
                                    {{ $isEdit ? 'Guardar cambios' : 'Guardar' }}
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const elems = document.querySelectorAll('select');
        M.FormSelect.init(elems, {});

        @if($errors->any())
        showToastComponent("{{ $errors->first() }}", null, 'error');
        @elseif(session('message'))
        showToastComponent("{{ session('message') }}", null, null);
        @elseif(session('error'))
        showToastComponent("{{ session('error') }}", null, 'error');
        @endif
    });
</script>
@endpush