<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class BillingData extends Model
{
    protected $table = 'billingdata';
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    public $fillable = [
        'name',
        'footer',
        'postalCode',
        'uuid',
        'address',
        'typeBillingData',
        'documentNumber',
        'photoPath',
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
     * Get the last travel
     * 
     * @return BillingData|null
     */
    public function getBillingData(){
        return $this::orderBy('created_at', 'desc')->first();
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
                'name' => 'required|string',
                'footer' => 'required|string',
                'postalCode' => 'required|string',
                'uuid' => 'nullable|string',
                'address' => 'required|string',
                'typeBillingData' => 'required|string',
                'photoPath' => 'required|string',
                'documentNumber'=>'required|string',
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
     * get all address string
     * @param  bool $isArray - return string or array
     * @return array|string
     */
    public function getAddress(bool $isArray){
        $arrayOfaddress =json_decode(json: $this->address, associative: true)[0];
        if($isArray){
            return $arrayOfaddress;
        }
        return $arrayOfaddress['address'].', '.$arrayOfaddress['addressNumber'].', '.$arrayOfaddress['addressMunicipality'].', '.$arrayOfaddress['addressProvince'];
    }


     /**
     * Get Specific billingData
     * @param string $uuid
     * @return BillingData|null if uuid no exist
     */
    public function getSpecificBillingData(string $uuid) {
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $billingData = $this::where('uuid', $uuid)->first();
        if ($billingData) {
            return $billingData;
        }
    
        return null;
    }

    

}

