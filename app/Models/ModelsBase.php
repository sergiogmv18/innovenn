<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelsBase extends Model
{
     /**
     * Create uuid
     * 
     * @return string
     */
    static public function createUUID(): string {
        return bin2hex(random_bytes(30)); // 30 bytes * 2 = 60 caracteres hexadecimales
    }
}
