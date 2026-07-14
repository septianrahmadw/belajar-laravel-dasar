<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'booker_name',
        'booker_email',
        'booker_phone',
        'booker_nim',
        'purpose',
        'date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'is_recurring',
        'recurrence_id',
        'recurrence_end_date',
    ];

    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean',
        'recurrence_end_date' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function recurrenceBookings()
    {
        return $this->hasMany(static::class, 'recurrence_id', 'recurrence_id')
            ->where('id', '!=', $this->id)
            ->orderBy('date');
    }

    public function getRecurrenceCountAttribute(): int
    {
        if (!$this->recurrence_id) {
            return 0;
        }
        return static::where('recurrence_id', $this->recurrence_id)->count();
    }

    public function getFormattedStartTimeAttribute(): string
    {
        return substr($this->start_time, 0, 5);
    }

    public function getFormattedEndTimeAttribute(): string
    {
        return substr($this->end_time, 0, 5);
    }

    public function getDurationAttribute(): int
    {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        return ($end - $start) / 60;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getDayNameAttribute(): string
    {
        return $this->date->translatedFormat('l');
    }
}
