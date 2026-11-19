<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * Menangani proses download foto dengan validasi kepemilikan.
     */
    public function download($id)
{
    $photo = Photo::findOrFail($id);

    // Memanggil PhotoPolicy method 'download' secara otomatis
    $this->authorize('download', $photo);

    $filePath = storage_path('app/public/' . $photo->result_image_path);

    if (!file_exists($filePath)) {
        abort(404, 'File foto tidak ditemukan.');
    }

    return response()->download($filePath);
}};