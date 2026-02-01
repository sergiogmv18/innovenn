<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';

    /**
     * @var list<string>
     */
    public $fillable = [
        'name',
        'address_uuid',
        'email',
        'document_number',
        'phone_number',
        'is_active',
        'next_payment_due', // control de pago
        'uuid',
        'name',
        'plan_uuid',
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
        ];
    }

    public function getDecryptDataOfHotel(){
        $crypt = new Crypt();
        if (!empty($this->name)) $this->name = $crypt->decryptData($this->name);
        if (!empty($this->address_uuid)) $this->address_uuid = $crypt->decryptData($this->address_uuid);
        if (!empty($this->email)) $this->email = $crypt->decryptData($this->email);
        if (!empty($this->document_number)) $this->document_number = $crypt->decryptData($this->document_number);
        if (!empty($this->phone_number)) $this->phone_number = $crypt->decryptData($this->phone_number);
        if (!empty($this->plan_uuid)) $this->plan_uuid = $crypt->decryptData($this->plan_uuid);
        return $this;
    }

    public function setEncryptDataOfHotel(){
        $crypt = new Crypt();
        if (!empty($this->name)) $this->name = $crypt->encryptData($this->name);
        if (!empty($this->address_uuid)) $this->address_uuid = $crypt->encryptData($this->address_uuid);
        if (!empty($this->email)) $this->email = $crypt->encryptData($this->email);
        if (!empty($this->document_number)) $this->document_number = $crypt->encryptData($this->document_number);
        if (!empty($this->phone_number)) $this->phone_number = $crypt->encryptData($this->phone_number);
        if (!empty($this->plan_uuid)) $this->plan_uuid = $crypt->encryptData($this->plan_uuid);
        return $this;
    }

    public function saveHotel(array $data){
        $this->fill($data);
        $this->setEncryptDataOfHotel();
        $this->save();
        return $this;
    }


     /**
     * Get Specific hotel
     * @param string $uuid
     * @return Hotel|null if uuid no exist
     */
    public function getSpecificHotel(string $uuid) {
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $hotel = $this::where('uuid', $uuid)->first();
        if ($hotel) {
            return $hotel;
        }
    
        return null;
    }
}
