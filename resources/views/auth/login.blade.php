@extends('layouts.app')

@section('title','Connexion')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">

                    <h3>Connexion</h3>

                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('login') }}">

                        @csrf

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}">

                        </div>

                        <div class="mb-3">

                            <label>Mot de passe</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control">

                        </div>

                        <div class="form-check mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember">

                            <label class="form-check-label">
                                Se souvenir de moi
                            </label>

                        </div>

                        <button class="btn btn-primary w-100">
                            Se connecter
                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection