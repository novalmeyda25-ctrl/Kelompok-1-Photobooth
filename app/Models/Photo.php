<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_session_id',
        'frame_id',
        'filter_id',
        'result_image_path',
    ];

    // Relasi: Photo milik satu PhotoSession
    public function photoSession()
    {
        return $this->belongsTo(PhotoSession::class);
    }

    // Relasi: Photo menggunakan satu Frame
    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }

    // Relasi: Photo menggunakan satu Filter
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}