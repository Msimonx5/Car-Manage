@extends('layouts.app')

@section('title','Modifier un véhicule')

@section('content')

<div class="container-fluid">

    @include('components.alerts.errors')

    <div class="card shadow">

        <div class="card-header">

            <h4>Modifier le véhicule</h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('vehicles.update',$vehicle) }}"
                method="POST">

                @csrf

                @method('PUT')

                @include('vehicles._form')

            </form>

        </div>

    </div>

</div>

@endsection