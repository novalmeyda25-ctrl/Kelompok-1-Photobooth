<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use HasFactory;

    protected $fillable = [
        'frame_category_id',
        'name',
        'image_path',
        'is_active'
    ];

  

    // Relasi: Frame digunakan oleh banyak Photo
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}