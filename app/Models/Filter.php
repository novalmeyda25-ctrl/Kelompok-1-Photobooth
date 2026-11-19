<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'css_filter',
    ];

    // Relasi: Filter digunakan oleh banyak Photo
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}