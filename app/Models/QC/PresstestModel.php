<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresstestModel extends Model
{
    //
    use HasFactory;

    protected $table = 'presstest_qc';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['jarak', 'status', 'waktu'  ];
}
