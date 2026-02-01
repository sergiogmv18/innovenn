<?php

namespace App\Http\Controllers;

use App\Models\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use App\Models\ModelsBase;
use App\Models\BillingData;


class TravelersRegisterController extends Controller
{

    


    public function signIn(Request $request){
         // Validar los datos de entrada
         $request->validate([
            'email_address' => 'required|string',
            'password' => 'required|string'
        ]);
        // $address = [
        //     "address" => "address",
        //     "postalCode" => "28005",
        //     "city" => "Madrid",
        //     "state" => "Madrid",
        //     "country" => "Spain",
        //     "number" => "35",
        //     "district" => "ronda",
        //     "complement" => "piso 1 6",
        //     "uuid" => ModelsBase::createuuid(),
        // ];
        // $newAddress = Address::saveAddress($address);
        $user = new user(); 
        //  = [
        //     "uuid" => ModelsBase::createuuid(),
        //     "first_name" => "Sergio",
        //     "sub_name" => "Giovanny",
        //     "last_name" => "Marcano",
        //     "phone_number" => "+34 644 69 05 07",
        //     "type" => User::ROLE_ADMIN,
        //     "email_address" => "sergiogmv18@gmail.com",
        //     "address_uuid" => ModelsBase::createuuid(),
        //     "hotel_uuid" => ModelsBase::createuuid(),
        //     "password" => "Alma1803."
        // ];
        // $currentUser 
        //  $currentUser->saveUser($user);



        // Buscar el usuario con el nombre proporcionado
        $userWk = $user->getSpecificUser(emailAddress: $request->email_address, password: $request->password);  
        
        // Verificar si el usuario existe y si la contraseña es correcta
        if (!$userWk) {  // Aquí se usa $userWk en lugar de $user
            return redirect()->route('errorPage')->with([
                'route' => route('login'),
                'message' => 'Usuario o contraseña incorrecta, por favor intente de nuevo.',
            ]);
        }
        // Aquí el usuario ya está autenticado y puedes proceder con la lógica
        $billingDataWk = new BillingData();
        Auth::login($userWk);
        Session::put('user', $userWk);
        Session::put('expires_at', now()->addMinutes(180));
        Session::put('billingData', $billingDataWk->getBillingData());
        
        return redirect()->route('travelersRegisterHome', $userWk->uuid);
    }

    


    /*
    * SignOut and redirect login page  
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/ 
    public function signOut(Request $request)
    {
        // Cerrar sesión del usuario autenticado
        Auth::logout();
        // Eliminar cualquier dato de sesión relacionado con el usuario
        $request->session()->flush();
       return redirect()->route('login');
   }


    /*
    * Return view error  
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/    
    public function errorPage(){
        return view("error_page");
    }

     /*
    * Return view login 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/    
    public function login(){
        return view("login");
    }

    /*
    * Return view Welcome 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/    
    public function welcome(){
        return view("welcome");
    }

    

  /*
    * Return view politica and privacity 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/    
    public function politicAndPrivacy(){
        return view("politic-and-privacy");
    }
    
}
