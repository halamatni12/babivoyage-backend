@extends('userside.app')
@section('title','Book Flight – BabiVoyage')

@section('content')
<div class="container py-4">
  <div class="card card-elevate p-3">
    <h5 class="mb-3">
      {{ $flight->airline->name }} ({{ $flight->flight_number }})
      — {{ $flight->from->city }} → {{ $flight->to->city }}
    </h5>

    <div class="row g-4">
      <div class="col-md-8">
        {{-- Main Booking Form --}}
        <form method="POST" action="{{ route('bookings.store', $flight) }}">
          @csrf

          {{-- Passengers --}}
          <div class="mb-3">
            <label class="form-label">Passengers</label>
            <input type="number" name="pax" id="pax" min="1" max="9"
                   class="form-control"
                   value="{{ old('pax', (int) request()->query('pax', $pax ?? 1)) }}">
            @error('pax') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Cabin --}}
          <div class="mb-3">
            <label class="form-label">Cabin</label>
            @php $currCabin = old('cabin', request()->query('cabin', $cabin ?? 'economy')); @endphp
            <select name="cabin" id="cabin" class="form-select">
              <option value="economy" {{ $currCabin==='economy'?'selected':'' }}>Economy</option>
              <option value="business" {{ $currCabin==='business'?'selected':'' }}>Business</option>
              <option value="first"    {{ $currCabin==='first'?'selected':'' }}>First</option>
            </select>
            @error('cabin') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Seat number --}}
          <div class="mb-3">
            <label class="form-label">Seat (optional)</label>
            <input type="text" name="seat_number" class="form-control"
                   placeholder="e.g. 12A"
                   pattern="^[0-9]{1,2}[A-F]$"
                   value="{{ old('seat_number') }}">
            @error('seat_number') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Insurance --}}
          <div class="form-check mb-3">
            @php $ins = old('insurance', request()->boolean('insurance', false)); @endphp
            <input class="form-check-input" type="checkbox" id="insurance" name="insurance" value="1" {{ $ins ? 'checked' : '' }}>
            <label class="form-check-label" for="insurance">Add travel insurance</label>
          </div>

          {{-- Submit --}}
          <button type="submit" class="btn btn-primary"
                  onclick="this.disabled=true; this.form.submit();">
            Confirm Booking
          </button>
          <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
      </div>

      <div class="col-md-4">
        {{-- Live price preview --}}
        <div class="border rounded p-3 bg-light">
          <div><strong>Passengers:</strong> <span id="paxOut"></span></div>
          <div><strong>Cabin:</strong> <span id="cabinOut"></span></div>
          <div><strong>Estimated total:</strong> $<span id="totalOut">0.00</span></div>
          <div><strong>Insurance:</strong> <span id="insOut"></span></div>
          <small class="text-secondary d-block mt-2">Base fare: ${{ number_format($flight->base_price,2) }}</small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (function(){
    const base  = {{ (float) $flight->base_price }};
    const paxEl = document.getElementById('pax');
    const cabEl = document.getElementById('cabin');
    const insEl = document.getElementById('insurance');

    const paxOut = document.getElementById('paxOut');
    const cabOut = document.getElementById('cabinOut');
    const insOut = document.getElementById('insOut');
    const totalOut = document.getElementById('totalOut');

    const multipliers = { economy: 1.00, business: 1.80, first: 2.50 };
    const insurancePerPax = 12.00;

    function fmt(n){ return n.toFixed(2); }
    function up(){
      const pax = Math.min(Math.max(parseInt(paxEl.value||'1',10),1),9);
      const cab = cabEl.value;
      const ins = insEl.checked;

      const subtotal = base * (multipliers[cab] || 1.00) * pax;
      const insurance = ins ? insurancePerPax * pax : 0;
      const total = subtotal + insurance;

      paxOut.textContent = pax;
      cabOut.textContent = cab.charAt(0).toUpperCase() + cab.slice(1);
      insOut.textContent = ins ? 'Yes' : 'No';
      totalOut.textContent = fmt(total);
    }
    [paxEl, cabEl, insEl].forEach(el => el.addEventListener('input', up));
    up();
  })();
</script>
@endpush
