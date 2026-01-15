<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AfterCoolingDetail extends Model
{
    //
       //
      
     // Relasi ke Batch Utama
     public function aftercooling()
     {
         return $this->belongsTo(AfterCooling::class, 'id_after_cooling');
     }
}
