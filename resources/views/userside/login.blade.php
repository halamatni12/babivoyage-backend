@extends('userside.app')
@section('title','Login – BabiVoyage')

@section('content')
<div class="container py-5" style="max-width: 560px;">
  <div class="text-center mb-4" data-aos="fade-down">
    <h2 class="fw-bold mb-1">Welcome back</h2>
    <p class="text-secondary mb-0">Sign in to manage your trips and bookings</p>
  </div>

  <div class="card card-elevate p-4 p-md-5" data-aos="fade-up">
    {{-- Status / Errors --}}
    @if (session('status'))
      <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <strong>There were some issues:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" novalidate>
      @csrf

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
        <label class="form-label d-flex align-items-center justify-content-between">
          <span>Password</span>
          @if (Route::has('password.request'))
            <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot?</a>
          @endif
        </label>
        <div class="input-group" x-data="{show:false}">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password"
                 name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 id="loginPassword"
                 required>
          <button class="btn btn-outline-secondary" type="button" id="toggleLoginPw" tabindex="-1">
            <i class="bi bi-eye"></i>
          </button>
          @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Remember me</label>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-1"></i> Login
      </button>

      <p class="text-center mt-3 mb-0">
        New here? <a href="{{ route('register') }}" class="text-decoration-none">Create an account</a>
      </p>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Toggle show/hide password (Login)
  (function(){
    const btn = document.getElementById('toggleLoginPw');
    const inp = document.getElementById('loginPassword');
    if (!btn || !inp) return;
    btn.addEventListener('click', function(){
      const isPwd = inp.getAttribute('type') === 'password';
      inp.setAttribute('type', isPwd ? 'text' : 'password');
      this.innerHTML = isPwd ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
  })();
</script>
@endpush
