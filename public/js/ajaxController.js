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

        $.get(route + '/' +input_id + '/edit', function (data) {
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
            url: route,
            type: "POST",
            dataType: 'json',
            beforeSend: function () {
                $('#ajaxModel').modal('hide');
                $(".se-pre-con").css("opacity", 0.5).show();
            },
            success: function (data) {
                $(".se-pre-con").delay(2000).fadeOut();
                $('#addInput').trigger("reset");
                $('#saveBtn').html('Send');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                alert('Ops, qualcosa è andato storto.....')
            }
        });
    });

    $('body').on('click', '.deleteInput', function () {
        var product_id = $(this).data("id");
        confirm("Are You sure want to delete !");
        $.ajax({
            type: "DELETE",
            url: route + '/' +product_id,
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
    });

});

function convertDateTostring(dateConvert) {
    var dateConvert = dateConvert.toString().slice(0,10);
    var dateSplit = dateConvert.split('-');
    var newDate = dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0];
    return newDate;
}
