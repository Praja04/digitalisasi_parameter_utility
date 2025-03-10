<?php

namespace App\Models\Pasteurisasi1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor_Pasteurisasi1 extends Model
{
    //
    use HasFactory;

    protected $table = 'readsensors_pasteurisasi1';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'Waktu',
        'SpeedPompaMixing',
        'PressureMixing',
        'SuhuPreheating',
        'LevelBT1',
        'SpeedPumpBT1',
        'LevelVD',
        'SpeedPumpVD',
        'Flowrate',
        'SuhuHeating',
        'SuhuHolding',
        'SuhuPrecooling',
        'LevelBT2',
        'SpeedPumpBT2',
        'PressureBT2',
        'SuhuCooling',
        'PressToPasteur',
        'PressVDHH',
        'PressVDLL',
        'MixingAM',
        'BT1AM',
        'VDAM',
        'PCV1',
        'TimeDivert',
        'Mode',
        'Varian',
        'Batch',
        'Storage',
    ];

    public static function getLatestData($limit = 10)
    {
        return self::orderBy('Waktu', 'desc')->limit($limit)->get();
    }
}
