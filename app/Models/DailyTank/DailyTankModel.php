<?php

namespace App\Models\DailyTank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DailyTankModel extends Model
{
    protected $table = 'readsensors_dailytank';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'waktu',
        'DT_RO',
        'DT_Salt',
        'DT_SoySauceA',
        'DT_SoySauceB',
        'DT_SoySauceC',
    ];

    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
    }
}
