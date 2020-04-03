@extends('layout.template')

@section('title', 'Dashboard Input')


<div class ="loader loader-default is-active"></div>

@section('graphic')
    <form name="chart">
        <input type="hidden" id="char_api" value="{{ $chart->id }}_api_url" />
        <input type="hidden" id="char_id" value="{{ $chart->id }}" />
        <div class="jumbotron  jumbotron-fluid">
            <div class="container">
                {!! $chart->container() !!}
            </div>
        </div>
        <button type="submit" class="btn btn-primary" >refresh</button>
    </form>
    @endsection

@section('content')
    <h1>Inputs</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewRecord">Insert new Input</a>
    <table class="table table-bordered data-table" width="100%" data-route="{{ route('inputs.index') }}">
        <thead>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th>Payment</th>
            <th>Import</th>
            <th>Date</th>
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
                            <label for="description" class="col-sm-2 control-label">Descriptions</label>
                            <div class="col-sm-12">
                                <textarea id="description" name="description" required="" placeholder="Enter Description" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="import" class="col-sm-2 control-label">Import</label>
                            <div class="col-sm-12">
                                <input type="text" id="import" name="import" required="" placeholder="Es. 12,58" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Payment</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="payment" id="payment">
                                    @foreach($payments as $payment)
                                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date</label>
                            <div class='col-sm-12'>
                                <div class="input-group-prepend">
                                    <input class="form-control" name="date" placeholder="dd-mm-yyyy" type="text"  id="datepicker" />
                                </div>
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
    <script src="{{ asset('js/ajaxController.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endsection
