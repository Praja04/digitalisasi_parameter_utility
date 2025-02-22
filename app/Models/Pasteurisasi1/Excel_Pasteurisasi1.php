<?php

namespace App\Models\Pasteurisasi1;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Excel_Pasteurisasi1 extends Model
{
   //
   use HasFactory;

   protected $table = 'db_excel_pasteurisasi1';
   protected $primaryKey = 'id';
   public $timestamps = false; // Karena sudah ada `waktu` otomatis

   protected $fillable = [
       'created_at',
       'Nama_File',
       'Deskripsi',
       'Excel',
       
   ];
}
