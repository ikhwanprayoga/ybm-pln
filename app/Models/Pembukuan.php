<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembukuan extends Model
{
    protected $table = 'pembukuans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kategori_pembukuan_id',
        'kategori_ashnaf_id',
        'kategori_program_id',
        'user_id',
        'rkat_program_id',
        'tanggal',
        'tipe',
        'uraian',
        'nominal',
        'penerima_manfaat',
    ];
    public $timesstamps = true;

    public function pembukuan()
    {
        return $this->belongsTo('App\Models\KategoriPembukuan', 'kategori_pembukuan_id', 'id');
    }

    public function ashnaf()
    {
        return $this->belongsTo('App\Models\KategoriAshnaf', 'kategori_ashnaf_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\KategoriProgram', 'kategori_program_id', 'id');
    }

}
