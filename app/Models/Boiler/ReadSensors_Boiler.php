<?php

namespace App\Models\Boiler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadSensors_Boiler extends Model
{
    use HasFactory;

    protected $table = 'readsensors_boiler';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'waktu',
        'LevelFeedWater',
        'PVSteam',
        'FeedPressure',
        'LHGuiloutine',
        'RHGuiloutine',
        'LHTemp',
        'RHTemp',
        'IDFan',
        'LHFDFan',
        'RHFDFan',
        'LHStoker',
        'RHStoker',
        'WaterPump1',
        'WaterPump2',
        'InletWaterFlow',
        'OutletSteamFlow',
        'SuhuFeedTank',
        'O2',
        'CO2',
        'Batubara_FK',
        'Steam_FK'
    ];
}
