@extends('user.master')

@section('title', 'Login')

@section('sidebar')

@stop


@section('content')

    @include('alert.message')

<form class="form-signin" action="{{ url('post-login') }}"  method="POST">
    <img class="mb-4" src="{{ asset('img/my_bookkepig.png') }}" alt="" width="140" height="140">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

    {{ csrf_field() }}
    <div class="form-group">
        <label for="email" class="sr-only">Email address</label>
        <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" required autofocus>
    </div>
    <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required>
    </div>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    <div class="text-center">If you have an account?
        <a class="small" href="{{url('register')}}">Sign Up</a>
    </div>
    <p class="mt-5 mb-3 text-muted">&copy; 2020-2021 by G.D.</p>

</form>
    @stop
