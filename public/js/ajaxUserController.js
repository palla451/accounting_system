$(function () {
    var route = $('.table').data('route');

    console.log(route);

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
            {data: 'fstName', name: 'fstName'},
            {data: 'lstName', name: 'lstName'},
            {data: 'job', name: 'job_id'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    $('#createNewRecord').click(function () {
        console.log(route);
        $('#saveBtn').val("create-user");
        $('#record_id').val('');
        $('#addRecord').trigger("reset");
        $('#modelHeading').html("Create New User");
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
            $('#job_id').val(data.job);
        })
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
            data: $('#addRecord').serialize(),
            url: route,
            type: "POST",
            dataType: 'json',
            beforeSend: function () {
                $('#ajaxModel').modal('hide');
                $(".se-pre-con").css("opacity", 0.5).show();
            },
            success: function (data) {
                $(".se-pre-con").delay(2000).fadeOut();
                $('#addRecord').trigger("reset");
                $('#saveBtn').html('Send');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                alert('Ops, qualcosa è andato storto.....');
                $(".se-pre-con").delay(2000).fadeOut();
            }
        });
    });

    $('body').on('click', '.deleteRecord', function () {
        var record_id = $(this).data("id");
        if(confirm("Are You sure want to delete !")){
            $.ajax({
                type: "DELETE",
                url: route + '/' + record_id,
                beforeSend: function () {
                    $(".se-pre-con").css("opacity", 0.5).show();
                },
                success: function (data) {
                    $(".se-pre-con").delay(2000).fadeOut();
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        };

    });


    $('body').on('click', '.softDeleteRecord', function () {
        var record_id = $(this).data("id");

        // $('.softDeleteRecord').data('button', record_id).hide();
        console.log($(this));
        if(confirm("Are You sure want to disabled !")){
            $.ajax({
                type: "DELETE",
                route: route,
                url: route + '/delete/' + record_id,
                beforeSend: function () {
                    $(".se-pre-con").css("opacity", 0.5).show();

                },
                success: function (data) {
                    $(".se-pre-con").delay(2000).fadeOut();
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        };
    });


    $('body').on('click', '.restoreRecord', function () {
        var record_id = $(this).data("id");

        if(confirm("Are You sure want to reactive !")){
            $.ajax({
                type: "PATCH",
                route: route,
                url: route + '/restore/' + record_id,
                beforeSend: function () {
                    $(".se-pre-con").css("opacity", 0.5).show();

                },
                success: function (data) {
                    $(".se-pre-con").delay(2000).fadeOut();
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        };
    });

});
