<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRunning extends Model
{
    //
    use HasFactory;

    protected $table = 'status_running_produksi';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['produk','varian','batch','storage','created_by'];


}
