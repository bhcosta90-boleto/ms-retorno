<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retorno extends Model
{
    public static function booted(): void{
        parent::creating(fn($obj) => $obj->md5 = md5($obj->nomearquivo));
    }
    public $fillable = [
        'banco_id',
        'nomearquivo',
        'data',
    ];
}
