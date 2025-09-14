@extends('userside.app')

@section('title','Flight Results')

@section('content')
<div class="container py-5">
  <h3 class="mb-4">Available Flights</h3>

  @if(isset($origin) || isset($destination))
    <p class="text-secondary">
      @if($origin) From: <strong>{{ $origin->city }}</strong> @endif
      @if($destination) → To: <strong>{{ $destination->city }}</strong> @endif
    </p>
  @endif

  @forelse($flights as $flight)
    <div class="card card-elevate p-3 mb-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-1">{{ $flight->airline->name }} — {{ $flight->flight_number }}</h6>
          <div class="text-secondary small">
            {{ $flight->departure->city }} ({{ $flight->departure_time->format('Y-m-d H:i') }})
            →
            {{ $flight->arrival->city }} ({{ $flight->arrival_time->format('Y-m-d H:i') }})
          </div>
        </div>
        <div class="text-end">
          <div class="fw-semibold mb-2">${{ number_format($flight->base_price, 2) }}</div>
          <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">No flights found for this route.</div>
  @endforelse

  <div class="mt-3">
    {{ $flights->links() }}
  </div>
</div>
@endsection
