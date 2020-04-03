@extends('layout.template')

@section('title', 'Administrator')


<div class ="loader loader-default is-active"></div>

@section('graphic')

        <div class="jumbotron  jumbotron-fluid">
            <div class="container">
                <h1>Table user administration</h1>
            </div>
        </div>

@stop

@section('content')
<h1>User</h1>
<a class="btn btn-success" href="javascript:void(0)" id="createNewRecord">Insert new User</a>
<table class="table table-bordered data-table" width="100%" data-route="{{ route('users.index') }}">
    <thead>
    <tr>
        <th>No</th>
        <th>First name</th>
        <th>Last Name</th>
        <th>Job</th>
        <th>email</th>
        <th width="280px">Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="addRecord" name="addRecord" class="form-horizontal">


                    <input type="hidden" name="record_id" id="record_id">

                    <div class="form-group">
                        <label for="fstName" class="col-sm-3 control-label">First name</label>
                        <div class="col-sm-12">
                            <input type="text" id="fstName" name="fstName" placeholder="First name" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lstName" class="col-sm-3 control-label">Last name</label>
                        <div class="col-sm-12">
                            <input type="text" id="lstName" name="lstName" placeholder="Last name" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="job" class="col-sm-3 control-label">Job</label>
                        <div class="col-sm-12">
                            <select type="number" name="job" class="form-control" id="job" required>
                                <option value="{{ $user->job_id }}" selected>{{ $user->job->name }}</option>
                                @foreach( $jobs as $job)
                                    @if($job->id != $user->job_id)
                                        <option value="{{ $job->id }}"> {{ $job->name }} </option>
                                    @endif
                                @endforeach

                                @if ($errors->has('job_id'))
                                    <span class="error">{{ $errors->first('job_id') }}</span>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" id="password" name="password" placeholder="**********" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" placeholder="Email" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script src="{{ asset('js/ajaxUserController.js') }}"></script>
@endsection
