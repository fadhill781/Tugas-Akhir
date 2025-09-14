<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsSetting extends Model
{
    protected $table = 'cms_settings';

    protected $fillable = [
        'nama',
        'deskripsi',
        'image',
        'footer',
    ];
     public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}

