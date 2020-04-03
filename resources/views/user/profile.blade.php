@extends('layout.template')


@section('title', 'Dashboard Input')

<div class ="loader loader-default is-active"></div>
@section('graphic')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Ciao {{ $user->fstName }}</h1>
        </div>
    </div>

@endsection



@section('content')

<div class="container container-fluid">
        @include('alert.message')
    <div class="row" >

        <div class="col-6 col-sm-12" style="padding: 15px 0 15px 10px">Nome: {{ $user->fstName }}</div>
        <div class="col-6 col-sm-12" style="padding: 15px 0 15px 10px">Cognome: {{ $user->lstName }}</div>

        <!-- Force next columns to break to new line at md breakpoint and up -->


        <div class="col-6 col-sm-12" style="padding: 15px 0 15px 10px">Email: {{ $user->email }}</div>
        <div class="col-6 col-sm-12" style="padding: 15px 0 15px 10px">Lavoro: {{ $user->job->name }}</div>

</div>



    @endsection



