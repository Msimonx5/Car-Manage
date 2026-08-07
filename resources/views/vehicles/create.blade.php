@extends('layouts.app')

@section('title','Nouveau véhicule')

@section('content')

<div class="container-fluid">

    @include('components.alerts.errors')

    <div class="card shadow">

        <div class="card-header">

            <h4>Ajouter un véhicule</h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('vehicles.store') }}"
                method="POST">

                @csrf

                @include('vehicles._form')

            </form>

        </div>

    </div>

</div>

@endsection