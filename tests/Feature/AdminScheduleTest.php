<?php

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeAdminUser(): User
{
    return User::create([
        'name' => 'Admin Lab',
        'email' => 'admin@lab.test',
        'password' => 'password',
        'role' => 'admin',
    ]);
}

function makeActiveRoomForSchedule(): Room
{
    return Room::create([
        'name' => 'Lab Komputer 1',
        'code' => 'LAB-1',
        'location' => 'Gedung A',
        'capacity' => 30,
        'is_active' => true,
    ]);
}

function makeScheduledBooking(Room $room, string $date, string $status): Booking
{
    return Booking::create([
        'room_id' => $room->id,
        'booker_name' => 'Test User',
        'booker_email' => 'test@example.com',
        'booker_phone' => '081234567890',
        'jurusan' => 'Teknik Informatika',
        'prodi_id' => null,
        'purpose' => 'Kuliah ' . $status,
        'mata_kuliah' => 'Pemrograman',
        'semester' => 2,
        'kelas' => 'A',
        'dosen' => 'Dosen A',
        'date' => $date,
        'start_time' => '08:00',
        'end_time' => '10:00',
        'status' => $status,
    ]);
}

function makeRecurringSeries(Room $room, array $dates, string $status = 'pending'): array
{
    $recurrenceId = (string) Str::uuid();

    return collect($dates)->map(function (string $date) use ($room, $status, $recurrenceId) {
        return Booking::create([
            'room_id' => $room->id,
            'booker_name' => 'Test User',
            'booker_email' => 'test@example.com',
            'booker_phone' => '081234567890',
            'jurusan' => 'Teknik Informatika',
            'prodi_id' => null,
            'purpose' => 'Kuliah Berulang',
            'mata_kuliah' => 'Pemrograman',
            'semester' => 2,
            'kelas' => 'A',
            'dosen' => 'Dosen A',
            'date' => $date,
            'start_time' => '08:00',
            'end_time' => '10:00',
            'status' => $status,
            'is_recurring' => true,
            'recurrence_id' => $recurrenceId,
        ]);
    })->all();
}

test('halaman jadwal admin membutuhkan login', function () {
    $this->get(route('admin.schedule'))->assertRedirect(route('admin.login'));
});

test('halaman jadwal admin (card) menampilkan daftar ruangan aktif', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();

    $this->actingAs($admin)
        ->get(route('admin.schedule'))
        ->assertOk()
        ->assertSee('Lab Komputer 1')
        ->assertSee('Lihat Jadwal');
});

test('halaman detail jadwal per ruangan menampilkan booking approved dan pending', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $date = now()->startOfWeek(\Illuminate\Support\Carbon::MONDAY)->format('Y-m-d');

    makeScheduledBooking($room, $date, 'approved');
    makeScheduledBooking($room, $date, 'pending');
    makeScheduledBooking($room, $date, 'rejected');

    $this->actingAs($admin)
        ->get(route('admin.schedule.room', $room, ['date' => $date]))
        ->assertOk()
        ->assertSee('Lab Komputer 1')
        ->assertSee('Kuliah approved')
        ->assertSee('Kuliah pending')
        ->assertDontSee('Kuliah rejected');
});

test('admin dapat menghapus permanen booking yang sudah disetujui', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'approved');

    $this->actingAs($admin)
        ->delete(route('admin.bookings.force-destroy', $booking))
        ->assertRedirect(route('admin.bookings.index'));

    $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
});

test('update jadwal tidak gagal ketika pengiriman email error', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'approved');

    \Illuminate\Support\Facades\Mail::shouldReceive('to')->andReturnSelf();
    \Illuminate\Support\Facades\Mail::shouldReceive('send')
        ->andThrow(new \Symfony\Component\Mailer\Exception\TransportException('SMTP timeout'));

    $this->actingAs($admin)
        ->put(route('admin.bookings.update', $booking), [
            'room_id' => $room->id,
            'booker_name' => 'Test User',
            'booker_email' => 'test@example.com',
            'booker_phone' => '081234567890',
            'jurusan' => 'Teknik Informatika',
            'prodi_id' => null,
            'purpose' => 'Kuliah',
            'mata_kuliah' => 'Pemrograman',
            'semester' => 2,
            'kelas' => 'A',
            'dosen' => 'Dosen A',
            'date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '13:00',
        ])
        ->assertRedirect(route('admin.bookings.show', $booking))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'start_time' => '12:00',
        'end_time' => '13:00',
    ]);
    $this->assertSame(now()->addDays(2)->format('Y-m-d'), $booking->fresh()->date->format('Y-m-d'));
});

test('admin dapat mengedit seluruh data peminjam dan akademik', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'pending');

    $this->actingAs($admin)
        ->put(route('admin.bookings.update', $booking), [
            'room_id' => $room->id,
            'booker_name' => 'Nama Baru',
            'booker_email' => 'baru@example.com',
            'booker_phone' => '089999999999',
            'jurusan' => 'Teknologi Informasi',
            'prodi_id' => null,
            'purpose' => 'Praktikum',
            'mata_kuliah' => 'Basis Data',
            'semester' => 4,
            'kelas' => 'C',
            'dosen' => 'Dosen Baru',
            'teknisi' => 'Teknisi X',
            'notes' => 'Catatan baru',
            'date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '10:00',
        ])
        ->assertRedirect(route('admin.bookings.show', $booking))
        ->assertSessionHas('success');

    $fresh = $booking->fresh();
    $this->assertSame('Nama Baru', $fresh->booker_name);
    $this->assertSame('baru@example.com', $fresh->booker_email);
    $this->assertSame('089999999999', $fresh->booker_phone);
    $this->assertSame('Teknologi Informasi', $fresh->jurusan);
    $this->assertSame('Praktikum', $fresh->purpose);
    $this->assertSame('Basis Data', $fresh->mata_kuliah);
    $this->assertSame(4, $fresh->semester);
    $this->assertSame('C', $fresh->kelas);
    $this->assertSame('Dosen Baru', $fresh->dosen);
    $this->assertSame('Teknisi X', $fresh->teknisi);
    $this->assertSame('Catatan baru', $fresh->notes);
});

test('edit booking gagal validasi ketika data peminjam tidak lengkap', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'pending');

    $this->actingAs($admin)
        ->put(route('admin.bookings.update', $booking), [
            'room_id' => $room->id,
            'booker_name' => '',
            'booker_email' => 'bukan-email',
            'booker_phone' => '',
            'purpose' => '',
            'date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '10:00',
        ])
        ->assertSessionHasErrors(['booker_name', 'booker_email', 'booker_phone', 'jurusan', 'purpose']);

    $this->assertSame('pending', $booking->fresh()->status);
});

test('approve satu jadwal berulang menyetujui seluruh seri sekaligus', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();

    $dates = [
        now()->format('Y-m-d'),
        now()->addWeek()->format('Y-m-d'),
        now()->addWeeks(2)->format('Y-m-d'),
    ];

    $series = makeRecurringSeries($room, $dates);
    $this->assertNotNull($series[0]->recurrence_id);
    $this->assertSame($series[0]->recurrence_id, $series[2]->recurrence_id);

    $this->actingAs($admin)
        ->post(route('admin.bookings.approve', $series[0]))
        ->assertSessionHas('success');

    foreach ($series as $booking) {
        $this->assertSame('approved', $booking->fresh()->status);
    }
});

test('konflik pada satu tanggal memblokir persetujuan seluruh seri', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();

    $series = makeRecurringSeries($room, [
        now()->format('Y-m-d'),
        now()->addWeek()->format('Y-m-d'),
    ]);

    makeScheduledBooking($room, now()->addWeek()->format('Y-m-d'), 'approved');

    $this->actingAs($admin)
        ->post(route('admin.bookings.approve', $series[0]))
        ->assertSessionHasErrors('error');

    foreach ($series as $booking) {
        $this->assertSame('pending', $booking->fresh()->status);
    }
});

test('tolak satu jadwal berulang menolak seluruh seri sekaligus', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();

    $series = makeRecurringSeries($room, [
        now()->format('Y-m-d'),
        now()->addWeek()->format('Y-m-d'),
        now()->addWeeks(2)->format('Y-m-d'),
    ]);

    $this->actingAs($admin)
        ->post(route('admin.bookings.reject', $series[0]), ['rejection_reason' => 'Jadwal bentrok'])
        ->assertSessionHas('success');

    foreach ($series as $booking) {
        $this->assertSame('rejected', $booking->fresh()->status);
        $this->assertSame('Jadwal bentrok', $booking->fresh()->rejection_reason);
    }
});

test('menolak booking tanpa alasan gagal validasi', function () {
    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'pending');

    $this->actingAs($admin)
        ->post(route('admin.bookings.reject', $booking), [])
        ->assertSessionHasErrors('rejection_reason');

    $this->assertSame('pending', $booking->fresh()->status);
});

test('menolak booking dengan alasan menyimpan reason dan mengirim email', function () {
    \Illuminate\Support\Facades\Mail::fake();

    $admin = makeAdminUser();
    $room = makeActiveRoomForSchedule();
    $booking = makeScheduledBooking($room, now()->addDay()->format('Y-m-d'), 'pending');

    $this->actingAs($admin)
        ->post(route('admin.bookings.reject', $booking), ['rejection_reason' => 'Ruangan sudah dipakai'])
        ->assertSessionHas('success');

    $this->assertSame('rejected', $booking->fresh()->status);
    $this->assertSame('Ruangan sudah dipakai', $booking->fresh()->rejection_reason);

    \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\BookingStatusChanged::class, function ($mail) use ($booking) {
        return $mail->booking->is($booking)
            && $mail->booking->status === 'rejected'
            && $mail->rejectionReason === 'Ruangan sudah dipakai';
    });
});
