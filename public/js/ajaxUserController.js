$(function () {

    var route = $('.table').data('route');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: route,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'lstName', name: 'lstName'},
            {data: 'fstName', name: 'fstName'},
            {data: 'job', name: 'job'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewRecord').click(function () {
        $('#saveBtn').val("create-input");
        $('#record_id').val('');
        $('#addRecord').trigger("reset");
        $('#modelHeading').html("Create New Input");
        $('#ajaxModel').modal('show');
    });


    $('body').on('click', '.editRecord', function () {
        var record_id = $(this).data('id');
        $.get(route + '/' + record_id + '/edit', function (data) {
            $('#record_id').val(data.record_id);
            $('#modelHeading').html("Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#record_id').val(record_id);
            $('#fstName').val(data.fstName);
            $('#lstName').val(data.lstName);
            $('#email').val(data.email);
            $('#password').val(data.password);
        })
    });

});
