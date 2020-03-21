@extends('layout.template')

@section('title', 'Dashboard')


<div class ="loader loader-default is-active"></div>
@section('graphic')
    <div class="jumbotron">
        <h1>Bootstrap Tutorial</h1>
        <p>Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first projects on the web.</p>
    </div>
    @stop

@section('content')
    <h1>Inputs</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewInput">Insert new Input</a>
    <table class="table table-bordered data-table" width="100%">
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
                    <form id="addInput" name="addInput" class="form-horizontal">
                        <input type="hidden" name="input_id" id="input_id">

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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('inputs.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'description', name: 'description'},
                {data: 'payment', name: 'payment'},
                {data: 'import', name: 'import'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewInput').click(function () {
            $('#saveBtn').val("create-input");
            $('#input_id').val('');
            $('#addInput').trigger("reset");
            $('#modelHeading').html("Create New Input");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editInput', function () {
            var input_id = $(this).data('id');

            $.get("{{ route('inputs.index') }}" +'/' + input_id +'/edit', function (data) {
                var dateCovert = convertDateTostring(data.date);
                $('#input_id').val(data.input_id);
                $('#modelHeading').html("Edit Input");
                $('#saveBtn').val("edit-input");
                $('#ajaxModel').modal('show');
                $('#input_id').val(input_id);
                $('#description').val(data.description);
                $('#payment').val(data.payments[0].id);
                $('#import').val(data.import);
                $('#datepicker').val(dateCovert);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            var input = $(this).data("id");
            $.ajax({
                data: $('#addInput').serialize(),
                url: "{{ route('inputs.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#addInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    $('#saveBtn').html('Send');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deleteInput', function () {

            var product_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('inputs.store') }}"+'/'+product_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });


function convertDateTostring(dateConvert) {
    var dateConvert = dateConvert.toString().slice(0,10);
    var dateSplit = dateConvert.split('-');
    var newDate = dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0];
    return newDate;
}

</script>



@stop

