<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    protected $table = 'room_reservations';

    public const STATUS_BOOKED = 'booked';
    public const STATUS_CHECKED_IN = 'checked_in';
    public const STATUS_CHECKED_OUT = 'checked_out';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * @var list<string>
     */
    public $fillable = [
        'uuid',
        'room_uuid',
        'hotel_uuid',
        'travel_uuid',
        'booking_uuid',
        'check_in',
        'check_out',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'int',
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    public function scopeActiveOnDate($query, string $date)
    {
        return $query->where('check_in', '<=', $date)
            ->where('check_out', '>=', $date)
            ->whereIn('status', [self::STATUS_BOOKED, self::STATUS_CHECKED_IN]);
    }

    public function scopeForHotel($query, string $hotelUUID)
    {
        return $query->where('hotel_uuid', $hotelUUID);
    }
}
