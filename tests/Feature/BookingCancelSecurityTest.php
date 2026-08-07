<?php

use App\Mail\BookingPin;
use App\Models\Booking;
use App\Models\BookingAccessToken;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

function makeRoom(): Room
{
    return Room::create([
        'name' => 'Lab Komputer 1',
        'code' => 'LAB-1',
        'location' => 'Gedung A',
        'capacity' => 30,
        'is_active' => true,
    ]);
}

function makeBooking(Room $room, string $email, string $status = 'pending'): Booking
{
    return Booking::create([
        'room_id' => $room->id,
        'booker_name' => 'Test User',
        'booker_email' => $email,
        'booker_phone' => '081234567890',
        'jurusan' => 'Teknik Informatika',
        'prodi_id' => null,
        'purpose' => 'Kuliah',
        'mata_kuliah' => 'Pemrograman',
        'semester' => 2,
        'kelas' => 'A',
        'dosen' => 'Dosen A',
        'date' => now()->addDay()->format('Y-m-d'),
        'start_time' => '08:00',
        'end_time' => '10:00',
        'status' => $status,
    ]);
}

function sendPinAndGetCode(string $email): string
{
    Mail::fake();
    test()->post(route('bookings.verify.send'), ['email' => $email])->assertRedirect(route('bookings.my'));

    $pin = null;
    Mail::assertSent(BookingPin::class, function ($mail) use ($email, &$pin) {
        $pin = $mail->pin;

        return $mail->email === $email;
    });

    return $pin;
}

test('cancel tanpa verifikasi email ditolak', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $this->post(route('bookings.cancel', $booking))
        ->assertForbidden();

    $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'pending']);
});

test('cancel dengan email terverifikasi milik orang lain ditolak', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $this->withSession([
        'booking_verified_email' => 'penyerang@example.com',
        'booking_verified_at' => now(),
    ])->post(route('bookings.cancel', $booking))
        ->assertForbidden();

    $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'pending']);
});

test('cancel-recurrence tanpa verifikasi email ditolak', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $this->post(route('bookings.cancel-recurrence', $booking))
        ->assertForbidden();
});

test('halaman booking saya tidak menampilkan booking tanpa verifikasi', function () {
    $room = makeRoom();
    makeBooking($room, 'korban@example.com');

    $this->get(route('bookings.my'))
        ->assertOk()
        ->assertDontSee('LAB-1')
        ->assertDontSee('Batalkan');
});

test('alur verifikasi PIN yang benar dapat membatalkan booking', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $pin = sendPinAndGetCode('korban@example.com');

    $this->post(route('bookings.verify.pin'), [
        'email' => 'korban@example.com',
        'pin' => $pin,
    ])->assertRedirect(route('bookings.my'));

    $this->post(route('bookings.cancel', $booking))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'cancelled']);
});

test('kode verifikasi hanya bisa dipakai sekali', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $pin = sendPinAndGetCode('korban@example.com');

    $this->post(route('bookings.verify.pin'), [
        'email' => 'korban@example.com',
        'pin' => $pin,
    ])->assertRedirect(route('bookings.my'));

    $this->post(route('bookings.verify.pin'), [
        'email' => 'korban@example.com',
        'pin' => $pin,
    ])->assertSessionHasErrors('pin');

    $record = BookingAccessToken::where('email', 'korban@example.com')->first();
    $this->assertNotNull($record->used_at);
});

test('kode salah lima kali membuat kode nonaktif', function () {
    $room = makeRoom();
    $booking = makeBooking($room, 'korban@example.com');

    $pin = sendPinAndGetCode('korban@example.com');
    $wrongPin = $pin === '123456' ? '654321' : '123456';

    for ($i = 0; $i < 5; $i++) {
        $this->post(route('bookings.verify.pin'), [
            'email' => 'korban@example.com',
            'pin' => $wrongPin,
        ])->assertSessionHasErrors('pin');
    }

    $this->post(route('bookings.verify.pin'), [
        'email' => 'korban@example.com',
        'pin' => $pin,
    ])->assertSessionHasErrors('pin');

    $this->assertDatabaseMissing('booking_access_tokens', ['email' => 'korban@example.com']);
    $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'pending']);
});

test('email yang tidak terdaftar tidak mengirim PIN dan tidak membocorkan info', function () {
    Mail::fake();

    $this->post(route('bookings.verify.send'), ['email' => 'tidak-ada@example.com'])
        ->assertRedirect(route('bookings.my'))
        ->assertSessionHas('success');

    Mail::assertNotSent(BookingPin::class);
    $this->assertDatabaseMissing('booking_access_tokens', ['email' => 'tidak-ada@example.com']);
});
