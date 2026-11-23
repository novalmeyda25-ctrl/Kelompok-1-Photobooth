<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoSession extends Model
{
    use HasFactory;

    protected $table = 'photo_session';

    protected $fillable = [
        'user_id',
        'session_code',
    ];

    // Relasi: PhotoSession milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: PhotoSession memiliki banyak Photo
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}