<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    /**
     * Tentukan apakah user dapat mendownload / melihat foto.
     */
    public function download(User $user, Photo $photo): bool
    {
        // Admin diizinkan mengakses semua foto
        if ($user->role === 'admin') {
            return true;
        }

        // Load relasi photoSession jika belum ada, lalu cek kepemilikan user_id
        $photo->loadMissing('photoSession');

        return $photo->photoSession && $photo->photoSession->user_id === $user->id;
    }
}