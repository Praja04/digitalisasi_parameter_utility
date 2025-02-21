<?php

namespace App\Models\Boiler;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbSteam_Boiler extends Model
{
    
    use HasFactory;

    protected $table = 'bb_steam_boiler';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'waktu',
        'bb_steam',
        'AvgBatubara',
        'AvgSteam',
    ];
}
