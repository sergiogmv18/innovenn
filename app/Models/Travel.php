<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Crypt;
use App\Helpers\FunctionsClass;

class Travel extends Model
{
    protected $table = 'travels';
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    public $fillable = [
        'firstName',
        'subName',
        'lastName',
        'uuid',
        'status',
        'phoneNumber',
        'hotelUuid',
        'emailAddress',
        'sex',
        'typeDocument',
        'documentNumber',
        'suportNumber',
        'dateExpedition',
        'birthdate',
        'countrySelected',
        'kinshipLodging',
        'address',
        'postalCode',
        'entryDate',
        'finalDate',
        'methodOfPayment',
        'typeOfEntity',
        'addressOfFacture',
        'postalCodeOfFacture',
        'nameResponsibleToBilling',
        'documentOfEntity',
        'travelFatureData',
        'npart',
        'eFirma',
        'usePersonalDataInInvoice',
        'isTrash',


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
     * Delete travels
     * 
     * @param string $uuid uuid of travel to delete 
     * @return
     */
    public function deleteTravel(string $uuid){
        $travel = $this::where('uuid', $uuid)->first();
        if ($travel) {
            $travel->isTrash = 1;
            $travel->save();
        }
    }


  /**
     * Get all travels
     * 
     * 
     * @return
     */
    public function getAll(){
        $travels = $this::where('isTrash', 0)->orderBy('id', 'desc')->get();
        $crypt = new Crypt(); 
        // dd($crypt->decryptData('aKQD+lQ3BymuOUCdZtPzWDfxV0I6RrQ='));
        
        // dd($crypt->encryptData('[{"address":"CALLE EMILIA DE PABLO GONZALEZ","addressNumber":"6","addressMunicipality":"","addressProvince":"Segóvia"}]'));

        // Calle del Madroño, 5, FUENLABRADA
        foreach ($travels as $travel) {
            $travel->firstName = $crypt->decryptData($travel->firstName);
            $travel->subName = $crypt->decryptData($travel->subName);
            if (!empty($travel->lastName) && base64_decode($travel->lastName, true) !== false) {
                $travel->lastName = $crypt->decryptData($travel->lastName);
            } else {
                $travel->lastName = null;  // O maneja el valor de otra manera, según lo necesites
            }
            $travel->phoneNumber = $crypt->decryptData($travel->phoneNumber);
            $travel->emailAddress = $crypt->decryptData($travel->emailAddress);
            $travel->documentNumber = $crypt->decryptData($travel->documentNumber);
            $travel->suportNumber = $crypt->decryptData($travel->suportNumber);
            $travel->postalCode = $crypt->decryptData($travel->postalCode);
            $travel->address = $crypt->decryptData($travel->address);
            // $travel->eFirma = $crypt->decryptData($travel->eFirma);
        }
       
        return $travels;
    }

    /**
     * Get Specific travel
     * @param string $uuid
     * @return Travel|null if uuid no exist
     */
    public function getSpecificTravel(string $uuid) {
        $crypt = new Crypt(); 
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $travel = $this::where('uuid', $uuid)->first();
        if ($travel) {
            $travel->firstName = $crypt->decryptData($travel->firstName);
            $travel->subName = $crypt->decryptData($travel->subName);
            if (!empty($travel->lastName) && base64_decode($travel->lastName, true) !== false) {
                $travel->lastName = $crypt->decryptData($travel->lastName);
            } else {
                $travel->lastName = null;  // O maneja el valor de otra manera, según lo necesites
            }
            if (!empty($travel->phoneNumber) && base64_decode($travel->phoneNumber, true) !== false) {
                $travel->phoneNumber = $crypt->decryptData($travel->phoneNumber);
            } else {
                $travel->phoneNumber = null;  // O maneja el valor de otra manera, según lo necesites
            }
            if (!empty($travel->emailAddress) && base64_decode($travel->emailAddress, true) !== false) {
                $travel->emailAddress = $crypt->decryptData($travel->emailAddress);
            } else {
                $travel->emailAddress = null;  // O maneja el valor de otra manera, según lo necesites
            }
        
            $travel->documentNumber = $crypt->decryptData($travel->documentNumber);
            $travel->suportNumber = $crypt->decryptData($travel->suportNumber);
            $travel->postalCode = $crypt->decryptData($travel->postalCode);
            $travel->address = $crypt->decryptData($travel->address);
            $travel->eFirma = $crypt->decryptData($travel->eFirma);
            return $travel;
        }
    
        return null;
    }


   /**
     * Validate input and return array whit value
     * 
     * @param Request $request Datos del viaje a guardar.
     * @return array
     */
    public function validateInput(Request $request) {
        try {
            $validatedData = $request->validate([
                'firstName' => 'required|string',
                'subName' => 'required|string',
                'lastName' => 'nullable|string', // Agregaste este campo sin regla, lo corregí
                'uuid' => 'nullable|string',
                'status' => 'required|string',
                'phoneNumber' => 'nullable|string',
                'emailAddress'=> 'nullable|string',
                'sex' => 'required|string',
                'typeDocument' => 'required|string',
                'documentNumber' => 'required|string',
                'suportNumber' => 'nullable|string',
                'dateExpedition' => 'required|string',
                'birthdate' => 'required|string',
                'countrySelected' => 'required|string',
                'kinshipLodging' => 'nullable|string',
                'address' => 'required|string',
                'postalCode' => 'required|string',
                'entryDate' => 'required|string',
                'finalDate'=> 'required|string',
                'npart' => 'nullable|numeric',
                'methodOfPayment' => 'required|string',
                'typeOfEntity' => 'nullable|string',
                'addressOfFacture' => 'nullable|string',
                'nameResponsibleToBilling' =>'nullable|string',
                'postalCodeOfFacture' => 'nullable|string',
                'documentOfEntity' => 'nullable|string',
                'travelFatureData' => 'nullable|boolean',
                'usePersonalDataInInvoice'=>'nullable|boolean',
                'isTrash'=>'nullable|boolean',
                'eFirma' => 'required|string', // Base64 es una cadena, está bien como string
            ]);
            return [
                'success' => true,
                'value'=> $validatedData,
            ];

        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors()
            ];
        }
    }


   /**
     * Get quantity anual registed
     * 
     * @return
     */
    public function getQuantityAnualRegisted() {
        $travel = new Travel();
        $results = $travel->selectRaw('DATE_FORMAT(entrydate, "%m") as month, COUNT(*) as total')
                          ->whereYear('entrydate', date('Y')) // Filtrar solo el año actual
                          ->groupBy('month')
                          ->orderBy('month', 'asc')
                          ->get();
    
        // Inicializar el array con todos los meses en 0
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = [str_pad($i, 2, '0', STR_PAD_LEFT), 0];
        }
    
        // Rellenar con los resultados obtenidos
        foreach ($results as $result) {
            foreach ($data as &$row) {
                if ($row[0] == $result->month) {
                    $row[1] = (int)$result->total;
                }
            }
        }
    
        return $data;
    }

     /**
     * Get the total count of travels
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @return int
     **/
    public function getTotalCount() {
        return $this::count();
    }

     /**
     * Get Specific travel
     * @param string $uuid
     * @return integer
     */
    public function getMaxNPart() {
        // Obtener el último registro ordenado por el número de factura en orden descendente
        $travelwk = $this::orderBy('npart', 'desc')->first();
    
        // Si hay un registro, retornar el siguiente número
        if ($travelwk) {
            return $travelwk->npart + 1;
        }
        // Si no hay registros, comenzar desde el número 1
        return 254;
    }

     /**
     * Get the total count of travels of year
     * @author SGV
     * @version 1.0 - 20230215 - initial release
     * @return int
     **/
    public function getTotalCountCurrentYear() {
        $currentYear = Carbon::now()->year; // Obtiene el año actual, por ejemplo 2025
        return $this::whereYear('entrydate', $currentYear)->count();
    }


    /**
 * Limpia un string eliminando espacios, acentos y caracteres especiales.
 * 
 * @param string $texto El texto a limpiar.
 * @return string El texto limpio.
 */
function getFullNameToDocument() {
    $fullName = $this->firstName."_".$this->subName;
    // Eliminar espacios
    $fullName = str_replace(' ', '', $fullName);

    // Remover acentos y caracteres especiales
    $acentos = array(
        'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ',
        'á', 'é', 'í', 'ó', 'ú', 'ñ'
    );
    $sinAcentos = array(
        'A', 'E', 'I', 'O', 'U', 'N',
        'a', 'e', 'i', 'o', 'u', 'n'
    );
    $fullName = str_replace($acentos, $sinAcentos, $fullName);
    // Remover otros caracteres especiales si es necesario
    $fullName = preg_replace('/[^A-Za-z0-9]/', '', $fullName);
    return $fullName;
}
    

    /**
     * Formatear dirección
     * 
     * @param array $addresses
     * @return string
     */
    function formatAddress() {
        $formattedAddresses = [];
        if($this->address != null){
            $addresses = json_decode( $this->address, true);
            if( $addresses != null){
                foreach ($addresses as $address) {
                    $formatted = '';
        
                    // Concatenar cada campo solo si no está vacío
                    if (!empty($address['address'])) {
                        $formatted .= $address['address'];
                    }
                    
                    if (!empty($address['addressNumber'])) {
                        $formatted .= ($formatted ? ', ' : '') . $address['addressNumber'];
                    }
                    
                    if (!empty($address['addressMunicipality'])) {
                        $formatted .= ($formatted ? ', ' : '') . $address['addressMunicipality'];
                    }
                    
                    if (!empty($address['addressProvince'])) {
                        $formatted .= ($formatted ? ', ' : '') . $address['addressProvince'];
                    }
        
                    // Si la dirección está vacía, la ignoramos
                    if ($formatted) {
                        $formattedAddresses[] = $formatted;
                    }
                }
            }
            
        }
        return implode(' | ', $formattedAddresses); // Si hay más de una dirección, se separan con |
    }

    /**
     * Get method payment
     * 
     * @return string|null
     */
    public function getMethodPayment(){
        switch($this->methodOfPayment){
           case 'Destino':
                return 'DESTI';
            case 'Efectivo':
                return 'EFECT'; 
            case 'Tarjeta':
                return 'TARJT'; 
            case 'Plataforma':
                return 'PLATF';
            case 'Transferencia':
                return 'TRANS'; 
            case 'Móvil':
                return 'MOVIL'; 
            case 'Otro':
                return 'OTRO'; 
            case 'Tarjeta Registrada':
                return 'TREG'; 
        }
    }

    /**
     * Get Type Of Selected Document
     * 
     * @return string|null
     */
    public function getTypeOfSelectedDocument(){
        switch($this->typeDocument){
           case 'CIF':
                return 'CIF';
            case 'Pasaporte':
                return 'PAS'; 
            case 'NIE':
                return 'NIE'; 
            case 'NIF':
                return 'NIF';
            default:
                return 'OTRO'; 
        }
    }

     /**
     * Formatear dirección
     * 
     * @param array $addresses
     * @return string
     */
    function formatAddressBilling() {
        $formattedAddresses = [];
        $addresses = json_decode( $this->addressOfFacture, true);

        foreach ($addresses as $address) {
            $formatted = '';

            // Concatenar cada campo solo si no está vacío
            if (!empty($address['address'])) {
                $formatted .= $address['address'];
            }
            
            if (!empty($address['addressNumber'])) {
                $formatted .= ($formatted ? ', ' : '') . $address['addressNumber'];
            }
            
            if (!empty($address['addressMunicipality'])) {
                $formatted .= ($formatted ? ', ' : '') . $address['addressMunicipality'];
            }
            
            if (!empty($address['addressProvince'])) {
                $formatted .= ($formatted ? ', ' : '') . $address['addressProvince'];
            }

            // Si la dirección está vacía, la ignoramos
            if ($formatted) {
                $formattedAddresses[] = $formatted;
            }
        }

        return implode(' | ', $formattedAddresses); // Si hay más de una dirección, se separan con |
    }

    /**
     * Get Specific code isso alfa 3 to selected country
     * 
     * @return string|null
     */
    public function getSpecificCodeIso(){
        $countries = FunctionsClass::getAllCountry();
        foreach ($countries as $country) {
            if($country['name'] == $this->countrySelected){
                return  $country['code_alfa3'];
            }
        }
    }

    /**
     * Get Specific code isso alfa 3 to selected country addres
     * 
     * @return
     */
    public function getSpecificCodeIsoOfCountryAddress(){
        if ($this->address != null) {
            $addresses = json_decode($this->address, true)[0];
            if (isset($addresses['country'])) { // Verifica si la llave 'country' existe y no es null
                $countries = FunctionsClass::getAllCountry();
                foreach ($countries as $country) {
                    if ($country['name'] == $addresses['country']) {
                        return $country['code_alfa3'];
                    }
                }
            }
        }
        return null; 
    }

      /**
     * Get Specific code and municiple
     * 
     * @return string|null
     */
    public function getSpecificProvinceAndMunicipality(){
        $ProvincesAndMunicipalitiesOfSpain = FunctionsClass::getAllCodeProvinceAndMunicipalityOfSpain();
        $addresses = json_decode($this->address, true)[0];
        foreach ($ProvincesAndMunicipalitiesOfSpain as $ProvinceAndMunicipalityOfSpain) {
            if($ProvinceAndMunicipalityOfSpain['municipio'] == $addresses['addressMunicipality']){
                return  $ProvinceAndMunicipalityOfSpain['code'];
            }
        }
    }


    /**
     * Calcula el número de días entre dos fechas.
     *
     * @param  bool              $inclusive   Si true, incluye el día de salida.
     * @return int                            Número de días entre las dos fechas.
     */
    function calculateDaysBetween(bool $inclusive = false): int
    {
        $entryDate = $this->entryDate instanceof \DateTime ? $this->entryDate : new \DateTime($this->entryDate);
        $finalDate = $this->finalDate instanceof \DateTime ? $this->finalDate : new \DateTime($this->finalDate);
        // Calcula el intervalo
        $interval = $entryDate->diff($finalDate);
        // $interval->days es siempre positivo
        $days = $interval->days;
        // Si quieres incluir el día de salida, suma 1
        return $inclusive ? $days + 1 : $days;
    }
    


    public function getDocumentXMLTravel(){
       // Construye el XML dinámicamente
       $addresses = json_decode($this->address, true)[0];
       // Set timezone to Spain
        date_default_timezone_set('Europe/Madrid');
        
        $entryDate = $this->entryDate instanceof \DateTime ? $this->entryDate : new \DateTime($this->entryDate);
        $birthdate = $this->birthdate instanceof \DateTime ? $this->birthdate : new \DateTime($this->birthdate);
        $finalDate = $this->finalDate instanceof \DateTime ? $this->finalDate : new \DateTime($this->finalDate);
        // Explicitly set timezone to Spain
        $entryDate->setTimezone(new \DateTimeZone('Europe/Madrid'));
        $birthdate->setTimezone(new \DateTimeZone('Europe/Madrid'));
        $finalDate->setTimezone(new \DateTimeZone('Europe/Madrid'));
        // For fechaContrato: YYYY-MM-DD+HH:MM (without timezone)
        $fechaContrato = $entryDate->format('Y-m-d'). '+01:00';
        
        // For fechaEntrada/fechaSalida: YYYY-MM-DDThh:mm:ss.sss+01:00 (Spain timezone)
        $milliseconds = sprintf("%03d", ($entryDate->format('u') / 1000));
        $fechaEntrada = $entryDate->format('Y-m-d\TH:i:s.') . $milliseconds . '+01:00';
        $fechaSalida = isset($finalDate) ? $finalDate->format('Y-m-d\TH:i:s.') . $milliseconds . '+01:00' : '';
        
        // For fechaNacimiento (if needed in the same format as fechaEntrada)
        $fechaNacimiento = $birthdate->format('Y-m-d'). '+01:00';
                
        $milliseconds = '711';
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlContent .= '<ns2:peticion xmlns:ns2="http://www.neg.hospedajes.mir.es/altaParteHospedaje">';
        $xmlContent .= '<solicitud>';
        $xmlContent .= '<codigoEstablecimiento>0000124523</codigoEstablecimiento>';
        $xmlContent .= '<comunicacion>';
        $xmlContent .= '<contrato>';
        $xmlContent .= '<referencia>'.htmlspecialchars( $entryDate->format('dmY')).'</referencia>';
        $xmlContent .= '<fechaContrato>'.htmlspecialchars($fechaContrato).'</fechaContrato>';
        $xmlContent .= '<fechaEntrada>'.htmlspecialchars($fechaEntrada).'</fechaEntrada>';
        $xmlContent .= '<fechaSalida>'.htmlspecialchars($fechaSalida).'</fechaSalida>';
        $xmlContent .= '<numPersonas>1</numPersonas>';
        $xmlContent .= '<numHabitaciones>1</numHabitaciones>';
        $xmlContent .= '<internet>true</internet>';
        $xmlContent .= '<pago>';
        $xmlContent .= '<tipoPago>'.htmlspecialchars($this->getMethodPayment()).'</tipoPago>';
        $xmlContent .= '<medioPago></medioPago>';
        $xmlContent .= '<titular></titular>';
        $xmlContent .= '<caducidadTarjeta></caducidadTarjeta>';
        $xmlContent .= '</pago>';
        $xmlContent .= '</contrato>';
        $xmlContent .= '<persona>';
        $xmlContent .= '<rol>VI</rol>';
        $xmlContent .= '<nombre>'.htmlspecialchars($this->firstName).'</nombre>';
        $xmlContent .= '<apellido1>'.htmlspecialchars($this->subName).'</apellido1>';
        $xmlContent .= $this->lastName != null? '<apellido2>'.htmlspecialchars($this->lastName).'</apellido2>':'<apellido2></apellido2>';
        $xmlContent .= '<tipoDocumento>'.htmlspecialchars($this->getTypeOfSelectedDocument()).'</tipoDocumento>';
        $xmlContent .= '<numeroDocumento>'.htmlspecialchars($this->documentNumber).'</numeroDocumento>';
        $xmlContent .= $this->suportNumber != null?'<soporteDocumento>'.htmlspecialchars($this->suportNumber).'</soporteDocumento>' : '<soporteDocumento></soporteDocumento>';
        $xmlContent .= '<fechaNacimiento>'.htmlspecialchars($fechaNacimiento).'</fechaNacimiento>';
        $xmlContent .= $this->countrySelected != null ? '<nacionalidad>'.htmlspecialchars($this->getSpecificCodeIso()).'</nacionalidad>': '<nacionalidad></nacionalidad>';
        $xmlContent .= $this->sex != null ?'<sexo>'.htmlspecialchars($this->sex).'</sexo>': '<sexo></sexo>';
        $xmlContent .= '<direccion>';
        $xmlContent .= '<direccion>'.htmlspecialchars($this->formatAddress()).'</direccion>';
        $xmlContent .= '<direccionComplementaria></direccionComplementaria>';
        if ($addresses['country'] == 'España') {
            $xmlContent .= '<codigoMunicipio>'.htmlspecialchars($this->getSpecificProvinceAndMunicipality()).'</codigoMunicipio>';  
        } else {
            $xmlContent .= '<nombreMunicipio>'.htmlspecialchars($addresses['addressMunicipality']).'</nombreMunicipio>';
        }
        $xmlContent .= '<codigoPostal>'.htmlspecialchars($this->postalCode).'</codigoPostal>';
        $xmlContent .= '<pais>'.htmlspecialchars($this->getSpecificCodeIsoOfCountryAddress()).'</pais>';
        $xmlContent .= '</direccion>';
        $xmlContent .= $this->phoneNumber != null && !empty($this->phoneNumber)? '<telefono>'.htmlspecialchars($this->phoneNumber).'</telefono>':'<telefono></telefono>';
        $xmlContent .= '<telefono2></telefono2>';
        $xmlContent .= $this->emailAddress != null && !empty($this->emailAddress)? '<correo>'.htmlspecialchars($this->emailAddress).'</correo>':'<correo></correo>';
        $xmlContent .= $this->kinshipLodging != null && !empty($this->kinshipLodging)? '<parentesco>'.htmlspecialchars($this->getCodeTypeOfKinshipLodging()).'</parentesco>':'<parentesco></parentesco>';
        $xmlContent .= '</persona>';
        $xmlContent .= '</comunicacion>';
        $xmlContent .= '</solicitud>';
        $xmlContent .= '</ns2:peticion>';
        return $xmlContent;
    }

    /**
     * Devuelve el código de parentesco según el tipo de parentesco.
     *
     * Tipos de parentesco:
     * - AB: Abuelos
     * - BA: Padres
     * - BN: Hermanos
     * - CY: Cuñados
     * - CD: Cuñado
     * - HR: Hermanos
     * - HJ: Hijos
     * - PM: Padres y Madre
     * - NI: Nietos
     * - SB: Sobrinos
     * - SG: Suegros
     * - TI: Tíos
     * - YN: Yernos
     * - TU: Tías
     * - OT: Otros
     *
     * @return string El código correspondiente al tipo de parentesco.
     */
    public function getCodeTypeOfKinshipLodging() {
        switch($this->kinshipLodging) {
            case 'Abuelos':
                return 'AB';
            case 'Bisabuelos':
                return 'BA';
            case 'Cónyuge':
                return 'CY';
            case 'Cuñado/Cuñada':
                return 'CD';
            case 'Hermano/Hermana':
                return 'HR';
            case 'Hijo/Hija':
                return 'HJ';
            case 'Padres y Madre':
                return 'PM';
            case 'Nieto/Nieta':
                return 'NI';
            case 'Sobrino/Sobrina':
                return 'SB';
            case 'Suegros/Suegra':
                return 'SG';
            case 'Tío/Tía':
                return 'TI';
            case 'Yernos':
                return 'YN';
            default:
                return 'OT';
        }
    }
}
