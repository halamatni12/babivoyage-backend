@extends('userside.app')

@section('title','All Destinations')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">All Destinations</h2>

  <div class="row g-4">
    @foreach($destinations as $d)
      <div class="col-12 col-md-6 col-lg-4">
        <a href="{{ route('flight.results', ['from_id' => 1, 'to_id' => $d->id]) }}"
           class="card card-elevate h-100 text-decoration-none">
          <div class="card-body text-center">
            <h5 class="mb-1">{{ $d->city }}</h5>
            <p class="text-secondary mb-0">{{ $d->code }}</p>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <div class="mt-4">
    {{ $destinations->links() }}
  </div>
</div>
@endsection
