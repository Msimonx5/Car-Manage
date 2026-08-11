@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')

<h2>Créer un compte</h2>
<p class="sub">Rejoignez SOULAMI CAR en quelques secondes.</p>

@if(session('success'))
    <div class="flash ok">{{ session('success') }}</div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nom complet</label>
        <div class="input-ico">
            <i class="bi bi-person"></i>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror" placeholder="Votre nom" autofocus>
        </div>
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Adresse email</label>
        <div class="input-ico">
            <i class="bi bi-envelope"></i>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" placeholder="example@email.com">
        </div>
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <div class="input-ico">
            <i class="bi bi-lock"></i>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
        </div>
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Confirmer le mot de passe</label>
        <div class="input-ico">
            <i class="bi bi-lock-fill"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
        </div>
    </div>

    <button type="submit" class="btn-brand"><i class="bi bi-person-plus"></i> S'inscrire</button>
</form>

<div class="auth-foot">
    Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
</div>

@endsection
