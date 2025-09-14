<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisatas';

    protected $fillable = [
        'nama_wisata',
        'short_description',
        'long_description',
        'image',
        'harga',
        'active_days',
        'max_personil'
    ];
}