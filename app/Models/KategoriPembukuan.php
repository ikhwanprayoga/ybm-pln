<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPembukuan extends Model
{
    protected $table = 'kategori_pembukuans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_pembukuan', 'kode', 'slug', 'keterangan'
    ];
    public $timesstamps = true;

    public function pembukuans()
    {
        return $this->hasMany('App\Models\Pembukuan');
    }
}
