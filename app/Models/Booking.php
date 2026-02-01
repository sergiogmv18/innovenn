<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $table = 'booking';
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    public $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'total', 
        'entry_date',
        'final_date',
        'travels',
        'notes',
        'origen_type',
        'room_selected'
    ];

    /**
     * Los atributos que deben ocultarse en la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
    
    ];

    /**
     * Obtener los atributos que deben ser casteados.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'int',
            'uuid' => 'string',
        ];
    }

    /**
     * Get all Booking
     * 
     * 
     * @return
     */
    public function getAll(){
        return $this::orderBy('id', 'desc')->get();
    }





     /**
     * Get Specific Booking
     * @param string $uuid
     * @return Booking|null if uuid no exist
     */
    public function getSpecificBooking(string $uuid) {
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $booking = $this::where('uuid', $uuid)->first();
        if ($booking) {
            return $booking;
        }
    
        return null;
    }

    /**
     * Obtiene todas las reservas formateadas para el calendario FullCalendar.
     *
     * Este método consulta todas las reservas ordenadas por ID descendente,
     * y las transforma en un formato compatible con FullCalendar, incluyendo:
     * - título: nombre del cliente + origen (web, booking, etc.)
     * - email: correo electrónico del cliente
     * - start: fecha de entrada (entry_date)
     * - end: fecha de salida +1 día (para incluir el último día completo)
     * - color: color de la habitación seleccionada (room_selected)
     *
     * @return \Illuminate\Support\Collection Colección de eventos formateados para calendario
     */
    public function getAllFormatted()
{
    return $this::orderBy('id', 'desc')->get()->map(function ($booking) {
        return [
            'title' => $booking->name . ' - ' . $booking->origen_type.' -'.$booking->travels.' per ('.$booking->total.')' ,
            'uuid'=> $booking->uuid,
            'name'=> $booking->name,
            'phone'=> $booking->phone,
            'total'=> $booking->total, 
            'final_date'=> $booking->final_date,
            'travels'=> $booking->travels,
            'origen_type'=> $booking->origen_type,
            'room_selected'=> $booking->room_selected,
            'email' => $booking->email,
            'start' => $booking->entry_date,
            'end'   => date('Y-m-d', strtotime($booking->final_date . ' +1 day')),
            'color' => $booking->room_selected ?? '#90A4AE', // color por defecto si no hay
        ];
    });
}
    


}
