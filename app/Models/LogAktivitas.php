<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pembukuan_id', 'user', 'tipe', 'aktivitas', 'nominal', 'keterangan'
    ];

    public $timestamps = 'true';
}
