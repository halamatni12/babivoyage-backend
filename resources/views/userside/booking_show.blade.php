@extends('userside.app')
@section('title','Booking Confirmation – BabiVoyage')

@section('content')
<div class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card card-elevate p-3">
    <h5 class="mb-3">Booking #{{ $booking->id }} — {{ ucfirst($booking->status) }}</h5>

    <div class="row g-3">
      <div class="col-md-6">
        <h6 class="text-secondary">Flight</h6>
        <div><strong>{{ $booking->flight->airline->name }} ({{ $booking->flight->flight_number }})</strong></div>
        <div>{{ $booking->flight->from->city }} → {{ $booking->flight->to->city }}</div>
        <div>
          {{ $booking->flight->departure_time->format('D d M H:i') }}
          –
          {{ $booking->flight->arrival_time->format('D d M H:i') }}
        </div>
      </div>

      <div class="col-md-6">
        <h6 class="text-secondary">Details</h6>
        <div>Booked at: {{ $booking->booking_date->format('Y-m-d H:i') }}</div>
        <div>Seat: {{ $booking->seat_number ?? '—' }}</div>
        <div>Total: <strong>${{ number_format($booking->total_amount,2) }}</strong></div>
        @if(!empty($meta))
          <div>Passengers: {{ $meta['pax'] ?? 1 }}</div>
          <div>Cabin: {{ ucfirst($meta['cabin'] ?? 'economy') }}</div>
          <div>Insurance: {{ !empty($meta['insurance']) ? 'Yes' : 'No' }}</div>
        @endif
      </div>
    </div>

    <hr>
    <div class="d-flex gap-2">
      {{-- Stub for next step: mark confirmed (in real life: payment) --}}
      @if($booking->status === 'pending')
        <form method="POST" action="{{ route('bookings.confirm', $booking) }}">
          @csrf
          <button class="btn btn-primary">Mark as Confirmed</button>
        </form>
      @endif
      <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Home</a>
    </div>
  </div>
</div>
@endsection
