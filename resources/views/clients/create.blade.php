@extends('layouts.app')

@section('title','Ajouter un client')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        Nouveau client
                    </h4>

                    <a href="{{ route('clients.index') }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                </div>

                <div class="card-body">

                    <form
                        action="{{ route('clients.store') }}"
                        method="POST">

                        @csrf

                        @include('clients._form')

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection