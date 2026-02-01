<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Travel;
use App\Models\ModelsBase;
use App\Models\BillingData;
use App\Models\TravelDocument;

use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
   /*
    * Return view home 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function homeInvoice() {
        $invoice  = new Invoice();
        $allTravels = $invoice->getAll(); 
        $data = [
             "allInvoicesRegisted" =>$allTravels
        ];   
        return view("clients.invoice.home-invoice", $data);
    }


       /*
    * Return view form to invoice 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function getFormOfRegisterInvoice() {
        $travelModel = new Travel();
        $invoice  = new Invoice();
        $allTravels = $travelModel->getAll();
        $numberOfInvoice = $invoice->getMaxNumber();
        $data = [
            'numberOfInvoice'=> $numberOfInvoice,
            'allTravels' =>$allTravels,
            'allInvoices' =>$invoice->getAll()
        ];
        return view("clients.invoice.register-invoice", $data);
    }

       /*
    * Register invoice 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function registerInvoice(Request $request) {
        // dd($request);
        $invoice  = new Invoice();
        $arraytravel = [];
        $validatedData = $invoice->validateInput($request);
        if($validatedData['success']){ 
            $arraytravel = $validatedData['value'];
            $arraytravel['creationDate'] = \DateTime::createFromFormat('Y-m-d', $validatedData['value']['creationDate']);
        }else{
            return  response()->json([
                'success' => false,
                'errors' => $validatedData['errors'] // Devuelve un array con los campos que fallaron
            ], 422);
        }

        if(!array_key_exists('uuid', $arraytravel)) {
            $arraytravel['uuid'] =  ModelsBase::createuuid();
        }
        $invoiceWk  = new Invoice($arraytravel);
        $invoiceWk->save(); 
        return response()->json([], 200);
    }


   /**
    * Show specific Invoice 
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function showSpecificInvoice(Request $request) {
        $invoice  = new Invoice();
        $billingDataWk  = new BillingData();
        $invoiceWk = $invoice->getSpecificInvoice(uuid:  $request->invoiceuuid);
        $data = [
            'invoiceWk' =>$invoiceWk,
            'billingData'=> $billingDataWk->getBillingData(),
        ];
        return view("invoice.show-specific-invoice", $data);
    }

    /**
    * Get Billing Data to invoice
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function billingData() {
        $billingData  = new BillingData();
        $billingDataWk = $billingData;
        $data = [
            'billingDataWk' =>$billingDataWk->getBillingData(),
        ];
        return view("clients.billingData.billing-data-create-or-edit", $data);
    }

   /**
    * Register Billing Data to invoice
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @param Request $request - data to billing
    * @return <view>
    **/
    public function registerBillingData(Request $request) {
        $billingData  = new BillingData();
        $arrayDataOfBillingData = [];
        $extensionOfIMG = $request->extensionOfIMG;
        
        if(!$extensionOfIMG){
            return  response()->json([
                'success' => false,
                'message' => 'Extención de imagen no encontrado'// Devuelve un array con los campos que fallaron
            ], 200);
        }
        $validatedData = $billingData->validateInput($request);
        if($validatedData['success']){ 
            $arrayDataOfBillingData = $validatedData['value'];
        }else{
          return  response()->json([
              'success' => false,
              'message' => $validatedData['errors'] // Devuelve un array con los campos que fallaron
          ], 200);
        }
//  CREATE IMG IN STORADE
        $document = new TravelDocument();
        $path = $document->createDocuments(nameDirectory: 'billing',nameFile:'billingData', content:$arrayDataOfBillingData['photoPath'],extension: $extensionOfIMG);
        if(!$path){
            return  response()->json([
                'success' => false,
                'message' => 'Imagen no Soportada'// Devuelve un array con los campos que fallaron
            ], 200);    
        }
        $arrayDataOfBillingData['photoPath'] = $path;
        $arrayDataOfBillingData['uuid'] =  ModelsBase::createuuid();
        $billingDataWk = new  BillingData($arrayDataOfBillingData);
        $billingDataWk->save();
        Session::put('billingData', $billingDataWk->getBillingData());
        return response()->json([], 200);    
    }

      /**
    * Edit Billing Data to invoice
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @param Request $request - data to billing
    * @return <view>
    **/
    public function editBillingData(Request $request) {
        $billingData = new BillingData();
        $photoPath = $request->photoPath;
        $arrayDataOfBillingData = [];
        $extensionOfIMG = $request->extensionOfIMG;    
        $specificbillingData = $billingData->getSpecificBillingData($request->billinguuid);
        $document = new TravelDocument();
// verificar si existe esa categoria
        if(!$specificbillingData){
            return redirect()->route('errorPage')->with([
                'route' => route('travelersRegisterHome',Session::get('user')->uuid ),
                'message' => 'No se pudo encontrar, por favor intente mas tarde, o contacte a soporte',
            ]); 
        }
        $validatedData = $billingData->validateInput($request);
        if($validatedData['success']){ 
            $arrayDataOfBillingData = $validatedData['value'];
        }else{
          return  response()->json([
              'success' => false,
              'message' => $validatedData['errors'] // Devuelve un array con los campos que fallaron
          ], 200);
        }
// verificar si mudo la foto 
        if(strlen($photoPath) > 30 && $extensionOfIMG != null){
            $document->deleteDocument($specificbillingData->photoPath);  
            $path = $document->createDocuments(nameDirectory: 'billing',nameFile:'billingData', content:$photoPath,extension: $extensionOfIMG);
            if(!$path){
                return  response()->json([
                    'success' => false,
                    'message' => 'Imagen no Soportada'// Devuelve un array con los campos que fallaron
                ], 200);    
            }
            $specificbillingData->photoPath = $path;          
        }
        $specificbillingData->name = $arrayDataOfBillingData['name'];
        $specificbillingData->footer = $arrayDataOfBillingData['footer'];
        $specificbillingData->postalCode = $arrayDataOfBillingData['postalCode'];
        $specificbillingData->address = $arrayDataOfBillingData['address'];
        $specificbillingData->typeBillingData = $arrayDataOfBillingData['typeBillingData'];
        $specificbillingData->documentNumber = $arrayDataOfBillingData['documentNumber'];
        
        
        $specificbillingData->save(); 
        Session::put('billingData', $specificbillingData->getBillingData());
        return response()->json([
            'success' => true,
            'message' => 'Actualizado con successo'
        ], 200);  

    }





    

    
}
