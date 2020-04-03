@extends('user.master')

@section('title', 'Register')


@section('content')

    <form class="form-signin" action="{{url('post-register')}}" method="POST">

        <img class="mb-4" src="{{ asset('img/my_bookkepig.png') }}" alt="" width="140" height="140">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="inputFstName" class="sr-only">First Name</label>
            <input type="text" name="fstName" class="form-control" id="inputFstName" placeholder="First Name" required autofocus>

            @if ($errors->has('fstName'))
                <span class="error">{{ $errors->first('fstName') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="inputLstName" class="sr-only">Last Name</label>
            <input type="text" name="lstName" class="form-control" id="inputLstName" placeholder="Last Name" required>

            @if ($errors->has('lstName'))
                <span class="error">{{ $errors->first('lstName') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email address" required>
            @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
            @endif
        </div>


        <div class="form-group">
            <label for="inputJob" class="sr-only">Your Job</label>
            <select type="number" name="job_id" class="form-control job" id="inputJob" required>
                <option value="" selected> --- Select an option ---</option>
                @foreach( $jobs as $job)
                 <option value="{{ $job->id }}"> {{ $job->name }} </option>
                @endforeach

            @if ($errors->has('job_id'))
                <span class="error">{{ $errors->first('job_id') }}</span>
            @endif
            </select>
        </div>


        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>

            @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign Up</button>
        <div class="text-center">If you have an account?
            <a class="small" href="{{url('login')}}">Sign In</a></div>
    </form>

    @stop
