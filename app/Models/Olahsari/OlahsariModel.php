<?php

namespace App\Models\Olahsari;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OlahsariModel extends Model
{
    //
    use HasFactory;

    protected $table = 'readsensors_olahsari';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'waktu',
        'TempMixer1',
        'LC_Mixer1',
        'TempMixer2',
        'LC_Mixer2',
    ];

    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
    }
}
