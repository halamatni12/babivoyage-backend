@extends('userside.app')

@section('title','BabiVoyage – Book Flights, Manage Trips')

@section('content')
  {{-- Announcement / offers --}}
  <div class="bg-primary-subtle py-2 border-bottom" data-aos="fade-down">
    <div class="container marquee">
      <div class="inner">
        <span class="me-4">Summer Deals: Up to 20% off on BEY → DXB</span>
        <span class="me-4">Free 10kg Cabin on select airlines</span>
        <span class="me-4">No hidden fees — Transparent prices</span>
        <span class="me-4">Optional Travel Insurance at checkout</span>
      </div>
    </div>
  </div>

  {{-- HERO with progressive background load --}}
  <section class="hero d-flex align-items-center"
           style="background:linear-gradient(180deg,#0b132b 0%, rgba(11,19,43,.6) 40%, rgba(11,19,43,.35) 100%);">
    <script>
      // Replace gradient with hero image after render (improves LCP without layout shift)
      (function(){
        const hero = document.currentScript.parentElement;
        const img = new Image();
        img.src = "{{ asset('images/image.png') }}";
        img.decoding = "async"; img.loading = "eager";
        img.onload = () => {
          hero.style.backgroundImage =
            "linear-gradient(180deg, rgba(2,12,33,.55), rgba(2,12,33,.35)), url('"+img.src+"')";
          hero.style.backgroundPosition = "center";
          hero.style.backgroundSize = "cover";
          hero.style.backgroundRepeat = "no-repeat";
        };
      })();
    </script>

    <div class="container py-5">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6 text-white" data-aos="fade-right">
          <span class="badge badge-soft mb-2">Trusted by frequent flyers</span>
          <h1 class="display-5 fw-bold">Book flights the smart way</h1>
          <p class="lead opacity-75 mb-4">
            Compare airlines, choose seats, add insurance, and manage every trip in one place.
          </p>
          <div class="d-flex flex-wrap gap-2">
            <span class="chip"><i class="bi bi-currency-exchange me-1"></i>Best fares</span>
            <span class="chip"><i class="bi bi-bag-check me-1"></i>Baggage options</span>
            <span class="chip"><i class="bi bi-people me-1"></i>Multi-passenger</span>
          </div>
        </div>

        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
          <div class="p-4 glass">
            <h5 class="fw-semibold mb-3">Search Flights</h5>

            {{-- GET to results stub; later wire to controller --}}
            <form method="GET" action="{{ route('flights.results') }}" class="row g-3">
              {{-- Trip Type --}}
              <div class="col-12" data-aos="fade-up" data-aos-delay="0">
                <div class="btn-group" role="group" aria-label="Trip type">
                  <input class="btn-check" type="radio" name="trip_type" id="round" value="round" checked>
                  <label class="btn btn-outline-primary" for="round">Round Trip</label>

                  <input class="btn-check" type="radio" name="trip_type" id="oneway" value="oneway">
                  <label class="btn btn-outline-primary" for="oneway">One Way</label>
                </div>
              </div>

              {{-- From / To (IATA) --}}
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="50">
                <label class="form-label">From</label>
                <input type="text" name="from" maxlength="3" class="form-control"
                       placeholder="BEY" style="text-transform:uppercase" required>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <label class="form-label">To</label>
                <input type="text" name="to" maxlength="3" class="form-control"
                       placeholder="DXB" style="text-transform:uppercase" required>
              </div>

              {{-- Dates --}}
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
                <label class="form-label">Departure</label>
                <input type="date" name="depart" class="form-control" required>
              </div>
              <div class="col-md-6" id="returnGroup" data-aos="fade-up" data-aos-delay="200">
                <label class="form-label">Return</label>
                <input type="date" name="return" class="form-control">
              </div>

              {{-- Pax / Cabin --}}
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="250">
                <label class="form-label">Passengers</label>
                <input type="number" name="pax" min="1" max="9" class="form-control" value="1" required>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <label class="form-label">Cabin</label>
                <select name="cabin" class="form-select">
                  <option value="economy">Economy</option>
                  <option value="business">Business</option>
                  <option value="first">First</option>
                </select>
              </div>

              <div class="col-12 d-grid" data-aos="fade-up" data-aos-delay="350">
                <button class="btn btn-primary btn-lg" type="submit">
                  <i class="bi bi-search me-1"></i> Search Flights
                </button>
              </div>
            </form>

            <script>
              // Hide return when One Way
              document.addEventListener('DOMContentLoaded', function () {
                const oneway = document.getElementById('oneway');
                const round  = document.getElementById('round');
                const retGrp = document.getElementById('returnGroup');
                function toggleReturn() {
                  if (oneway.checked) {
                    retGrp.style.display = 'none';
                    retGrp.querySelector('input').value = '';
                  } else retGrp.style.display = 'block';
                }
                oneway.addEventListener('change', toggleReturn);
                round.addEventListener('change', toggleReturn);
                toggleReturn();
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Brands (Airlines) --}}
  <section class="py-4">
    <div class="container brand-row d-flex flex-wrap justify-content-center align-items-center gap-4">
      <img data-aos="zoom-in" src="https://dummyimage.com/110x32/ddd/555&text=MEA" height="28" alt="MEA" loading="lazy" decoding="async">
      <img data-aos="zoom-in" data-aos-delay="50" src="https://dummyimage.com/110x32/ddd/555&text=Emirates" height="28" alt="Emirates" loading="lazy" decoding="async">
      <img data-aos="zoom-in" data-aos-delay="100" src="https://dummyimage.com/110x32/ddd/555&text=Qatar" height="28" alt="Qatar" loading="lazy" decoding="async">
      <img data-aos="zoom-in" data-aos-delay="150" src="https://dummyimage.com/110x32/ddd/555&text=Turkish" height="28" alt="Turkish" loading="lazy" decoding="async">
      <img data-aos="zoom-in" data-aos-delay="200" src="https://dummyimage.com/110x32/ddd/555&text=Air+France" height="28" alt="Air France" loading="lazy" decoding="async">
    </div>
  </section>
{{-- Featured Destinations --}}
<section id="destinations" class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-3" data-aos="fade-up">
      <h2 class="section-title mb-0">Featured Destinations</h2>
      <a href="{{ route('destinations.index') }}" class="link-primary text-decoration-none">See all</a>
    </div>

    <div class="row g-4">
      @foreach ($destinations as $i => $d)
        @php
          $flightId = \App\Models\Flight::where('departure_id', $defaultOriginId)
              ->where('arrival_id', $d->id)
              ->orderBy('departure_time')
              ->value('id');

          $href = $flightId
              ? route('flights.show', $flightId)
              : route('flight.results', ['from_id' => $defaultOriginId, 'to_id' => $d->id]);
        @endphp

        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
          <a href="{{ $href }}" class="card card-elevate overflow-hidden rounded-4 h-100 text-decoration-none">
            <img
              src="{{ asset('image.png') }}" {{-- نفس الصورة لكل المدن --}}
              alt="{{ $d->city }}"
              class="card-img-top"
              style="height:220px;object-fit:cover;">

            <div class="card-img-overlay d-flex flex-column justify-content-end p-2"
                 style="background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,.45) 100%);">
              <span class="text-white-50 small">{{ $d->code ?? '' }}</span>
              <strong class="text-white fs-6">{{ $d->city }}</strong>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>



  {{-- Why Choose Us --}}
  <section id="why" class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title mb-4" data-aos="fade-up">Why choose BabiVoyage?</h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-shield-check fs-3 text-primary me-2"></i>
              <h5 class="mb-0">Secure & Transparent</h5>
            </div>
            <p class="text-secondary mb-0">Clean pricing, secure checkout, and instant confirmations.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-clock-history fs-3 text-primary me-2"></i>
              <h5 class="mb-0">Real-time Availability</h5>
            </div>
            <p class="text-secondary mb-0">Up-to-date flight times, seats, and baggage options.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-headset fs-3 text-primary me-2"></i>
              <h5 class="mb-0">Human Support</h5>
            </div>
            <p class="text-secondary mb-0">We’re here to help with changes, refunds, and special requests.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- How it works --}}
  <section class="py-5">
    <div class="container">
      <h2 class="section-title mb-4" data-aos="fade-up">How it works</h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="flip-up">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <span class="badge bg-primary-subtle text-primary me-2">1</span>
              <h6 class="mb-0">Search & Compare</h6>
            </div>
            <p class="text-secondary mb-0">Enter your route, dates, and passengers to see the best options.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-up" data-aos-delay="100">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <span class="badge bg-primary-subtle text-primary me-2">2</span>
              <h6 class="mb-0">Customize</h6>
            </div>
            <p class="text-secondary mb-0">Pick seats, baggage, meals, and add travel insurance if you want.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-up" data-aos-delay="200">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <span class="badge bg-primary-subtle text-primary me-2">3</span>
              <h6 class="mb-0">Pay & Go</h6>
            </div>
            <p class="text-secondary mb-0">Pay securely and get your e-ticket instantly by email.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Testimonials --}}
  <section id="testimonials" class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title mb-4" data-aos="fade-up">What travelers say</h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-star-fill text-warning me-1"></i>
              <strong>4.9 / 5</strong>
            </div>
            <p class="mb-0">“Smooth booking, clear prices, and fast confirmation. Loved the baggage options.”</p>
            <small class="text-secondary mt-2">— Rami K.</small>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-star-fill text-warning me-1"></i>
              <strong>5 / 5</strong>
            </div>
            <p class="mb-0">“Had to change my flight — support was quick and helpful. Recommend!”</p>
            <small class="text-secondary mt-2">— Hala S.</small>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card card-elevate h-100 p-3">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-star-fill text-warning me-1"></i>
              <strong>4.8 / 5</strong>
            </div>
            <p class="mb-0">“Nice UI and the best BEY → DXB deals. E-ticket arrived instantly.”</p>
            <small class="text-secondary mt-2">— Nour A.</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="py-5">
    <div class="container" data-aos="zoom-in">
      <div class="rounded-4 p-4 p-md-5 text-center card-elevate" style="background: linear-gradient(135deg,#eef6ff,#ffffff)">
        <h3 class="fw-bold mb-2">Ready to take off?</h3>
        <p class="text-secondary mb-4">Join BabiVoyage and get exclusive member fares.</p>
        <a class="btn btn-primary btn-lg" href="/register">
          <i class="bi bi-person-plus me-1"></i> Create an account
        </a>
      </div>
    </div>
  </section>

  {{-- Contact --}}
  <section id="contact" class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title mb-3" data-aos="fade-up">Contact us</h2>
      <div class="row g-4">
        <div class="col-md-6" data-aos="fade-right">
          <div class="card card-elevate h-100 p-3">
            <h6 class="fw-semibold">Support</h6>
            <p class="text-secondary mb-2">Email: support@babivoyage.com</p>
            <p class="text-secondary mb-0">Phone: +961 1 234 567</p>
          </div>
        </div>
        <div class="col-md-6" data-aos="fade-left">
          <form class="card card-elevate p-3">
            <div class="row g-3">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="50">
                <label class="form-label">Name</label>
                <input class="form-control" type="text" placeholder="Your name">
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" placeholder="you@example.com">
              </div>
              <div class="col-12" data-aos="fade-up" data-aos-delay="150">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="3" placeholder="How can we help?"></textarea>
              </div>
              <div class="col-12 d-grid" data-aos="fade-up" data-aos-delay="200">
                <button class="btn btn-primary" type="button">Send</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
