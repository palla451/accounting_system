$(function () {

    var route = $('.table').data('route');
    var char_id = $('#char_id').val();
    var char_api = $('#char_api').val();
    console.log(char_id);
    console.log(char_api);


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
            {data: 'description', name: 'description'},
            {data: 'payment', name: 'payment'},
            {data: 'import', name: 'import'},
            {data: 'date', name: 'date'},
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
            var dateCovert = convertDateTostring(data.date);
            $('#record_id').val(data.record_id);
            $('#modelHeading').html("Edit Input");
            $('#saveBtn').val("edit-input");
            $('#ajaxModel').modal('show');
            $('#record_id').val(record_id);
            $('#description').val(data.description);
            $('#payment').val(data.payments[0].id);
            $('#import').val(data.import);
            $('#datepicker').val(dateCovert);
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
                console.log(char_id + '_refresh(' + char_api + ')');
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

});

function convertDateTostring(dateConvert) {
    var dateConvert = dateConvert.toString().slice(0,10);
    var dateSplit = dateConvert.split('-');
    var newDate = dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0];
    return newDate;
}
