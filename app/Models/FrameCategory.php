<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameCategory extends Model
{
    use HasFactory;

    protected $table = 'frame_categories';

    protected $fillable = [
        'name',
    ];

    // Relasi: FrameCategory memiliki banyak Frame
    public function frames()
    {
        return $this->hasMany(Frame::class);
    }
}