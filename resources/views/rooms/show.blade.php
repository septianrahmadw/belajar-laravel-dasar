@extends('layouts.app')

@section('title', $room->name)

@section('content')
<div id="room-show-app"
     data-props="{{ json_encode([
         'room' => [
             'id' => $room->id,
             'code' => $room->code,
             'name' => $room->name,
             'location' => $room->location,
             'capacity' => $room->capacity,
             'description' => $room->description,
             'facilities' => $room->facilities,
         ],
         'currentDate' => $date,
         'monthBookings' => $monthBookings,
         'prodis' => $prodis->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'jurusan' => $p->jurusan]),
         'initialBookings' => $bookings->map(fn($b) => [
             'id' => $b->id,
             'start_time' => $b->start_time,
             'end_time' => $b->end_time,
             'purpose' => $b->purpose,
             'booker_name' => $b->booker_name,
             'status' => $b->status,
         ]),
     ]) }}">
</div>
@endsection
