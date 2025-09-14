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

      {{-- Payment Method --}}
      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select id="payment-method" name="method" class="form-select" required>
          <option value="">Select...</option>
          <option value="credit_card">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="bank_transfer">Bank Transfer</option>
          <option value="cash">Cash</option>
        </select>
      </div>

      {{-- Dynamic fields --}}
      <div id="payment-fields"></div>

      <button class="btn btn-primary w-100">Pay Now</button>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const select = document.getElementById('payment-method');
  const fields = document.getElementById('payment-fields');

  select.addEventListener('change', function () {
    let html = '';
    if (this.value === 'credit_card') {
      html = `
        <div class="mb-3">
          <label class="form-label">Card Number</label>
          <input type="text" name="card_number" class="form-control" maxlength="16" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Expiry Date</label>
          <input type="month" name="expiry" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">CVV</label>
          <input type="text" name="cvv" class="form-control" maxlength="4" required>
        </div>`;
    }
    else if (this.value === 'paypal') {
      html = `
        <div class="mb-3">
          <label class="form-label">PayPal Email</label>
          <input type="email" name="paypal_email" class="form-control" required>
        </div>`;
    }
    else if (this.value === 'bank_transfer') {
      html = `
        <div class="mb-3">
          <label class="form-label">Account Number / IBAN</label>
          <input type="text" name="iban" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Bank Name</label>
          <input type="text" name="bank_name" class="form-control" required>
        </div>`;
    }
    else if (this.value === 'cash') {
      html = `<p class="text-muted">You will pay in cash at the airport counter.</p>`;
    }
    fields.innerHTML = html;
  });
});
</script>
@endsection
