<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomReservation;

class Room extends Model
{
    protected $table = 'rooms';

    public const STATUS_VL = 'VL';  // Vacante Limpia
    public const STATUS_VS = 'VS';  // Vacante Sucia
    public const STATUS_OL = 'OL';  // Ocupada Limpia
    public const STATUS_OS = 'OS';  // Ocupada Sucia
    public const STATUS_OXS = 'OxS'; // Ocupada por salir
    public const STATUS_FDU = 'FDU'; // Fuera de Uso

    public const BED_QUEEN = 'Queen'; // CAMA Queen

    public const BED_king = 'King'; // CAMA King

    public const BED_TWIN = 'Twin'; // CAMA Twin

    public const BED_DOBLE = 'Doble'; // CAMA Doble



    /**
     * @var list<string>
     */
    public $fillable = [
        'uuid',
        'hotel_uuid',
        'name',
        'number',
        'status',
        'people_count',
        'beds_count',
        'bed_type',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'int',
            'uuid' => 'string',
            'people_count' => 'int',
            'beds_count' => 'int',
        ];
    }

    /**
     * Get rooms by hotel uuid ordered by room number.
     */
    public static function getByHotel(string $hotelUUID)
    {
        return static::where('hotel_uuid', $hotelUUID)
            ->orderBy('number')
            ->get();
    }

    /**
     * Get rooms by hotel uuid ordered by room number with pagination.
     */
    public static function getByHotelPaginated(string $hotelUUID, int $perPage = 20)
    {
        return static::where('hotel_uuid', $hotelUUID)
            ->orderBy('number')
            ->paginate($perPage);
    }

    /**
     * Get room list and status summary for a hotel.
     *
     * @return array{rooms:\Illuminate\Support\Collection, statusCounts:array, totalRooms:int, vacantCount:int, vacantPercent:float|int, occupiedCount:int, occupiedPercent:float|int, fduCount:int}
     */
    public static function getSummaryByHotel(string $hotelUUID): array
    {
        $rooms = static::getByHotel($hotelUUID);
        $statusCounts = $rooms->groupBy('status')->map(function ($group) { 
            return $group->count(); 
        })->all();
        $totalRooms = $rooms->count();
        $vacantCount = ($statusCounts[self::STATUS_VL] ?? 0) + ($statusCounts[self::STATUS_VS] ?? 0);
        $occupiedCount = ($statusCounts[self::STATUS_OL] ?? 0) + ($statusCounts[self::STATUS_OS] ?? 0) + ($statusCounts[self::STATUS_OXS] ?? 0);
        $fduCount = $statusCounts[self::STATUS_FDU] ?? 0;

        $vacantPercent = $totalRooms > 0 ? round(($vacantCount * 100) / $totalRooms, 2) : 0;
        $occupiedPercent = $totalRooms > 0 ? round(($occupiedCount * 100) / $totalRooms, 2) : 0;
        $fduPercent = $totalRooms > 0 ? round(($fduCount * 100) / $totalRooms, 2) : 0;

        return [
            'rooms' => $rooms,
            'statusCounts' => $statusCounts,
            'totalRooms' => $totalRooms,
            'vacantCount' => $vacantCount,
            'vacantPercent' => $vacantPercent,
            'occupiedCount' => $occupiedCount,
            'occupiedPercent' => $occupiedPercent,
            'fduCount' => $fduCount,
            'fduPercent' => $fduPercent,
        ];
    }

    /**
     * Get rooms summary for a specific date.
     */
    public static function getSummaryByHotelAndDate(string $hotelUUID, string $date): array
    {
        $rooms = static::where('hotel_uuid', $hotelUUID)
            ->orderBy('number')
            ->get();

        $reservations = RoomReservation::forHotel($hotelUUID)
            ->activeOnDate($date)
            ->get()
            ->groupBy('room_uuid');

        $statusCounts = [];
        foreach ($rooms as $room) {
            $effectiveStatus = static::getEffectiveStatusForDate($room, $reservations->get($room->uuid), $date);
            $room->effective_status = $effectiveStatus;
            $statusCounts[$effectiveStatus] = ($statusCounts[$effectiveStatus] ?? 0) + 1;
        }

        $totalRooms = $rooms->count();
        $vacantCount = ($statusCounts[self::STATUS_VL] ?? 0) + ($statusCounts[self::STATUS_VS] ?? 0);
        $occupiedCount = ($statusCounts[self::STATUS_OL] ?? 0) + ($statusCounts[self::STATUS_OS] ?? 0) + ($statusCounts[self::STATUS_OXS] ?? 0);
        $fduCount = $statusCounts[self::STATUS_FDU] ?? 0;

        $vacantPercent = $totalRooms > 0 ? round(($vacantCount * 100) / $totalRooms, 2) : 0;
        $occupiedPercent = $totalRooms > 0 ? round(($occupiedCount * 100) / $totalRooms, 2) : 0;
        $fduPercent = $totalRooms > 0 ? round(($fduCount * 100) / $totalRooms, 2) : 0;

        $availableRooms = $rooms->filter(function ($room) {
            return in_array($room->effective_status, [self::STATUS_VL, self::STATUS_VS], true);
        });

        return [
            'rooms' => $availableRooms,
            'statusCounts' => $statusCounts,
            'totalRooms' => $totalRooms,
            'vacantCount' => $vacantCount,
            'vacantPercent' => $vacantPercent,
            'occupiedCount' => $occupiedCount,
            'occupiedPercent' => $occupiedPercent,
            'fduCount' => $fduCount,
            'fduPercent' => $fduPercent,
        ];
    }

    /**
     * Resolve operational status for a date.
     *
     * @param \Illuminate\Support\Collection|null $roomReservations
     */
    protected static function getEffectiveStatusForDate(self $room, $roomReservations, string $date): string
    {
        if ($room->status === self::STATUS_FDU) {
            return self::STATUS_FDU;
        }

        $reservation = $roomReservations ? $roomReservations->first() : null;
        if (!$reservation) {
            return in_array($room->status, [self::STATUS_VL, self::STATUS_VS], true) ? $room->status : self::STATUS_VL;
        }

        if ($reservation->check_out && $reservation->check_out->format('Y-m-d') === $date) {
            return self::STATUS_OXS;
        }

        return self::STATUS_OL;
    }

    /**
     * Get specific room by uuid.
     */
    public function getSpecificRoom(string $uuid)
    {
        if (empty($uuid)) {
            return null;
        }
        $room = $this::where('uuid', $uuid)->first();
        if ($room) {
            return $room;
        }
        return null;
    }
}
