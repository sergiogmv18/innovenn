<?php

namespace App\Http\Controllers;

use App\Models\Crypt;
use Illuminate\Http\Request;
use App\Models\Travel;
use App\Models\ModelsBase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Helpers\FunctionsClass;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


class TravelerController extends Controller
{
    /*
    * Return view home 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function travelerRegistration() {
        $travelModel = new Travel();  
        $data = [
            "alltravelersRegisted" => $travelModel->getAll(),
        ];
    
        return view("clients.travels.traveler-registration-index", $data);
    }

    /*
    * Show form register new travel
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
     public function showFormRegisterTravel(Request $request){
        $allProvicesAndMunicipality = FunctionsClass::getAllCodeProvinceAndMunicipalityOfSpain();
        $allCountry =  FunctionsClass::getAllCountry();
        $data = [
            'allProvicesAndMunicipality' => $allProvicesAndMunicipality,
            'allCountry'=>$allCountry
        ];
        if(Session::has('user')){
            return view("clients.travels.register-new-travel", $data);
        }
        $token = $request->token;
        if (!Cache::has("form_token_register_travel{$token}")) {
            return redirect()->route('errorPage')->with('message', 'Este enlace ha expirado.');
        }
    
        // Mostrar el formulario
       // return view('formulario', ['token' => $token]);
        return view("clients.travels.register-new-travel", $data);
     }

   /*
    * Register travels
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function registerTravel(Request $request) {
        $travelModel = new Travel();  
        $crypt = new Crypt();
        $arraytravel = [];
        $validatedData = $travelModel->validateInput($request);
        if($validatedData['success']){ 
            $arraytravel = $validatedData['value'];
            $arraytravel['dateExpedition'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['dateExpedition']);
            $arraytravel['birthdate'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['birthdate']);
            $arraytravel['entryDate'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['entryDate']);
        }else{
            return  response()->json([
                'success' => false,
                'errors' => $validatedData['errors'] // Devuelve un array con los campos que fallaron
            ], 200);
        }
        
        if(!array_key_exists('uuid', $arraytravel)) {
            $arraytravel['uuid'] =  ModelsBase::createuuid();
            $arraytravel['npart'] = $travelModel->getMaxNPart();
        }
        
        // ENCRYPT
        $arraytravel['firstName'] = $crypt->encryptData($arraytravel['firstName']);
        $arraytravel['subName'] = $crypt->encryptData($arraytravel['subName']);
        $currentUser = Session::get('user');
        $arraytravel['hotel_uuid'] = $currentUser->hotel_uuid;
        // $arraytravel['lastName'] = $arraytravel['lastName'] != null && !empty($arraytravel['lastName']) ? $crypt->encryptData($arraytravel['lastName']): $arraytravel['lastName'];
        $arraytravel['phoneNumber'] = $arraytravel['phoneNumber'] != null && !empty($arraytravel['phoneNumber']) ? $crypt->encryptData($arraytravel['phoneNumber']) : $arraytravel['phoneNumber'];
        $arraytravel['emailAddress'] = $arraytravel['emailAddress'] != null && !empty($arraytravel['emailAddress']) ? $crypt->encryptData($arraytravel['emailAddress']) : $arraytravel['emailAddress']; 
        $arraytravel['documentNumber'] = $crypt->encryptData($arraytravel['documentNumber']);
        $arraytravel['suportNumber'] = $crypt->encryptData($arraytravel['suportNumber']);
        $arraytravel['postalCode'] = $crypt->encryptData($arraytravel['postalCode']);
        $arraytravel['address'] = $crypt->encryptData($arraytravel['address']);
        $arraytravel['eFirma'] = $crypt->encryptData($arraytravel['eFirma']);
        $travelWK = new Travel($arraytravel); 
        $travelWK->save();       
    }

    /*
    * Edit travels
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function editTravel(Request $request) {
        $travel = new Travel(); 
        $crypt = new Crypt();
        $arraytravel = [];  
        if($request->traveluuid != null){
            $travelWk = $travel->getSpecificTravel(uuid: $request->traveluuid);
            if(!$travelWk){
                return response()->json([
                    'success' => false,
                    'message' => 'Viajero no encontrado'// Devuelve un array con los campos que fallaron
                ], 200);    

            }
        }else{
            return  response()->json([
                'success' => false,
                'message' => 'Viajero no encontrado'// Devuelve un array con los campos que fallaron
            ], 200);    
        }
        $validatedData = $travel->validateInput($request);
        if($validatedData['success']){ 
            $arraytravel = $validatedData['value'];
            $arraytravel['dateExpedition'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['dateExpedition']);
            $arraytravel['birthdate'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['birthdate']);
            $arraytravel['entryDate'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['entryDate']);
        }else{
            return  response()->json([
                'success' => false,
                'errors' => $validatedData['errors'] // Devuelve un array con los campos que fallaron
            ], 200);
        }
        $travelWk->firstName = $crypt->encryptData($arraytravel['firstName']);
        $travelWk->subName = $crypt->encryptData($arraytravel['subName']);
        $travelWk->lastName = $arraytravel['lastName'] != null && !empty($arraytravel['lastName']) ? $crypt->encryptData($arraytravel['lastName']): $arraytravel['lastName'];
        $travelWk->status = $arraytravel['status'];
        $travelWk->phoneNumber = $arraytravel['phoneNumber'] != null && !empty($arraytravel['phoneNumber']) ? $crypt->encryptData($arraytravel['phoneNumber']) : $arraytravel['phoneNumber'];
        $travelWk->emailAddress = $arraytravel['emailAddress'] != null && !empty($arraytravel['emailAddress']) ? $crypt->encryptData($arraytravel['emailAddress']) : $arraytravel['emailAddress']; 
        $travelWk->sex = $arraytravel['sex'];
        $travelWk->typeDocument = $arraytravel['typeDocument'];
        $travelWk->documentNumber = $crypt->encryptData($arraytravel['documentNumber']);
        $travelWk->suportNumber = $crypt->encryptData($arraytravel['suportNumber']);
        $travelWk->dateExpedition = $arraytravel['dateExpedition'];
        $travelWk->birthdate = $arraytravel['birthdate'];
        $travelWk->countrySelected = $arraytravel['countrySelected'];
        $travelWk->kinshipLodging = $arraytravel['kinshipLodging'];
        $travelWk->address = $crypt->encryptData($arraytravel['address']); 
        $travelWk->postalCode  = $crypt->encryptData($arraytravel['postalCode']);
        $travelWk->entryDate = $arraytravel['entryDate'];
        $travelWk->finalDate = $arraytravel['finalDate'];
        $travelWk->methodOfPayment = $arraytravel['methodOfPayment'];
        $travelWk->typeOfEntity = $arraytravel['typeOfEntity'];
        $travelWk->addressOfFacture = $arraytravel['addressOfFacture'];
        $travelWk->postalCodeOfFacture = $arraytravel['postalCodeOfFacture'];
        $travelWk->nameResponsibleToBilling = $arraytravel['nameResponsibleToBilling'];
        $travelWk->documentOfEntity = $arraytravel['documentOfEntity'];
        $travelWk->travelFatureData = $arraytravel['travelFatureData'];
        $travelWk->eFirma = $crypt->encryptData($arraytravel['eFirma']);
        $travelWk->usePersonalDataInInvoice = $arraytravel['usePersonalDataInInvoice'];
        $travelWk->save(); 
    }

    /*
    *Get form to Edit travels
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function getFormToEditTravel(Request $request){
        if($request->traveluuid == null){
            return redirect()->route('errorPage')->with([
                'route' => route('travelerRegistration',Session::get('user')['uuid'] ),
                'message' => 'No se pudo encontrar ese viajero, por favor intente mas tarde, o contacte a soporte',
            ]);
        }
        $travel = new Travel();
        $travelWk = $travel->getSpecificTravel(uuid: $request->traveluuid);
        $allCountry =  FunctionsClass::getAllCountry();
        $allProvicesAndMunicipality = FunctionsClass::getAllCodeProvinceAndMunicipalityOfSpain();
        $data = [
            'travelWk'=>$travelWk,
            'allProvicesAndMunicipality' => $allProvicesAndMunicipality,
            'allCountry'=>$allCountry
        ];
        return view("edit-travel", $data);
    }

    /*
    * Get Specific travels
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function getSpecificTravel(Request $request) {
        if( $request->traveluuid == null){
            return redirect()->route('errorPage')->with([
                'route' => route('travelerRegistration',Session::get('user')['uuid'] ),
                'message' => 'No se pudo encontrar ese viajero, por favor intente mas tarde, o contacte a soporte',
            ]);
        }
        $travel = new Travel();
        $travelWk = $travel->getSpecificTravel(uuid: $request->traveluuid);
        $data = [
            'travel'=>$travelWk 
        ];
        return view("show-travel-registered",  $data);
    }

  /** 
    * Delete Specific travels
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @param Request $request
    * @return <view>
    **/
    public function deleteTravel(Request $request){
        if( $request->traveluuid == null){
            return redirect()->route('errorPage')->with([
                'route' => route('travelerRegistration',Session::get('user')['uuid'] ),
                'message' => 'No se pudo encontrar ese viajero, por favor intente mas tarde, o contacte a soporte',
            ]);
        }
        $travelwk = new Travel();
        $travelwk->deleteTravel(uuid:$request->traveluuid);
    }

    
  /** 
    * Generate Temporary url to form travel
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function generateTemporaryUrl(){
        // Generar un token único
        $token = Str::random(50);
        // Guardar en caché con una expiración de 2 horas
        Cache::put("form_token_register_travel{$token}", true, now()->addHours(24));
        // Construir la URL
        $url = route('showFormRegisterTravel', $token);
        return response()->json(['url' => $url]);
    }   

  /** 
    * Return page success to client to registered travel
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function pageSuccessRegisterTravel(){
        return view("components.page-success");
    }


  /** 
    * Download xml travel
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function downloadXML(Request $request) {
        $travel = new Travel();
        if($request->traveluuid == null){
            return  response()->json([
                'success' => false,
                'errors' => 'No se consigue ese registro de viajero'// Devuelve un array con los campos que fallaron
            ], 200);
        }

        $travelwk = $travel->getSpecificTravel($request->traveluuid);
        if($travelwk == null){
            return  response()->json([
                'success' => false,
                'errors' => 'No se consigue ese registro de viajero'// Devuelve un array con los campos que fallaron
            ], 200);
        }
        $time = time();
        $fileName = 'parte_de_viajero_' . $travelwk->firstName . '_' . $time . '.xml';
        $filePath = 'public/' . $fileName; // Laravel usa 'public/' para archivos accesibles públicamente
        $storagePath = storage_path('app/' . $filePath);
    
        // Generar el contenido XML
        $xmlContent = $travelwk->getDocumentXMLTravel();
        file_put_contents($storagePath, $xmlContent);
    
        if (!file_exists($storagePath)) {
            return response()->json(['success' => false, 'message' => 'Erro ao criar o arquivo XML.']);
        }
    
        // Devolver la URL pública del archivo
        return response()->json([
            'success' => true,
            'file_url' => Storage::url($fileName) // Laravel genera una URL pública automáticamente
        ]);
    }

}