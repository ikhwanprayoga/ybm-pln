<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAshnaf extends Model
{
    protected $table = 'kategori_ashnafs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_ashnaf'
    ];
    public $timesstamps = true;
}
