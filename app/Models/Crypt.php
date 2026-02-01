<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crypt extends Model
{
/**
 * Generar clave simétrica
 * 
 * @return array
 */
static function generateSymmetricKey() {
    $symmetricAppKey = "78L/7eFnFo0ykBpI2XenaN+0cFg1SA1rpywx4toPkII="; // Clave de 32 bytes (256 bits)
    return [
        'key' => $symmetricAppKey
    ];
}

/**
 * Encriptar datos con AES-256-CTR
 * 
 * @param string $data
 * @return string
 */
function encryptData($data) {
    $key = base64_decode($this::generateSymmetricKey()['key']);
    $ivLength = openssl_cipher_iv_length('aes-256-ctr');
    $iv = openssl_random_pseudo_bytes($ivLength); // Generar IV de 16 bytes

    // Encriptar datos
    $encrypted = openssl_encrypt($data, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);

    // Combinar IV + Encrypted y codificar en Base64
    return base64_encode($iv . $encrypted);

}

/**
 * Desencriptar datos con AES-256-CTR
 * 
 * @param string $encryptedPayload
 * @return string|false
 */
function decryptData($encryptedPayload) {
    $key = base64_decode($this::generateSymmetricKey()['key']);
    $ivLength = openssl_cipher_iv_length('aes-256-ctr');
    $encryptedPayload = base64_decode($encryptedPayload);

    // Extraer IV (primeros 16 bytes) y Encrypted Data (resto)
    $iv = substr($encryptedPayload, 0, $ivLength);
    $encryptedData = substr($encryptedPayload, $ivLength);

    // Verificar tamaño del IV
    if (strlen($iv) !== $ivLength) {
        return false;
    }

    // Desencriptar datos
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);

    // Verificar si la desencriptación falló
    if ($decryptedData === false) {
        return false;
    }

    return $decryptedData;
}

}
