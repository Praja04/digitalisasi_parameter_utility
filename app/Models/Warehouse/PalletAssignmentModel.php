<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Models\User;

class PalletAssignmentModel extends Model
{
    use HasFactory;

    protected $table = 'user_pallet_assignments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pallet_mover_id',
        'user_id',
        'assigned_by',
        'assigned_date',
        'is_primary',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'assigned_date' => 'date'
    ];

    // 🔗 Relasi
    public function palletMover(): BelongsTo
    {
        return $this->belongsTo(PalletMoverModel::class, 'pallet_mover_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedByUser(): BelongsTo
    {
        return $this->assignedBy();
    }

    // 🔍 Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeBackup($query)
    {
        return $query->where('is_primary', false);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByPallet($query, $palletId)
    {
        return $query->where('pallet_mover_id', $palletId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('assigned_date', Carbon::today());
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('assigned_date', [$startDate, $endDate]);
    }

    // 🔧 Helpers
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    public function isSecondary(): bool
    {
        return !$this->is_primary;
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function setPrimary()
    {
        self::where('pallet_mover_id', $this->pallet_mover_id)
            ->where('id', '!=', $this->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

        $this->update(['is_primary' => true]);
    }

    public function removePrimary()
    {
        $this->update(['is_primary' => false]);
    }

    public function getDurationInDays(): int
    {
        return Carbon::parse($this->assigned_date)->diffInDays(Carbon::now());
    }

    public function getFormattedAssignedDate(): string
    {
        return $this->assigned_date->format('d M Y');
    }

    // 🔁 Events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($assignment) {
            if (!$assignment->assigned_date) {
                $assignment->assigned_date = Carbon::today();
            }
        });

        static::created(function ($assignment) {
            if ($assignment->is_primary) {
                self::where('pallet_mover_id', $assignment->pallet_mover_id)
                    ->where('id', '!=', $assignment->id)
                    ->where('is_primary', true)
                    ->update(['is_primary' => false]);
            }
        });

        static::updating(function ($assignment) {
            if ($assignment->isDirty('is_primary') && $assignment->is_primary) {
                self::where('pallet_mover_id', $assignment->pallet_mover_id)
                    ->where('id', '!=', $assignment->id)
                    ->where('is_primary', true)
                    ->update(['is_primary' => false]);
            }
        });
    }
}
