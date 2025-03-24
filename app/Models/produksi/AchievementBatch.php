<?php

namespace App\Models\produksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementBatch extends Model
{
    use HasFactory;

    protected $table = 'achievement_batch';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['batch_code', 'batch_date', 'target_batch', 'status', 'created_by_user', 'updated_by_user'];


    // Relasi ke Detail Batch (Shift)
    public function details()
    {
        return $this->hasMany(AchievementBatchDetail::class, 'achievement_batch_id');
    }
}