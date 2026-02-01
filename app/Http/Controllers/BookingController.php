<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ModelsBase;
use Illuminate\Http\Request;
use ICal\ICal;
use Illuminate\Support\Facades\Response;

class BookingController extends Controller
{
    /*
    * Return view home 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function bookingIndex() {
        $booking = new Booking();  
        $data = [
            "allBookingWk" =>json_encode($booking->getAllFormatted()),
        ];
        return view("clients.booking.booking_index", $data);
    }

    /**
     * Registra una nueva reserva o edita una existente según el UUID recibido.
     *
     * Este método valida los datos recibidos mediante una solicitud HTTP y determina si debe:
     * - Editar una reserva existente (si se proporciona un UUID válido).
     * - Crear una nueva reserva (si no se proporciona UUID).
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * Validaciones incluidas:
     * - name: requerido, texto
     * - email: opcional, texto
     * - phone: opcional, texto
     * - total: requerido, numérico, mínimo 0
     * - entry_date / final_date: requeridos, texto (se convierten luego a DateTime al crear)
     * - travels: requerido, numérico, mínimo 1
     * - notes: opcional, texto
     * - origen_type y room_selected: requeridos, texto
     *
     * Respuestas posibles:
     * - En caso de validación fallida: JSON con `success => false` y mensaje de error genérico.
     * - Si se edita una reserva correctamente: actualiza y devuelve todas las reservas.
     * - Si se crea una nueva reserva: se genera un UUID, se convierten las fechas y se guarda.
     * - En ambos casos exitosos: JSON con `success => true`, mensaje y lista de reservas.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerOrEdit(Request $request){
        $arrayInput = [];
          try {
          $arrayInput = $request->validate([
                'name'       =>  'required|string',
                'email'      =>  'nullable|string',
                'phone'      =>  'nullable|string',
                'total'      =>  'required|numeric|min:0', 
                'entry_date' =>  'required|string',
                'final_date' =>  'required|string',
                'travels'    =>  'required|numeric|min:1', 
                'notes'      =>  'nullable|string',
                'origen_type'=>  'required|string',
                'room_selected'=> 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => ucfirst('Algo Salio mal, por favor intentelo mas tarde')
            ], 200); 
        }
        $booking = new Booking();
        if($request->uuid != null){
            $bookingWk = $booking->getSpecificBooking(uuid:$request->uuid);
            if($bookingWk != null){
                $bookingWk->name = $arrayInput['name'];
                $bookingWk->email = $arrayInput['email'];
                $bookingWk->phone = $arrayInput['phone'];
                $bookingWk->total = $arrayInput['total']; 
                $bookingWk->entry_date = $arrayInput['entry_date'];
                $bookingWk->final_date = $arrayInput['final_date'];
                $bookingWk->travels = $arrayInput['travels'];
                $bookingWk->notes = $arrayInput['notes'] ?? null;
                $bookingWk->origen_type = $arrayInput['origen_type'];
                $bookingWk->room_selected = $arrayInput['room_selected'];
                $bookingWk->save();
            }else{
                return response()->json([
                    'success' => false,
                    'message' => ucfirst('No se Encontro la reserva, por favor intentelo mas tarde')
                ], 200); 
            }   
        }else{
            $arrayInput['uuid'] = ModelsBase::createuuid();
            $arrayInput['entry_date'] = \DateTime::createFromFormat('Y-m-d', $arrayInput['entry_date']);
            $arrayInput['final_date'] = \DateTime::createFromFormat('Y-m-d', $arrayInput['final_date']);
            $bookingWk = new Booking($arrayInput);
            $bookingWk->save();
        }
        $allBooking = $booking->getAllFormatted();
        return response()->json([
            'success' => true,
            'message' => ucfirst('Creado con Suceso'),
            'value' =>  $allBooking
        ], 200); 
    }



    /**
     * Importa reservas desde el calendario iCal de Booking.com y las guarda en la base de datos.
     *
     * Este método accede al archivo iCal público proporcionado por Booking.com, lo analiza
     * y extrae los eventos (reservas) que contiene. Por cada evento:
     * - Se calcula la fecha de entrada (`dtstart`) y de salida (`dtend` - 1 día),
     *   ya que Booking incluye el día de checkout como `dtend`.
     * - Se evita crear reservas duplicadas verificando si ya existe una reserva
     *   con las mismas fechas y tipo de origen (`booking`).
     * - Si no existe, se crea una nueva entrada en la tabla `Booking`.
     *
     * Nota: Puedes mejorar la lógica para detectar duplicados usando campos adicionales como `UID`
     * o `SUMMARY`, si están disponibles en el feed iCal.
     *
     * @return \Illuminate\Http\JsonResponse Respuesta JSON indicando éxito.
     */
    public function importToBooking($token){
        if ($token !== env('SYNC_TOKEN')) {
            abort(403, 'Token inválido');
        }
        $ical = new ICal('https://calendar.booking.com/ical/tu-hotel.ics');
        foreach ($ical->events() as $evento) {
            $inicio = date('Y-m-d', strtotime($evento->dtstart));
            $fin = date('Y-m-d', strtotime($evento->dtend . ' -1 day')); // Booking incluye el checkout
            // Evita duplicados (puedes usar UID, resumen, o fechas como referencia)
            $existe = Booking::where('entry_date', $inicio)
                ->where('final_date', $fin)
                ->where('origen_type', 'booking')
                ->exists();

            if (!$existe) {
                Booking::create([
                    'name' => 'Reserva Booking',
                    'origen_type' => 'booking',
                    'entry_date' => $inicio,
                    'final_date' => $fin,
                    'room_selected' => '#90A4AE', // Puedes asignar por lógica
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Genera y exporta un archivo iCalendar (.ics) con todas las reservas registradas.
     *
     * Este método recopila todas las reservas desde la base de datos y construye un contenido
     * en formato iCalendar (versión 2.0), incluyendo un evento por cada reserva.
     *
     * Para cada evento se incluyen:
     * - UID único (usando el UUID de la reserva o un ID generado).
     * - Un resumen (SUMMARY) con el nombre del cliente.
     * - La fecha de inicio (DTSTART) y de finalización (DTEND) de la reserva.
     *   *Nota:* La fecha final se incrementa en un día porque el estándar iCal
     *   considera la fecha de finalización como exclusiva.
     *
     * El contenido generado se devuelve como una respuesta HTTP con cabeceras apropiadas
     * para que el navegador lo reconozca como un archivo de calendario descargable o embebible.
     *
     * @return \Illuminate\Http\Response Archivo .ics con las reservas en formato iCalendar.
     */
    public function exportICal($token){
          // Validar token
        if ($token !== env('SYNC_TOKEN')) {
            abort(403, 'Token inválido');
        }
        $allBooking = Booking::all();
        $lines = [
            "BEGIN:VCALENDAR",
            "VERSION:2.0",
            "PRODID:-//Cielo de Cebreros Booking//iCal Export//ES"
        ];

        foreach ($allBooking as $booking) {
            $lines[] = "BEGIN:VEVENT";
            $lines[] = "UID:" . $booking->uuid ?? uniqid();
            $lines[] = "SUMMARY:booking de {$booking->name}";
            $lines[] = "DTSTART:" . date('Ymd', strtotime($booking->entry_date));
            $lines[] = "DTEND:" . date('Ymd', strtotime($booking->final_date . ' +1 day')); // iCal usa end exclusivo
            $lines[] = "END:VEVENT";
        }
        $lines[] = "END:VCALENDAR";
        $contenido = implode("\r\n", $lines);
        return Response::make($contenido, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'inline; filename="calendario.ics"'
        ]);
    }


    /**
     * Elimina una reserva (Booking) a partir de su UUID.
     *
     * @param \Illuminate\Http\Request $request
     *        - uuid (string): UUID de la reserva que se desea eliminar.
     *
     * @return \Illuminate\Http\JsonResponse
     *         success (bool) :  Indica si la operación se completó con éxito.
     *         message (string): Mensaje descriptivo de la operación.
     *         value   (array) : Lista formateada de todas las reservas (solo cuando success = true).
     */
    public function deleteSpecificBooking(Request $request){
        $booking = new Booking();
        if($request->uuid != null){
           
            $bookingWk = $booking->getSpecificBooking(uuid:$request->uuid);
            if($bookingWk != null){
                $bookingWk->delete();
                $allBooking = $booking->getAllFormatted();
                return response()->json([
                    'success' => true,
                    'message' => ucfirst('Eliminado con Suceso'),
                    'value' =>  $allBooking
                ], 200); 
            }
        }
        return response()->json([
            'success' => false,
            'message' => ucfirst('No se Encontro la reserva, por favor intentelo mas tarde')
        ], 200); 
    }
}
