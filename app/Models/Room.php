<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'capacity',
        'description',
        'facilities',
        'is_active',
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function allowedProdis(): BelongsToMany
    {
        return $this->belongsToMany(Prodi::class, 'room_prodis');
    }

    public function is_restricted(): bool
    {
        return $this->allowedProdis()->exists();
    }

    public function isProdiAllowed(int $prodiId): bool
    {
        if (!$this->is_restricted()) {
            return true;
        }

        return $this->allowedProdis()->where('prodi_id', $prodiId)->exists();
    }

    public function getBookingsForDate(string $date): HasMany
    {
        return $this->bookings()
            ->whereDate('date', $date)
            ->where('status', 'approved');
    }

    public function isAvailableForTime(string $date, string $startTime, string $endTime, array|int|null $excludeBookingIds = null): bool
    {
        $query = $this->bookings()
            ->whereDate('date', $date)
            ->whereIn('status', ['approved', 'pending'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });

        if ($excludeBookingIds) {
            $query->whereNotIn('id', (array) $excludeBookingIds);
        }

        return $query->count() === 0;
    }
}
