@extends('layouts.app')

@section('title','Mot de passe oublié')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Réinitialiser le mot de passe
                </div>

                <div class="card-body">

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100">
                            Envoyer le lien
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">
                            Retour à la connexion
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection