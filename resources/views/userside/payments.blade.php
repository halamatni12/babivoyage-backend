@extends('userside.app')
@section('title','Payment – BabiVoyage')

@section('content')
<div class="container py-5" style="max-width: 560px;">
  <div class="card p-4">
    <h4 class="mb-3">Complete Payment</h4>
    <p>Booking for flight <strong>{{ $booking->flight->flight_number }}</strong></p>
<p>Total amount: <strong>${{ number_format($booking->total_amount, 2) }}</strong></p>

    <form method="POST" action="{{ route('payments.store',$booking->id) }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select name="method" class="form-select" required>
          <option value="credit_card">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="bank_transfer">Bank Transfer</option>
          <option value="cash">Cash</option>
        </select>
      </div>

      <button class="btn btn-primary w-100">Pay Now</button>
    </form>
  </div>
</div>
@endsection
