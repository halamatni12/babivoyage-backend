@extends('userside.app')

@section('title', 'Flight Details')

@section('content')
<div class="container py-5">
  <a href="{{ url()->previous() }}" class="btn btn-link mb-3">← Back</a>

  <div class="card card-elevate p-4">
    <h3 class="mb-2">{{ $flight->airline->name }} — {{ $flight->flight_number }}</h3>
    <div class="text-secondary mb-2">
      {{ $flight->departure->city }} → {{ $flight->arrival->city }}
    </div>

    <ul class="list-unstyled mb-3">
      <li>🛫 Departure: <strong>{{ $flight->departure_time->format('Y-m-d H:i') }}</strong></li>
      <li>🛬 Arrival: <strong>{{ $flight->arrival_time->format('Y-m-d H:i') }}</strong></li>
      <li>💺 Class: <span class="badge bg-light text-dark">{{ ucfirst($flight->class) }}</span></li>
      <li>💲 Price: <strong>${{ number_format($flight->base_price, 2) }}</strong></li>
    </ul>

    <a href="{{ route('bookings.create', $flight->id) }}" class="btn btn-primary">Book Now</a>
  </div>
</div>
@endsection
