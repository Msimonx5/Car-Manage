@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">Créer un compte</h3>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">

                        @csrf

                        <!-- Nom -->

                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Votre nom">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->

                        <div class="mb-3">
                            <label class="form-label">Adresse email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="example@email.com">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->

                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="********">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmation -->

                        <div class="mb-4">
                            <label class="form-label">Confirmer le mot de passe</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="********">
                        </div>

                        <!-- Bouton -->

                        <button type="submit" class="btn btn-primary w-100">
                            S'inscrire
                        </button>

                    </form>

                </div>

                <div class="card-footer text-center bg-white">

                    <small>
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Se connecter
                        </a>
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection