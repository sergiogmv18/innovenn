<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class TravelDocument extends Model
{
    use HasFactory;

    /**
     * Create Documents in storade
     * 
     * @param string $nameDirectory name of directory to save file
     * @param string $nameFile name of file to save    
     * @param string $content content base 64
     * @param string $extension extension of file 
     * @return
     */
    public function createDocuments(string $nameDirectory, string $nameFile, string $content, string $extension) {
        try {
            // Validar parámetros
            if (empty($nameDirectory) || empty($nameFile) || empty($content) || empty($extension)) {
                return null;
            }
            // Validar extensión segura
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'txt'];
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return null;
            }
            // Decodificar el contenido base64
            $contenidoDecodificado = base64_decode($content);
            if ($contenidoDecodificado === false) {
                return null;
            }
            // Asegurarse de que el directorio existe
            Storage::disk('public')->makeDirectory($nameDirectory);
            // Definir el path dentro del storage (con nombre único)
            $uniqueName = $nameFile . '-' . Str::random(10) . '.' . $extension;
            $path = $nameDirectory . '/' . $uniqueName;
            // Guardar en storage/app/public/...
            Storage::disk('public')->put($path, $contenidoDecodificado);
            return $path; // Retorna la ruta del archivo
        } catch (Exception $e) {
            return null;
        }
    }
    /**
     * Delete file from storage
     * 
     * @param string $path Ruta completa del archivo en storage (ej. 'carpeta/archivo.jpg')
     * @return bool True si se eliminó, False si no se encontró o falló
     */
    public function deleteDocument(string $path) {
    try {
        // Verificar que el archivo exista
        if (Storage::disk('public')->exists($path)) {
            // Eliminar el archivo
            return Storage::disk('public')->delete($path);
        }
        return false; // Archivo no encontrado
    } catch (Exception $e) {
        return false;
    }
}
}
