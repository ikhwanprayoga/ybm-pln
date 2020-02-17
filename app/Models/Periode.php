<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'periode', 
        'status',
    ];
    public $timesstamps = true;
}
