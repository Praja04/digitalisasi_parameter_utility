<?php

namespace App\Models\ST53;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ST53Model extends Model
{
    use HasFactory;

    protected $table = 'readsensors_st53';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada kolom `waktu` yang otomatis

    protected $fillable = [
        'waktu',
        'A1', 'A2', 'A3', 'A4', 'A5',
        'B1', 'B2', 'B3', 'B4', 'B5',
        'C1', 'C2', 'C3', 'C4', 'C5',
        'D1', 'D2', 'D3', 'D4', 'D5',
        'DTS', 'DTP3', 'DTP2', 'DTP1', 'DTB',
        'MSD1', 'MSD2', 'JERIKEN'
    ];


    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
    }

}
