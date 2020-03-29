<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RkatProgram extends Model
{
    protected $table = 'rkat_programs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kategori_program_id',
        'parent_id',
        'rincian_rkat',
        'rupiah',
        'periode',
    ];
    public $timesstamps = true;

    public function kategoriProgram()
    {
        return $this->belongsTo('App\Models\KategoriProgram', 'kategori_program_id', 'id');
    }

    public function childRkatProgram()
    {
        return $this->hasMany('App\Models\RkatProgram', 'parent_id', 'id');
    }
}
