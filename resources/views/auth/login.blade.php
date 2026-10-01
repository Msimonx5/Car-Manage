@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')

<h2>Bon retour 👋</h2>
<p class="sub">Connectez-vous pour accéder à votre tableau de bord.</p>

@if(session('success'))
    <div class="flash ok">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Adresse email</label>
        <div class="input-ico">
            <i class="bi bi-envelope"></i>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="admin@location.ma" autofocus>
        </div>
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <div class="input-ico">
            <i class="bi bi-lock"></i>
            <input id="login-password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="••••••••">
            <button type="button" class="password-toggle" id="toggle-login-password"
                    aria-label="Afficher le mot de passe" aria-pressed="false">
                <i class="bi bi-eye" aria-hidden="true"></i>
            </button>
        </div>
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Se souvenir de moi</label>
        </div>
        {{-- <a href="{{ route('password.request') }}">Mot de passe oublié ?</a> --}}
    </div>

    <button type="submit" class="btn-brand"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
</form>

<div class="auth-foot">
    {{-- Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a> --}}
</div>

<style>
    .input-ico .form-control[name="password"] { padding-right: 46px; }
    .password-toggle {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        border: 0; background: transparent; color: #6b7280; padding: 6px; line-height: 1;
    }
    .input-ico .password-toggle i { position: static; transform: none; color: inherit; }
    #login-password::-ms-reveal { display: none; }
</style>
<script>
    document.getElementById('toggle-login-password')?.addEventListener('click', function () {
        const input = document.getElementById('login-password');
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        this.setAttribute('aria-pressed', String(visible));
        this.setAttribute('aria-label', visible ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        this.innerHTML = `<i class="bi ${visible ? 'bi-eye-slash' : 'bi-eye'}" aria-hidden="true"></i>`;
    });
</script>

@endsection
