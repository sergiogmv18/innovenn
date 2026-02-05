@php
use App\Models\Room;
@endphp
@extends('main')
@section('showSearch', false)


@section('title', $isEdit ? 'Editar Habitación' : 'Crear Habitación')

<style>
    .page-wrap {
        background: var(--only-background-color);
        min-height: 100vh;
        padding: 26px;
    }
    .card {
        border-radius: var(--border-radius) !important;
    }
    .hint {
        font-size: 12px;
        color: rgba(0, 0, 0, .45);
    }
</style>

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col s12">
            <h5 style="font-weight:800;margin:0;">{{ $isEdit ? 'Editar habitación' : 'Crear habitación' }}</h5>
            <p class="grey-text" style="margin-top:6px;">
                {{ $isEdit ? 'Actualiza los datos de la habitación' : 'Completa los datos para registrar una habitación' }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card white z-depth-1">
                <div class="card-content">
                    <form id="room-form" method="POST" action="{{ $formAction }}">
                        @csrf
                        @if($formMethod !== 'POST')
                        @method($formMethod)
                        @endif
                        @if($isEdit)
                        <input type="hidden" name="uuid" value="{{ old('uuid', $roomWk->uuid ?? '') }}">
                        @endif

                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input id="name" name="name" type="text" class="validate"
                                    value="{{ old('name', $roomWk->name ?? '') }}" required>
                                <label for="name">Nombre *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="number" name="number" type="text" class="validate"
                                    value="{{ old('number', $roomWk->number ?? '') }}" required>
                                <label for="number">Número *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <select id="status" name="status" required>
                                    <option value=""disabled selected>Selecciona un estado</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('status', $roomWk->status ?? Room::STATUS_VL) == $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Estado *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="people_count" name="people_count" type="number" min="1" class="validate"
                                    value="{{ old('people_count', $roomWk->people_count ?? 1) }}" required>
                                <label for="people_count">Nº Personas *</label>
                            </div>

                            <div class="input-field col s12 m6 l4">
                                <input id="beds_count" name="beds_count" type="number" min="1" class="validate"
                                    value="{{ old('beds_count', $roomWk->beds_count ?? 1) }}" required>
                                <label for="beds_count">Nº Camas *</label>
                            </div>


                            <div class="input-field col s12 m6 l4">
                                <select id="bed_type" name="bed_type" required>
                                    <option value=""disabled selected>Selecciona tipo de cama</option>
                                    @foreach($beds as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('bed_type', $roomWk->bed_type ??  Room::BED_DOBLE) == $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Tipo de cama *</label>
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
      // VERIFICAR QUE EL TIPO DE FACTURA ES ABONADA PARA MOSTRAR EL SELECCIONADOR DE RELACION DE FACTURAS
        initialSelectMaterialize();
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
