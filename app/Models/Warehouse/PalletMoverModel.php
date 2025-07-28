<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class PalletMoverModel extends Model
{
    use HasFactory;

    protected $table = 'pallet_movers';

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

    // 🔁 Konstanta ENUM
    const DEPARTEMEN_WAREHOUSE = 'warehouse';
    const DEPARTEMEN_PRODUKSI = 'produksi';

    const STATUS_ACTIVE = 'active';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_INACTIVE = 'inactive';

    // 📦 Options untuk dropdown
    public static function getDepartemenOptions()
    {
        return [
            self::DEPARTEMEN_WAREHOUSE => 'Warehouse',
            self::DEPARTEMEN_PRODUKSI => 'Produksi',
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    // 🔗 Relasi
    public function userAssignments(): HasMany
    {
        return $this->hasMany(PalletAssignmentModel::class, 'pallet_mover_id');
    }

    public function activeAssignments(): HasMany
    {
        return $this->userAssignments()->where('is_active', true);
    }

    public function primaryAssignment(): HasOne
    {
        return $this->hasOne(PalletAssignmentModel::class, 'pallet_mover_id')
            ->where('is_active', true)
            ->where('is_primary', true);
    }

    public function assignedOperators(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_pallet_assignments',
            'pallet_mover_id',
            'user_id'
        )->withPivot('id', 'is_primary', 'assigned_date', 'is_active', 'notes')
            ->wherePivot('is_active', true);
    }

    public function primaryOperator()
    {
        return $this->assignedOperators()
            ->wherePivot('is_primary', true)
            ->first();
    }

    // 🔍 Scopes
    public function scopeByDepartemen($query, $departemen)
    {
        return $query->where('departemen', $departemen);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeWarehouse($query)
    {
        return $query->where('departemen', self::DEPARTEMEN_WAREHOUSE);
    }

    public function scopeProduksi($query)
    {
        return $query->where('departemen', self::DEPARTEMEN_PRODUKSI);
    }

    // 🔧 Helpers
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isMaintenance(): bool
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function canBeOperatedBy($userId): bool
    {
        return $this->userAssignments()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }

    public function getCurrentUsers()
    {
        return $this->assignedOperators;
    }

    public function getPrimaryUser()
    {
        return $this->primaryOperator();
    }
}
