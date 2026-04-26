@extends('layouts/fullLayoutMaster')

@section('title', 'Admin Login')

@section('page-style')
<link rel="stylesheet" href="{{ Helper::viteAsset('css/base/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo">
          <img src="{{ Helper::viteAsset('img/logo_black.png') }}" style="width: 85%;" alt="MB Design Studio" />
        </a>

        <p class="card-text mb-2">Por favor ingrese a su cuenta</p>

        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label for="login-username" class="form-label">Usuario</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="login-username" name="username" placeholder="Usuario" aria-describedby="login-username" tabindex="1" autofocus value="{{ old('username') }}" />
            @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label for="login-password">Contrasena</label>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">
                <small>Olvido su contrasena?</small>
              </a>
              @endif
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            @error('password')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="remember-me" name="remember" tabindex="3" {{ old('remember') ? 'checked' : '' }} />
              <label class="custom-control-label" for="remember-me">Recuerdame</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" tabindex="4">Iniciar sesion</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
