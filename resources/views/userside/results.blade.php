@extends('userside.app')
@section('title','Flights Results – BabiVoyage')

@section('content')
<div class="container py-5">
  <h3 class="fw-semibold mb-3">Flights from {{ $query['from'] }} to {{ $query['to'] }}</h3>

  @if($flights->isEmpty())
    <div class="alert alert-warning">No flights found for your search.</div>
  @else
    <div class="row g-3">
      @foreach($flights as $f)
        <div class="col-md-6">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">{{ $f->airline->name }} ({{ $f->flight_number }})</h5>
              <p class="mb-1">
                <strong>{{ $f->from->city }} → {{ $f->to->city }}</strong><br>
                {{ $f->departure_time->format('d M H:i') }} –
                {{ $f->arrival_time->format('d M H:i') }}
              </p>
              <p class="mb-1"><strong>Class:</strong> {{ ucfirst($f->class) }}</p>
              <p class="mb-1"><strong>Price:</strong> ${{ number_format($f->base_price,2) }}</p>
            </div>
   <div class="card-footer d-grid">
  <a class="btn btn-primary"
     href="{{ route('bookings.create', $f) }}?pax={{ request('pax',1) }}&cabin={{ request('cabin','economy') }}">
    Book Now
  </a>
</div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
