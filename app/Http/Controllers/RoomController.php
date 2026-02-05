<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\ModelsBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    /**
     * Show rooms related to the current hotel.
     */
    public function roomIndex(Request $request, string $token)
    {
        $userWk = Session::get('user');
        $hotelUUID = $userWk->hotel_uuid ?? null;
        $date = $request->query('date');
        if (!empty($date)) {
            $data = Room::getSummaryByHotelAndDate($hotelUUID, $date);
            $data['selectedDate'] = $date;
        } else {
            $data = Room::getSummaryByHotel($hotelUUID);
            $data['selectedDate'] = null;
        }
        return view('clients.rooms.rooms_index', $data);
    }


    public function getAllRooms(string $token){
        $userWk = Session::get('user');
        $hotelUUID = $userWk->hotel_uuid ?? null;
        $rooms = Room::getByHotelPaginated($hotelUUID, 12);
        $data = [
            "rooms" => $rooms,
        ];
        return view('clients.rooms.list_all_rooms', $data);
    }

    /**
     * Show create or edit room form.
     */
    public function createOrEditRoomIndex(Request $request, string $token, ?string $uuid = null)
    {
        $room = new Room();
        $data = [
            'statuses' => [
                Room::STATUS_VL => 'VL - Vacante limpia',
                Room::STATUS_VS => 'VS - Vacante sucia',
                Room::STATUS_FDU => 'FDU - Fuera de uso',
            ],
            'beds' => [
                Room::BED_QUEEN => 'Cama Queen', // CAMA Queen
                Room::BED_king => 'Cama King', // CAMA King
                Room::BED_TWIN => 'Cama Twin', // CAMA Twin
                Room::BED_DOBLE => 'Cama Doble', // CAMA Doble
            ]
        ];

        $roomUUID = $uuid ?? $request->uuid;
        if ($roomUUID) {
            $roomWk = $room->getSpecificRoom($roomUUID);
            if ($roomWk == null) {
                return redirect()->route('errorPage')->with([
                    'route' => route('getAllRooms', $token),
                    'message' => 'Error: no se han encontrado habitaciones. Por favor inténtalo más tarde.',
                ]);
            }
            $data['roomWk'] = $roomWk;
            $data['isEdit'] = true;
            $data['formAction'] = route('updateRoom', ['token' => $token, 'uuid' => $roomWk->uuid]);
            $data['formMethod'] = 'PUT';
        } else {
            $data['isEdit'] = false;
            $data['formAction'] = route('storeRoom', ['token' => $token]);
            $data['formMethod'] = 'POST';
        }


        return view('clients.rooms.create_or_edit_rooms', $data);
    }

    /**
     * Store a newly created room.
     */
    public function store(Request $request, string $token)
    {
        $currentUser = Session::get('user');
        if (!$currentUser || empty($currentUser->hotel_uuid)) {
            return redirect()->route('errorPage')->with([
                'route' => route('login'),
                'message' => 'Error: sesión no válida. Por favor inicia sesión nuevamente.',
            ]);
        }

        $rules = [
            'name' => 'required|string',
            'number' => 'required|string',
            'status' => 'required|string',
            'people_count' => 'required|integer|min:1',
            'beds_count' => 'required|integer|min:1',
            'bed_type' => 'required|string',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'number.required' => 'El número es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'people_count.required' => 'El número de personas es obligatorio.',
            'beds_count.required' => 'El número de camas es obligatorio.',
            'bed_type.required' => 'El tipo de cama es obligatorio.',
        ];

        $data = $request->validate($rules, $messages);
        $data['uuid'] = ModelsBase::createuuid();
        $data['hotel_uuid'] = $currentUser->hotel_uuid;

        $room = new Room();
        $room->fill($data);
        $room->save();

        return redirect()->route('getAllRooms', $token)->with([
            'message' => 'Habitación creada con éxito.',
        ]);
    }

    /**
     * Update room by uuid.
     */
    public function update(Request $request, string $token, string $uuid)
    {
        $room = new Room();
        $roomWk = $room->getSpecificRoom($uuid);
        if (!$roomWk) {
            return redirect()->route('errorPage')->with([
                'route' => route('getAllRooms', $token),
                'message' => 'Error: no se han encontrado habitaciones. Por favor inténtalo más tarde.',
            ]);
        }

        $rules = [
            'name' => 'required|string',
            'number' => 'required|string',
            'status' => 'required|string',
            'people_count' => 'required|integer|min:1',
            'beds_count' => 'required|integer|min:1',
            'bed_type' => 'required|string',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'number.required' => 'El número es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'people_count.required' => 'El número de personas es obligatorio.',
            'beds_count.required' => 'El número de camas es obligatorio.',
            'bed_type.required' => 'El tipo de cama es obligatorio.',
        ];

        $data = $request->validate($rules, $messages);
        $roomWk->fill($data);
        $roomWk->save();

        return redirect()->route('getAllRooms', $token)->with([
            'message' => 'Habitación actualizada con éxito.',
        ]);
    }
}
