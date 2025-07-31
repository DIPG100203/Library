<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'autor_id'
    ];

    public function autor(){
        return $this->belongsTo(Autor::class);
    }
}
