<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProgram extends Model
{
    protected $table = 'kategori_programs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_program'
    ];
    public $timesstamps = true;
}
