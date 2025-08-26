<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','BabiVoyage – Travel Smarter')</title>

  {{-- Google Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- AOS for animations --}}
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    :root{
      --brand:#0d6efd;
      --brand-600:#0b66c3;
      --brand-700:#084298;
      --ink:#0f172a;
      --ink-2:#334155;
      --bg-soft:#f8fafc;
      --card-shadow:0 12px 30px rgba(0,0,0,.06);
      --ring:#dbe9ff;
    }
    *{scroll-behavior:smooth}
    body{
      font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
      color:var(--ink);
      background:#fff;
    }
    .navbar{transition:box-shadow .25s ease, backdrop-filter .25s ease}
    .navbar.nav-scrolled{
      box-shadow:0 8px 24px rgba(15,23,42,.06);
      backdrop-filter:saturate(1.1) blur(6px);
    }
    .badge-soft{background:#f1f6ff;color:var(--brand);border:1px solid var(--ring)}
    .chip{background:#eef6ff;color:var(--brand-600);border:1px solid var(--ring);border-radius:999px;padding:.35rem .75rem;font-size:.85rem;display:inline-flex;gap:.4rem;align-items:center}
    .glass{background:rgba(255,255,255,.92);border:1px solid #e0e7ff;border-radius:1rem;box-shadow:0 20px 50px rgba(0,0,0,.12);backdrop-filter:blur(6px)}
    .brand-row img{filter:saturate(0) opacity(.7);transition:.3s}
    .brand-row img:hover{filter:saturate(1) opacity(1)}
    .section-title{font-weight:800;letter-spacing:-.02em}
    .card-elevate{border:0;box-shadow:var(--card-shadow);border-radius:1rem}
    .hero{position:relative;min-height:74vh;color:#fff}
    .btn{border-radius:.7rem;font-weight:600;transition:all .25s ease}
    .btn-primary{background:var(--brand);border-color:var(--brand)}
    .btn-primary:hover{background:var(--brand-700);transform:translateY(-2px);box-shadow:0 8px 20px rgba(13,110,253,.25)}
    .btn-outline-primary:hover{background:var(--brand);color:#fff}

    /* marquee */
    .marquee{overflow:hidden;white-space:nowrap;position:relative;mask:linear-gradient(90deg,transparent,#000 10%,#000 90%,transparent)}
    .marquee .inner{display:inline-block;padding-left:100%;animation:scroll 18s linear infinite}
    @keyframes scroll{from{transform:translateX(0)}to{transform:translateX(-100%)}}

    /* utilities */
    .shadow-soft{box-shadow:0 16px 40px rgba(2,8,23,.08)}
    .rounded-4{border-radius:1rem!important}
    .text-secondary{color:var(--ink-2)!important}

    /* prefers-reduced-motion: disable fancy hovers */
    @media (prefers-reduced-motion: reduce){
      .btn,.brand-row img{transition:none}
      .marquee .inner{animation:none}
    }
  </style>

  @stack('head')
</head>
<body>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('home') }}">
        <i class="bi bi-airplane-fill me-2"></i><span>BabiVoyage</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="#destinations">Destinations</a></li>
          <li class="nav-item"><a class="nav-link" href="#why">Why Us</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">My Trips</a></li>
          @endauth
        </ul>
        <div class="d-flex gap-2">
          @guest
            <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
            <a class="btn btn-primary" href="{{ route('register') }}">Sign Up</a>
          @else
            <form action="{{ route('logout') }}" method="POST">@csrf
              <button class="btn btn-outline-danger">Logout</button>
            </form>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <main>@yield('content')</main>

  {{-- Footer --}}
  <footer class="border-top mt-5">
    <div class="container py-4 small text-muted d-flex flex-wrap gap-3 justify-content-between">
      <span>© {{ date('Y') }} BabiVoyage — All rights reserved.</span>
      <div class="d-flex gap-3">
        <a href="#" class="link-secondary text-decoration-none">Terms</a>
        <a href="#" class="link-secondary text-decoration-none">Privacy</a>
        <a href="#contact" class="link-secondary text-decoration-none">Contact</a>
      </div>
    </div>
  </footer>

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js" defer></script>
  <script>
    // Wait for AOS to be available (defer)
    window.addEventListener('load', function(){
      // Navbar shadow on scroll
      document.addEventListener('scroll', () => {
        const nav = document.querySelector('.navbar');
        nav.classList.toggle('nav-scrolled', window.scrollY > 8);
      });

      // Respect reduced motion
      const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      AOS.init({
        disable: prefersReduced,
        duration: 700,
        offset: 80,
        easing: 'ease-out-cubic',
        once: true,
        anchorPlacement: 'top-bottom'
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
