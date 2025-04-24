<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AfterCoolingDetail extends Model
{
    //
       //
       use HasFactory;

       protected $table = 'after_cooling_detail';
       protected $primaryKey = 'id';
       public $timestamps = false;
   
       protected $fillable = ['id_after_cooling','user','viscositas','brix','aw','ph','bj','buih','endapan','shift','organo','created_by_user','warna'];
   
   
     // Relasi ke Batch Utama
     public function aftercooling()
     {
         return $this->belongsTo(AfterCooling::class, 'id_after_cooling');
     }
}
