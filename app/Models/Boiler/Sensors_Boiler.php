<?php

namespace App\Models\Boiler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Sensors_Boiler extends Model
{
    use HasFactory;

    protected $table = 'sensors_boiler';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'waktu',
        'Batubara',
        'Steam',
    ];
}
