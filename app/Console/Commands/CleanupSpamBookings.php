<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CleanupSpamBookings extends Command
{
    protected $signature = 'bookings:cleanup-spam {--days=7 : Hapus booking pending yang lebih dari N hari}';

    protected $description = 'Hapus booking pending yang menumpuk (kemungkinan spam)';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $deleted = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Berhasil menghapus {$deleted} booking pending yang lebih dari {$days} hari.");

        return Command::SUCCESS;
    }
}
