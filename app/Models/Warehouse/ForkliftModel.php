<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class ForkliftModel extends Model
{
    use HasFactory;

    protected $table = 'forklifts';

    protected $fillable = [
        'nomor_unit',
        'departemen',
        'status',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke User Assignment
    // Konstanta untuk enum values
    const DEPARTEMEN_WAREHOUSE = 'warehouse';
    const DEPARTEMEN_PRODUKSI = 'produksi';

    const STATUS_ACTIVE = 'active';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_INACTIVE = 'inactive';

    // Accessor untuk mendapatkan array departemen
    public static function getDepartemenOptions()
    {
        return [
            self::DEPARTEMEN_WAREHOUSE => 'Warehouse',
            self::DEPARTEMEN_PRODUKSI => 'Produksi',
        ];
    }

    // Accessor untuk mendapatkan array status
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    // Relationship dengan UserForkliftAssignmentModel
    public function userAssignments(): HasMany
    {
        return $this->hasMany(UserForkliftAssignmentModel::class, 'forklift_id');
    }

    // Relationship untuk mendapatkan assignment yang aktif
    public function activeAssignments(): HasMany
    {
        return $this->hasMany(UserForkliftAssignmentModel::class, 'forklift_id')
        ->where('is_active', true);
    }

    // Relationship untuk mendapatkan primary assignment yang aktif
    public function primaryAssignment(): HasOne
    {
        return $this->hasOne(UserForkliftAssignmentModel::class, 'forklift_id')
        ->where('is_active', true)
            ->where('is_primary', true);
    }

    // Get all assigned operators (termasuk backup) - sesuai dengan controller
    public function assignedOperators(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_forklift_assignments',
            'forklift_id',
            'user_id'
        )->withPivot('id', 'is_primary', 'assigned_date', 'is_active', 'notes')
        ->wherePivot('is_active', true);
    }

    // Get primary operator - sesuai dengan controller
    public function primaryOperator()
    {
        return $this->assignedOperators()
            ->wherePivot('is_primary', true)
            ->first();
    }

    // Scope untuk filter berdasarkan departemen
    public function scopeByDepartemen($query, $departemen)
    {
        return $query->where('departemen', $departemen);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk forklift yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Scope untuk forklift warehouse
    public function scopeWarehouse($query)
    {
        return $query->where('departemen', self::DEPARTEMEN_WAREHOUSE);
    }

    // Scope untuk forklift produksi
    public function scopeProduksi($query)
    {
        return $query->where('departemen', self::DEPARTEMEN_PRODUKSI);
    }

    // Method untuk mengecek apakah forklift sedang aktif
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    // Method untuk mengecek apakah forklift sedang maintenance
    public function isMaintenance(): bool
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    // Method untuk mengecek apakah forklift inactive
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    // Method untuk mengecek apakah user bisa mengoperasikan forklift ini
    public function canBeOperatedBy($userId): bool
    {
        return $this->userAssignments()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }

    // Method untuk mendapatkan user yang sedang assigned ke forklift ini
    public function getCurrentUsers()
    {
        return $this->assignedOperators;
    }

    // Method untuk mendapatkan primary user
    public function getPrimaryUser()
    {
        return $this->primaryOperator();
    }
}
