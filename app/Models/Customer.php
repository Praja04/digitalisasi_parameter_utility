<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model 
{
    protected $primaryKey = 'user_id'; 
    protected $keyType = 'string'; // Karena 'user_id' adalah string
    public $incrementing = false; // Tidak menggunakan auto increment

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'status',
    ];
}
