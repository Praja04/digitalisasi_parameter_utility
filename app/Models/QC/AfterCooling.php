<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AfterCooling extends Model
{
    //
    use HasFactory;

    protected $table = 'after_cooling_qc';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['user','viscositas','brix','aw','ph','bj','buih','endapan'];


}
