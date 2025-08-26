@extends('userside.app')
@section('title','Register – BabiVoyage')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">
      <div class="text-center mb-4" data-aos="fade-down">
        <h2 class="fw-bold mb-1">Create your account</h2>
        <p class="text-secondary mb-0">Book flights, track prices, and manage trips in one place</p>
      </div>

      <div class="card card-elevate p-4 p-md-5" data-aos="fade-up">
        @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            <strong>Please fix the following:</strong>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" novalidate>
          @csrf

          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text"
                     name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name') }}"
                     autocomplete="name"
                     required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email"
                     name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}"
                     autocomplete="email"
                     required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password"
                     name="password"
                     class="form-control @error('password') is-invalid @enderror"
                     id="regPassword"
                     autocomplete="new-password"
                     required>
              <button class="btn btn-outline-secondary" type="button" id="toggleRegPw" tabindex="-1">
                <i class="bi bi-eye"></i>
              </button>
              @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <small id="pwHint" class="text-secondary d-block mt-1">
              Use 8+ chars with a mix of letters & numbers.
            </small>
            <div class="progress mt-2" style="height:6px;">
              <div id="pwBar" class="progress-bar" role="progressbar" style="width:0%"></div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
              <input type="password"
                     name="password_confirmation"
                     class="form-control"
                     id="regPassword2"
                     autocomplete="new-password"
                     required>
            </div>
            <small id="matchHint" class="text-secondary d-block mt-1"></small>
          </div>

    <button class="btn btn-primary w-100">
  <i class="bi bi-person-plus me-1"></i> Register
</button>

          <p class="text-center mt-3 mb-0">
            Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Toggle show/hide password (Register)
  (function(){
    const btn = document.getElementById('toggleRegPw');
    const pw  = document.getElementById('regPassword');
    if (btn && pw){
      btn.addEventListener('click', function(){
        const isPwd = pw.getAttribute('type') === 'password';
        pw.setAttribute('type', isPwd ? 'text' : 'password');
        this.innerHTML = isPwd ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
      });
    }
  })();

  // Simple password strength + match indicator (client-side hint only)
  (function(){
    const pw   = document.getElementById('regPassword');
    const pw2  = document.getElementById('regPassword2');
    const bar  = document.getElementById('pwBar');
    const hint = document.getElementById('matchHint');
    if (!pw || !pw2 || !bar) return;

    function strength(s){
      let score = 0;
      if (s.length >= 8) score += 1;
      if (/[A-Z]/.test(s)) score += 1;
      if (/[a-z]/.test(s)) score += 1;
      if (/\d/.test(s)) score += 1;
      if (/[^A-Za-z0-9]/.test(s)) score += 1;
      return score; // 0..5
    }
    function update(){
      const v = pw.value || '';
      const sc = strength(v);
      const pct = (sc/5)*100;
      bar.style.width = pct + '%';
      bar.className = 'progress-bar';
      if (sc <= 2) bar.classList.add('bg-danger');
      else if (sc === 3) bar.classList.add('bg-warning');
      else bar.classList.add('bg-success');

      // match indicator
      if (pw2.value.length){
        hint.textContent = (pw.value === pw2.value) ? 'Passwords match' : 'Passwords do not match';
        hint.className = (pw.value === pw2.value) ? 'text-success small' : 'text-danger small';
      } else {
        hint.textContent = '';
      }
    }
    pw.addEventListener('input', update);
    pw2.addEventListener('input', update);
  })();
</script>
@endpush
