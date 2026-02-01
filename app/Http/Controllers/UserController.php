<?php

namespace App\Http\Controllers;

use App\Models\BillingData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Travel;
use App\Models\Address;
use App\Models\ModelsBase;

class UserController extends Controller
{
    /**
     * All user releted with hotel.
     */
    public function allUserHome(Request $request) {
        $hotelUUID = Session::get('user')->hotel_uuid;
        if($hotelUUID == null){
            Auth::logout();
        // Eliminar cualquier dato de sesión relacionado con el usuario
            $request->session()->flush();
            return redirect()->route('errorPage')->with([
                'route' => route('login'),
                'message' => 'Error: no se han encontrado usuarios relacionados. Por favor, inicia sesión nuevamente o inténtalo más tarde.',
            ]);  
        }
        $user = new User();
        $allUser = $user->getAllUsersWithHotel(hotelUUID:$hotelUUID);
        $data = [
            "allUser" => $allUser,
        ];
        return view("clients.users.user_home", $data);
    } 



    /*
     * Return view home.
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @return <view>
     **/
    public function travelersRegisterHome() {
        $invoice = new Invoice();
        $travelModel = new Travel(); 
        $userWk = Session::get('user');
        $user = new User();
        $data = [
            "userRelatedWithHotel" => $user->getTotalUsersWithHotel($userWk->hotel_uuid) ?? 0,

            "allRegisteredCurrentYear" => $travelModel->getTotalCountCurrentYear(),
            "betsSellingRooms" => $travelModel->getQuantityAnualRegisted(),
            "quantityRegisted" => $travelModel->getTotalCount(),
            "user"=>Session::get('user'),
            "pendingRegister" => 0,
            "totalInvoiceValuePerMonth"=>$invoice->getTotalInvoiceValuePerMonth(),
            "totalSellAnual" =>  $invoice->getTotalValueForCurrentYear(),
        ];
        return view("clients.home", $data);
    }



    /*
     * Show create or edit user form.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return <view>
     */
    public function createOrEditUserIndex(Request $request, string $token, ?string $uuid = null)
    {
        $user = new User();
        $data = [
            "types" => $user->getAllTypeFormat(),
        ];
        $userUUID = $uuid ?? $request->uuid;
        if ($userUUID) {
            $userWk = $user->getSpecificUserWithUuid(uuid: $userUUID);
            if ($userWk == null) {
                return redirect()->route('errorPage')->with([
                    'route' => route('allUserHome', $token),
                    'message' => 'Error: no se han encontrado usuarios. Por favor intentalo mas tarde.',
                ]);
            }
            $data["userWk"] = $userWk->getDecryptDataOfUser();
            $addressWk = Address::where('uuid', $userWk->address_uuid)->first();
            if ($addressWk) {
                $data["addressWk"] = $addressWk->getDecryptDataOfAddress();
            }
            $data["formAction"] = route('updateUser', ['token' => $token, 'uuid' => $userWk->uuid]);
            $data["formMethod"] = 'PUT';
        } else {
            $data["formAction"] = route('storeUser', ['token' => $token]);
            $data["formMethod"] = 'POST';
        }
        return view("clients.users.create_or_edit_user", $data);
    }


    /*
     * Store a newly created user and address.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return <redirect>
     */
    public function store(Request $request, string $token)
    {
        $currentUser = Session::get('user');
        if (!$currentUser || empty($currentUser->hotel_uuid)) {
            return redirect()->route('errorPage')->with([
                'route' => route('login'),
                'message' => 'Error: sesion no valida. Por favor inicia sesion nuevamente.',
            ]);
        }

        $user = new User();
        $validation = $user->validateInput($request);
        if (!$validation['success']) {
            return back()->withErrors($validation['errors'])->withInput();
        }

        $address = new Address();
        $addressUUID = $request->input('address_uuid') ?: ModelsBase::createuuid();
        $addressData = [
            'uuid' => $addressUUID,
            'address' => $request->input('address'),
            'postalCode' => $request->input('postalCode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'number' => $request->input('number'),
            'district' => $request->input('district'),
            'complement' => $request->input('complement'),
            'notes' => $request->input('notes'),
        ];
        $address->saveAddress($addressData);
        $userData = $validation['value'];
        $userData['uuid'] = ModelsBase::createuuid();
        $userData['address_uuid'] = $addressUUID;
        $userData['hotel_uuid'] = $currentUser->hotel_uuid;
        $user->saveUser($userData);
        return redirect()->route('allUserHome', $token)->with([
            'message' => 'Usuario creado con Exito.',
        ]);
    }


    /*
     * Update user and address by uuid.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return <redirect>
     */
    public function update(Request $request, string $token, string $uuid)
    {
        $user = new User();
        $userWk = $user->getSpecificUserWithUuid(uuid: $uuid);
        if (!$userWk) {
            return redirect()->route('errorPage')->with([
                'route' => route('allUserHome', $token),
                'message' => 'Error: no se han encontrado usuarios. Por favor intentalo mas tarde.',
            ]);
        }

        $validation = $user->validateInput($request, true);
        if (!$validation['success']) {
            return back()->withErrors($validation['errors'])->withInput();
        }
        $address = new Address();
        $addressUUID = $request->input('address_uuid') ?: $userWk->address_uuid;
        $address->saveAddressByUuid($addressUUID, [
            'address' => $request->input('address'),
            'postalCode' => $request->input('postalCode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'number' => $request->input('number'),
            'district' => $request->input('district'),
            'complement' => $request->input('complement'),
            'notes' => $request->input('notes'),
        ]);

        $userData = $validation['value'];
        if (empty($userData['password'])) {
            unset($userData['password']);
        }
        $userData['address_uuid'] = $addressUUID;
        $userWk->saveUser($userData);

        return redirect()->route('allUserHome', $token)->with([
            'message' => 'Usuario actualizado con Exito.',
        ]);
    }

    /*
     * Delete user and related address.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return <redirect>
     */
    public function destroy(Request $request, string $token, string $uuid)
    {
        $user = new User();
        $userWk = $user->getSpecificUserWithUuid(uuid: $uuid);
        if (!$userWk) {
            return redirect()->route('errorPage')->with([
                'route' => route('allUserHome', $token),
                'message' => 'Error: no se han encontrado usuarios. Por favor intentalo mas tarde.',
            ]);
        }

        $addressUUID = $userWk->address_uuid;
        $userWk->delete();

        if (!empty($addressUUID)) {
            Address::where('uuid', $addressUUID)->delete();
        }

        return redirect()->route('allUserHome', $token)->with([
            'message' => 'Usuario eliminado con Exito.',
        ]);
    }




}

