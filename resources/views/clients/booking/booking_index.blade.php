@extends('main')
@section('showSearch', false)

@section('title', 'Parte de viajero')
<style>
    td{
        font-size: 12px;
        padding: 5px 5px !important;
    }
</style>
@section('content')
    <!-- Section: Stats Table  -->
     <div class="container">
        <section class="section section-stats center">
            <div class="row">
                <div class="col s12 m12 l12 lx12">
                    <h3 class="center" >Calendario</h3>
                </div>
            </div>
            <div id='calendar'></div>
             <div class="col s12 m6 l6 lx6">
                     <ul class="collection transparent">
                        <li class="collection-item avatar">
                            <i style="background-color:#1E88E5;" class="material-icons circle white-text">home</i>
                            <span class="title">Burro Tapón</span>
                        </li>
                        <li class="collection-item avatar">
                            <i style="background-color:#43A047;" class="material-icons circle white-text">home</i>
                            <span class="title">Ciervo del Castañar</span>
                        </li>
                        <li class="collection-item avatar">
                            <i style="background-color:#8E24AA;" class="material-icons circle white-text">home</i>
                            <span class="title">Árbol de la Vida</span>
                        </li>
                          <li class="collection-item avatar">
                            <i style="background-color:#90A4AE;" class="material-icons circle white-text">home</i>
                            <span class="title">Habitación no asignada</span>
                        </li>

                        
                    </ul>
                </div>
        </section>
    </div>
<!-- MODAL CONFIRMATION DELETE TRAVEL-->
    <div id="modal-booking" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Confirmación de Reserva</h4>
            <div class="row">
                <div class="input-field col s6 m6 l6 lx6">
                    <select id="room-selected">
                        <!-- <option class="option-label-select-materialize" value="" selected>Seleccionar Cuarto</option> -->
                        <option value="#1E88E5">Burro Tapón</option>
                        <option value="#43A047">Ciervo del Castañar</option>
                        <option value="#8E24AA">Árbol de la Vida</option>
                        <option value="#90A4AE">Habitación no asignada</option>
                    </select>
                    <label class="label-select-materialize">Seleccionar cuarto</label>
                </div> 
                <div class="input-field col s6 m6 l6 lx6">
                    <select id="quantity-person">
                        <!-- <option class="option-label-select-materialize" value="" selected>Seleccionar cantidad de personas</option> -->
                        <option value="1">1 persona</option>
                        <option value="2">2 personas</option>
                    </select>
                    <label class="label-select-materialize">Seleccionar cantidad de personas</label>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                    <input value="" type="text" id="name" required class="validate" />
                    <label  for="name">Nombre *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s12 m6 l6 lx6">
                     <input type="number" id="price-total" required step="0.01" />
                    <label for="price-total">Precio *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                 <div class="input-field col s12 m6 l6 lx6">
                    <input name="email-address" required type="text" id="email-address" class="validate" />
                    <label for="email-address">E-mail</label>
                </div>
                 <div class="input-field col s12 m6 l6 lx6">
                    <input name="phone-number" required type="text" id="phone-number" class="validate" />
                    <label for="phone-number">Telefono</label>
                </div>
                <div class="input-field col s6 m4 l4 lx4">
                    <input type="date" required id="entry_date" disabled class="validate" />
                    <label for="entry_date">Fecha de Entrada *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s6 m4 l4 lx4">
                    <input type="date" required id="final_date" class="validate" />
                    <label for="final_date">Fecha de Salida *</label>
                    <span class="helper-text" data-error="Campo obligatorio" data-success=""></span>
                </div>
                <div class="input-field col s6 m6 l4 lx4">
                    <select id="origen-type">
                        <!-- <option class="option-label-select-materialize" value="" selected>Seleccionar origen de reserva</option> -->
                        <option value="pagina-web">Pagina Web</option>
                        <option value="email">Email</option>
                        <option value="phone">Telefono</option>
                        <option value="booking">Booking</option>
                        <option value="otro">Otro</option>
                    </select>
                    <label class="label-select-materialize">Origen de reserva</label>
                </div>
            </div>  
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-grey black-text btn-flat">Cancelar</a>
            <a id="confirm-button-booking"  onclick="registerOrEditBooking()" class="waves-effect waves-grey green-text btn-flat">Guardar</a>
            <a id="confirm-button-delete-booking" onclick="deleteBooking()" class="waves-effect waves-red red-text btn-flat">Eliminar</a>
        </div>
    </div>
@endsection

@push('scripts')
<!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        var allEvents = '{{ $allBookingWk }}';
        allEvents = allEvents.replace(/&quot;/g, '"'); // Reemplaza &quot; por "
        allEvents = JSON.parse(allEvents);
        // Hacerlo global
        let calendar;
        document.addEventListener('DOMContentLoaded', function () {
    // INITIAL MODAL
        initalModal();
    // INITIAL SELECT
        initialSelectMaterialize();
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // vista semanal con horas
            locale: 'es',
            events: allEvents,
    // tu ruta Laravel que devuelve JSON
            headerToolbar: {
                // left: 'prev,next today',
                // center: 'title',
                // right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dateClick: function(info) {
                 // 1) Obtener TODOS los eventos del calendario
                const eventsSameDay = calendar.getEvents().filter(event => {
                    // Para eventos de varios días, FullCalendar suele guardar end
                    // en el día siguiente a las 00:00.  
                    // Comprobamos que el día clicado esté dentro del rango [start, end)
                    const start = event.start;                    // Date
                    const end   = event.end || event.start;       // Date (por si end es null)

                    // Normalizamos a medianoche para comparar sólo la parte de la fecha
                    const clicked = new Date(info.dateStr + 'T00:00:00');
                    const startDay = new Date(start);
                    startDay.setHours(0, 0, 0, 0);

                    const endDay = new Date(end);
                    endDay.setHours(0, 0, 0, 0);
                    // true si clicked ∈ [startDay, endDay)
                    return clicked >= startDay && clicked < endDay;
                });
                // 2) ¿Hay tres o más?
                if (eventsSameDay.length >= 3) {
                    showToastComponent(`Ya has alcanzado el máximo de reservas para este día -.${info.dateStr}`, null ,'notification');
                return; // opcional: corta aquí si no quieres abrir el modal
                }
                // Colores/habitaciones ocupadas ese día
                const busyRooms = eventsSameDay.map(e => e.backgroundColor);

                /* ========== 2. Habilitar / deshabilitar opciones ========== */
                const selectEl = document.getElementById('room-selected');

                // a) Habilitar todas primero
                selectEl.querySelectorAll('option').forEach(opt => {
                opt.disabled = false;
                });

                // b) Deshabilitar las ocupadas
                busyRooms.forEach(color => {
                    const opt = selectEl.querySelector(`option[value="${color}"]`);
                    if (opt) opt.disabled = true;
                });
                // c) (Materialize) Reinicializar el select para que se refleje el cambio
                const instance = M.FormSelect.getInstance(selectEl);
                if (instance) {
                    instance.destroy();            // eliminar instancia vieja
                    initialSelectMaterialize();
                    // M.FormSelect.init(selectEl);   // crear nueva
                }
                cleanInput();
                let entryDate = document.getElementById('entry_date').value = info.dateStr;
                document.getElementById('confirm-button-delete-booking').style.display = "none";
                const entryDateObj = new Date(entryDate);
                entryDateObj.setDate(entryDateObj.getDate() + 1);
                const finalDate = entryDateObj.toISOString().split('T')[0];
                // Establecer final_date con valor + mínimo permitido
                const finalInput = document.getElementById('final_date');
                finalInput.value = finalDate;
                finalInput.min = entryDate;
                var modal = M.Modal.getInstance(document.getElementById('modal-booking'));
                let buttonSaveNewBooking = document.getElementById('confirm-button-booking');
                buttonSaveNewBooking.setAttribute('data-new-booking', true);
                modal.open();
            },
            eventClick: function(info) {
                const evento = info.event;
                const endDate = new Date(evento.endStr);
                endDate.setDate(endDate.getDate() - 1);
                const finalDateFormatted = endDate.toISOString().split('T')[0];
                document.getElementById('final_date').value = finalDateFormatted;
                document.getElementById('final_date').min = evento.startStr.substring(0, 10);
                document.getElementById('entry_date').value = evento.startStr.substring(0, 10);
                document.getElementById('name').value = evento.extendedProps.name;
                document.querySelector('label[for="name"]').classList.add('active');
                document.getElementById('email-address').value = evento.extendedProps.email;
                document.getElementById('phone-number').value = evento.extendedProps.phone;
                document.getElementById('room-selected').value = evento.extendedProps.room_selected;
                document.getElementById('quantity-person').value = evento.extendedProps.travels;
                document.getElementById('price-total').value = evento.extendedProps.total; 
                document.querySelector('label[for="price-total"]').classList.add('active');
                document.getElementById('origen-type').value = evento.extendedProps.origen_type; 
                document.getElementById('confirm-button-delete-booking').style.display = "";
                let buttonSaveNewBooking = document.getElementById('confirm-button-booking');
                buttonSaveNewBooking.setAttribute('data-new-booking', false);
                buttonSaveNewBooking.setAttribute('data-uuid', evento.extendedProps.uuid);
                var modal = M.Modal.getInstance(document.getElementById('modal-booking'));
                modal.open();
            }
        });
        calendar.render();
    });


    function registerOrEditBooking(){
        let name = document.getElementById('name').value.trim();
        let emailAddress = document.getElementById('email-address').value.trim();
        let phoneNumber = document.getElementById('phone-number').value.trim();
        let roomSelected = document.getElementById('room-selected').value.trim();
        let quantityPerson = document.getElementById('quantity-person').value.trim();
        let price = document.getElementById('price-total').value.trim(); 
        let entryDate = document.getElementById('entry_date').value.trim(); 
        let finalDate = document.getElementById('final_date').value.trim(); 
        let origenType = document.getElementById('origen-type').value.trim(); 
        let buttonSaveNewBooking = document.getElementById('confirm-button-booking');
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let newBooking = buttonSaveNewBooking.getAttribute('data-new-booking');
        if (!roomSelected) {
            showToastComponent("Por favor Seleccione una habitación", null ,'error');
            return; 
        }
        if (!quantityPerson) {
            showToastComponent("Por favor Seleccione una cantidad de personas soportadas", null ,'error');
            return; 
        }
        if (!name) {
            showToastComponent("Por favor ingresar un nombre valido", null ,'error');
            return; 
        }
        if (!price) {
            showToastComponent("Por favor ingresar un precio valido", null ,'error');
            return; 
        }
        if (emailAddress) {
            if (!emailRegex.test(emailAddress)) {
                showToastComponent("Por favor colocar un correo electronico valido", null ,'error');
                return; 
            }
        }
        if (!entryDate) {
            showToastComponent("Por favor ingresar una fecha de entrada valida", null ,'error');
            return; 
        }
        if (!finalDate) {
            showToastComponent("Por favor ingresar una fecha de salida valida", null ,'error');
            return; 
        }
        if (!origenType) {
            showToastComponent("Por favor ingresar el origen de la reserva", null ,'error');
            return; 
        }
        const url = "{{route('registerOrEdit', Session::get('user')->uuid) }}";
        const formData = new FormData();
        formData.append('isNew',newBooking);
        formData.append('name',name);
        formData.append('origen_type',origenType);
        formData.append('email',emailAddress);
        formData.append('phone',phoneNumber);
        formData.append('total', price); 
        formData.append('entry_date',entryDate);
        formData.append('final_date',finalDate);
        formData.append('travels',quantityPerson);
        formData.append('room_selected',roomSelected);
        if(newBooking == 'false'){
         formData.append('uuid', buttonSaveNewBooking.getAttribute('data-uuid'));   
        }

        return ajaxRequest(url, "POST", formData, 
        // success
        function(response) {
            if (response.success === false) {
                showToastComponent(response.message, null,'error');
                return;
            }
            allEvents = response.value;
            var modal = M.Modal.getInstance(document.getElementById('modal-booking'));
            calendar.removeAllEvents();       // Limpia los eventos actuales
            calendar.addEventSource(allEvents); // Vuelve a cargar desde tu nueva lista
            calendar.render();            
            modal.close();
            console.log(response.value);
            cleanInput();  
        }, 
        // error
        function(response) {});
  
    }

    function cleanInput(){
        document.getElementById('name').value = '';
        document.getElementById('email-address').value = '';
        document.getElementById('phone-number').value = '';
        // document.getElementById('room-selected').value = '';
        // document.getElementById('quantity-person').value = '';
        document.getElementById('price-total').value = ''; 
        // document.getElementById('entry_date').value = ''; 
        // document.getElementById('final_date').value = ''; 
        // document.getElementById('origen-type').value = ''; 
    }

    function deleteBooking(){
        let buttonSaveNewBooking = document.getElementById('confirm-button-booking');
        const url = "{{route('deleteSpecificBooking', Session::get('user')->uuid) }}";
        const formData = new FormData();
        formData.append('uuid', buttonSaveNewBooking.getAttribute('data-uuid'));   

        return ajaxRequest(url, "POST", formData, 
        // success
        function(response) {
            if (response.success === false) {
                showToastComponent(response.message, null,'error');
                return;
            }
            allEvents = response.value;
            calendar.removeAllEvents();       // Limpia los eventos actuales
            calendar.addEventSource(allEvents); // Vuelve a cargar desde tu nueva lista
            calendar.render();
            var modal = M.Modal.getInstance(document.getElementById('modal-booking'));
            modal.close();
        }, 
        // error
        function(response) {});
  
    }


    </script>
@endpush
