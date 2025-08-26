@extends('userside.app')
@section('title','My Bookings')

@section('content')
<div class="container py-4">
  <h3 class="mb-3">My Bookings</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Flight</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @forelse($bookings as $booking)
        <tr>
          <td>{{ $booking->id }}</td>
          <td>{{ $booking->flight->from->city }} → {{ $booking->flight->to->city }}</td>
          <td>{{ $booking->booking_date }}</td>
          <td>
            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
              {{ ucfirst($booking->status) }}
            </span>
          </td>
          <td>${{ number_format($booking->total_amount,2) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5">No bookings yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
