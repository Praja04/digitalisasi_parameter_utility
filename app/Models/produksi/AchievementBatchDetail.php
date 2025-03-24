<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementBatchDetail extends Model
{
    use HasFactory;

    protected $table = 'achievement_batch_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'achievement_batch_id',
        'shift',
        'batch_count',
        'created_by_user',
    ];

    public $timestamps = false; 

    // Relasi ke Batch Utama
    public function batch()
    {
        return $this->belongsTo(AchievementBatch::class, 'achievement_batch_id');
    }
}