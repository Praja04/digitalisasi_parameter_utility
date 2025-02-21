<?php

namespace App\Models\Glucose;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GlucoseModel extends Model
{
    use HasFactory;

    protected $table = 'readsensors_glucose';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'waktu',
        'GST1',
        'GST2',
        'GST3',
        'GST4',
        'GST5',
    ];
}
