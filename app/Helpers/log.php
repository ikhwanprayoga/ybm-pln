<?php

namespace App\Helpers;

use App\Models\LogAktivitas;

class LogServiceProvider
{
    public static function LogTes()
    {
        return 'log aktivitas berhasil';
    }

    public static function catat(array $array)
    {
        LogAktivitas::create($array);
        return true;
    }
}
