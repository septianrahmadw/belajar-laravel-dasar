<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getBookingsForDate(string $date): HasMany
    {
        return $this->bookings()
            ->whereDate('date', $date)
            ->where('status', 'approved');
    }

    public function isAvailableForTime(string $date, string $startTime, string $endTime, ?int $excludeBookingId = null): bool
    {
        $query = $this->bookings()
            ->whereDate('date', $date)
            ->whereIn('status', ['approved', 'pending'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }
}
