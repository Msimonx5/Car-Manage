@extends('layouts.app')

@section('title','Réinitialiser le mot de passe')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Nouveau mot de passe
                </div>

                <div class="card-body">

                    <form action="{{ route('password.update') }}"
                          method="POST">

                        @csrf

                        <input type="hidden"
                               name="token"
                               value="{{ $token }}">

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email',$email) }}"
                                class="form-control @error('email') is-invalid @enderror">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label>Nouveau mot de passe</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label>Confirmer le mot de passe</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control">

                        </div>

                        <button class="btn btn-primary w-100">
                            Modifier le mot de passe
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection