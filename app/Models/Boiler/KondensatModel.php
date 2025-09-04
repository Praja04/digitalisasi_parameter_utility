<?php

namespace App\Models\Boiler;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KondensatModel extends Model
{
    //
    protected $table = 'kondensat';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'waktu',
        'Suhu1',
        'Suhu2',
        'Suhu3',
        'Suhu4',
        'Suhu5',
    ];
    public static function getDataPerMenit($startDate, $endDate)
    {
        return self::whereBetween('waktu', [$startDate, $endDate])
            ->whereRaw('SECOND(waktu) = 0')
            ->orderBy('waktu')
            ->get();
    }

}
