<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('notes');
            $table->string('recurrence_id')->nullable()->after('is_recurring');
            $table->date('recurrence_end_date')->nullable()->after('recurrence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurrence_id', 'recurrence_end_date']);
        });
    }
};
