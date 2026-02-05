<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_STAFF = 3;
    public const ROLE_RECEPTIONIST = 4;
    public const ROLE_ADMINISTRATIVE = 5;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
     public $fillable = [
        'first_name',
        'sub_name',
        'email_address',
        'last_name',
        'phone_number',
        'type',
        'uuid',
        'password',
        'address_uuid',
        'hotel_uuid',
    ];

    /**
     * Los atributos que deben ocultarse en la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
            'uuid' => 'string',
        ];
    }

    /*
     * Verify user exists with received credentials.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return User|null
     */
    public function getSpecificUser(string $emailAddress, string $password) {
        if (empty($emailAddress) || empty($password)) {
            return null;
        }
        // Buscar el usuario por nombre
        $user = $this::where('email_address', $emailAddress)->first();
        // Verificar si el usuario existe y si la contrasea es correcta
        if ($user && Hash::check($password, $user->password)) {
            return $user->getDecryptDataOfUser();
        }
        return null;
    }
  
    /*
     * Decrypt user fields stored with symmetric encryption.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return User
     */
    public function getDecryptDataOfUser(){
        $crypt = new Crypt();
        if (!empty($this->first_name)) $this->first_name = $crypt->decryptData($this->first_name);
        if (!empty($this->sub_name)) $this->sub_name = $crypt->decryptData($this->sub_name);
        if (!empty($this->last_name)) $this->last_name = $crypt->decryptData($this->last_name);
        if (!empty($this->phone_number))$this->phone_number = $crypt->decryptData($this->phone_number);
        if (!empty($this->type))$this->type = $crypt->decryptData($this->type);
        return $this;
    }

    /*
     * Encrypt user fields and hash password before persistence.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return User
     */
    public function setEncryptDataOfUser(){
        $crypt = new Crypt();
        if (!empty($this->first_name)) $this->first_name = $crypt->encryptData($this->first_name);
        if (!empty($this->sub_name)) $this->sub_name = $crypt->encryptData($this->sub_name);
        if (!empty($this->last_name)) $this->last_name = $crypt->encryptData($this->last_name);
        if (!empty($this->phone_number)) $this->phone_number = $crypt->encryptData($this->phone_number);
        if (!empty($this->type)) $this->type = $crypt->encryptData($this->type);
        if (!empty($this->password) && Hash::needsRehash($this->password)) $this->password = Hash::make($this->password);
        return $this;
    }
    
    /*
     * Get users related to a hotel and decrypt their data.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return array
     */
     public function getAllUsersWithHotel(string $hotelUUID){
        $users = $this::where('hotel_uuid',  $hotelUUID)->orderBy('id', 'desc')->get();
        $allUser = [];
        foreach ($users as $user) {
            $allUser[] = $user->getDecryptDataOfUser();
        }
        return $allUser;
    }

    /*
     * Save user data with encryption and password hashing applied.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return User
     */
    public function saveUser(array $data){
        $this->fill($data);
        $this->setEncryptDataOfUser();
        $this->save();
        return $this;
    }

    /*
     * Get total users related to a hotel.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return int
     */
    public function getTotalUsersWithHotel(string $hotelUUID){
        return $this::where('hotel_uuid', $hotelUUID)->count();
    }

    /*
     * Get full name for display.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return string
     */
    public function getFullName(){
        $firstName = $this->first_name ?? '';
        $subName = $this->sub_name ?? '';
        $lastName = $this->last_name ?? '';
        $fullName = trim($firstName . ' ' . $subName . ' ' . $lastName);
        return preg_replace('/\s+/', ' ', $fullName);
    }

    /*
     * Validate input data for creating or updating a user.
     * @author SGV
     * @version 1.0 - 20250201 - initial release
     * @return array
     */
    public function validateInput(Request $request, bool $isUpdate = false) {
        try {
            $rules = [
                'first_name' => 'required|string',
                'sub_name' => 'required|string',
                'email_address' => 'required|email',
                'last_name' => 'nullable|string',
                'phone_number' => 'required|string',
                'type' => 'required|string',
                'uuid' => 'nullable|string',
                'address_uuid' => 'nullable|string',
                'hotel_uuid' => 'nullable|string',
            ];
            if ($isUpdate) {
                $rules['password'] = 'nullable|string';
            } else {
                $rules['password'] = 'required|string';
            }
            $messages = [
                'first_name.required' => 'El nombre es obligatorio.',
                'first_name.string' => 'El nombre debe ser un texto valido.',
                'sub_name.required' => 'El primer apellido es obligatorio.',
                'sub_name.string' => 'El primer apellido debe ser un texto valido.',
                'email_address.required' => 'El correo electronico es obligatorio.',
                'email_address.email' => 'El correo electronico no es valido.',
                'last_name.string' => 'El segundo apellido debe ser un texto valido.',
                'phone_number.required' => 'El telefono es obligatorio.',
                'phone_number.string' => 'El telefono debe ser un texto valido.',
                'type.required' => 'El tipo de usuario es obligatorio.',
                'type.string' => 'El tipo de usuario debe ser un texto valido.',
                'uuid.string' => 'El UUID debe ser un texto valido.',
                'address_uuid.required' => 'La direccion es obligatoria.',
                'address_uuid.string' => 'La direccion debe ser un texto valido.',
                'hotel_uuid.required' => 'El hotel es obligatorio.',
                'hotel_uuid.string' => 'El hotel debe ser un texto valido.',
                'password.required' => 'La contrasena es obligatoria.',
                'password.string' => 'La contrasena debe ser un texto valido.',
            ];

            $validatedData = $request->validate($rules, $messages);
            return [
                'success' => true,
                'value' => $validatedData,
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors(),
            ];
        }
    }

    public function getAllTypeFormat(){
        return [
            "Administrador" => User::ROLE_ADMIN,
            "Administrador / Financiero" => User::ROLE_ADMINISTRATIVE,
            "Recepcionista" => User::ROLE_RECEPTIONIST,   
        ];
    }

    public function getNameType(){
        switch($this->type){
            case User::ROLE_ADMIN:
                return  "Administrador";
            case  User::ROLE_ADMINISTRATIVE:
                return  "Administrador / Financiero";
            case  User::ROLE_RECEPTIONIST: 
                return "Recepcionista";
            default:
            return "Indefinido";

        }
    }


    public function getSpecificUserWithUuid(string $uuid) {
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $userWk = $this::where('uuid', $uuid)->first();
        if ($userWk) {
            return $userWk;
        }
    
        return null;
    }


}
