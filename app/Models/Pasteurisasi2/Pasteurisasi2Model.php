<?php

namespace App\Models\Pasteurisasi2;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;
class Pasteurisasi2Model extends Model
{
    use HasFactory;

    protected $table = 'readsensors_pasteurisasi2'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary Key

    public $timestamps = false; // Karena kita sudah mengatur timestamp manual

    protected $fillable = [
        'waktu',
        'SpeedPompaMixing',
        'PressureMixing',
        'SuhuPreheating',
        'LevelBT1',
        'SpeedPumpBT1',
        'LevelVD',
        'SpeedPumpVD',
        'FlowrateAM',
        'Flowrate',
        'SuhuHeating',
        'SuhuHolding',
        'SuhuPrecooling',
        'LevelBT2',
        'SpeedPumpBT2',
        'PressureBT2',
        'SuhuCooling',
        'MV1',
        'MV2'
    ];

    /**
     * Ambil data terbaru dengan limit tertentu
     */
    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
    }
}
