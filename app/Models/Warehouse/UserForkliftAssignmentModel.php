<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Models\User;

class UserForkliftAssignmentModel extends Model
{
    protected $table = 'user_forklift_assignments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'forklift_id',
        'is_primary', // true = operator utama, false = backup
        'assigned_date',
        'assigned_by', // user ID yang melakukan assignment
        'notes',
        'is_active' // untuk enable/disable sementara
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'assigned_date' => 'date'
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship dengan ForkliftModel
    public function forklift(): BelongsTo
    {
        return $this->belongsTo(ForkliftModel::class, 'forklift_id');
    }

    // Relationship dengan User yang melakukan assignment
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Alias untuk assignedBy - sesuai dengan model existing
    public function assignedByUser(): BelongsTo
    {
        return $this->assignedBy();
    }

    // Scope untuk assignment yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk assignment yang tidak aktif
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    // Scope untuk primary assignment
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Scope untuk backup/secondary assignment
    public function scopeBackup($query)
    {
        return $query->where('is_primary', false);
    }

    // Scope untuk filter berdasarkan user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk filter berdasarkan forklift
    public function scopeByForklift($query, $forkliftId)
    {
        return $query->where('forklift_id', $forkliftId);
    }

    // Scope untuk assignment hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('assigned_date', Carbon::today());
    }

    // Scope untuk assignment dalam rentang tanggal
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('assigned_date', [$startDate, $endDate]);
    }

    // Method untuk mengecek apakah assignment ini aktif
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Method untuk mengecek apakah assignment ini primary
    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    // Method untuk mengecek apakah assignment ini secondary
    public function isSecondary(): bool
    {
        return !$this->is_primary;
    }

    // Method untuk deactivate assignment
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    // Method untuk activate assignment
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    // Method untuk set sebagai primary
    public function setPrimary()
    {
        // Nonaktifkan semua primary assignment lain untuk forklift yang sama
        self::where('forklift_id', $this->forklift_id)
            ->where('id', '!=', $this->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

        // Set assignment ini sebagai primary
        $this->update(['is_primary' => true]);
    }

    // Method untuk remove primary status
    public function removePrimary()
    {
        $this->update(['is_primary' => false]);
    }

    // Method untuk mendapatkan durasi assignment (dalam hari)
    public function getDurationInDays(): int
    {
        return Carbon::parse($this->assigned_date)->diffInDays(Carbon::now());
    }

    // Method untuk mendapatkan formatted assigned date
    public function getFormattedAssignedDate(): string
    {
        return $this->assigned_date->format('d M Y');
    }

    // Boot method untuk handle events
    protected static function boot()
    {
        parent::boot();

        // Event ketika creating assignment baru
        static::creating(function ($assignment) {
            // Set assigned_date ke hari ini jika tidak diset
            if (!$assignment->assigned_date) {
                $assignment->assigned_date = Carbon::today();
            }
        });

        // Event ketika assignment dibuat dan is_primary = true
        static::created(function ($assignment) {
            if ($assignment->is_primary) {
                // Nonaktifkan primary assignment lain untuk forklift yang sama
                self::where('forklift_id', $assignment->forklift_id)
                    ->where('id', '!=', $assignment->id)
                    ->where('is_primary', true)
                    ->update(['is_primary' => false]);
            }
        });

        // Event ketika assignment diupdate dan is_primary berubah menjadi true
        static::updating(function ($assignment) {
            if ($assignment->isDirty('is_primary') && $assignment->is_primary) {
                // Nonaktifkan primary assignment lain untuk forklift yang sama
                self::where('forklift_id', $assignment->forklift_id)
                    ->where('id', '!=', $assignment->id)
                    ->where('is_primary', true)
                    ->update(['is_primary' => false]);
            }
        });
    }
}
