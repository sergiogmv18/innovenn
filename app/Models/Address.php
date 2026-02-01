<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    /**
     * @var list<string>
     */
    public $fillable = [
        'uuid',
        'address',
        'postalCode',
        'city',
        'state',
        'country',
        'number',
        'district',
        'complement',
        'notes',
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

    public function getDecryptDataOfAddress(){
        $crypt = new Crypt();
        if (!empty($this->address)) $this->address = $crypt->decryptData($this->address);
        if (!empty($this->postalCode)) $this->postalCode = $crypt->decryptData($this->postalCode);
        if (!empty($this->city)) $this->city = $crypt->decryptData($this->city);
        if (!empty($this->state)) $this->state = $crypt->decryptData($this->state);
        if (!empty($this->country)) $this->country = $crypt->decryptData($this->country);
        if (!empty($this->number)) $this->number = $crypt->decryptData($this->number);
        if (!empty($this->district)) $this->district = $crypt->decryptData($this->district);
        if (!empty($this->complement)) $this->complement = $crypt->decryptData($this->complement);
        if (!empty($this->notes)) $this->notes = $crypt->decryptData($this->notes);
        return $this;
    }

    public function setEncryptDataOfAddress(){
        $crypt = new Crypt();
        if (!empty($this->address)) $this->address = $crypt->encryptData($this->address);
        if (!empty($this->postalCode)) $this->postalCode = $crypt->encryptData($this->postalCode);
        if (!empty($this->city)) $this->city = $crypt->encryptData($this->city);
        if (!empty($this->state)) $this->state = $crypt->encryptData($this->state);
        if (!empty($this->country)) $this->country = $crypt->encryptData($this->country);
        if (!empty($this->number)) $this->number = $crypt->encryptData($this->number);
        if (!empty($this->district)) $this->district = $crypt->encryptData($this->district);
        if (!empty($this->complement)) $this->complement = $crypt->encryptData($this->complement);
        if (!empty($this->notes)) $this->notes = $crypt->encryptData($this->notes);
        return $this;
    }

    public function saveAddress(array $data){
        $this->fill($data);
        $this->setEncryptDataOfAddress();
        $this->save();
        return $this;
    }

    public function saveAddressByUuid(string $uuid, array $data){
        $address = $this::where('uuid', $uuid)->first();
        if (!$address) {
            $address = new Address();
            $address->uuid = $uuid;
        }
        $address->fill($data);
        $address->setEncryptDataOfAddress();
        $address->save();
        return $address;
    }
}
