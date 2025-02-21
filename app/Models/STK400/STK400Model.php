<?php

namespace App\Models\STK400;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class STK400Model extends Model
{
    //
    use HasFactory;

    protected $table = 'readsensors_stk400';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'waktu',
        'Tank_Glucose',
        'Flowrate',
    ];

}
