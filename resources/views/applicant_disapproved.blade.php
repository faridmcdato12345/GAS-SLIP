@extends('layouts.app')
@section('content')
    <table class="table table-bordered data-table" data-order='[[0,"desc"]]'>
        <thead>
            <tr>
                <th>CONTROL NUMBER</th>
                <th>NAME</th>
                <th>DESTINATION</th>
                <th>PURPOSES</th>
                <th>PERSONNEL</th>
                <th>REMARKS</th>
                <th>APPLIED AT</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('datatable-script')
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
          ajax: "{{ route('applicant.disapproved') }}",
          columns: [
              {data: 'control_number', name: 'control_number'},
              {data: 'applicant_id', name: 'applicant_id'},
              {data: 'destination', name: 'destination'},
              {data: 'purposes', name: 'purposes'},
              {data: 'personnel', name: 'personnel'},
              {data: 'remarks', name: 'remarks'},
              {data: 'created_at', name: 'created at'},
          ]
      });
    $('body').on('click','.approveApp',function () {
        var u = $(this).data('id');
        var urlUpdate = "{{route('application.approve',':id')}}";
        urlUpdate = urlUpdate.replace(':id',u);
        $(this).html('Updating..');
        $.ajax({
            url: urlUpdate,
            type: "PATCH",
            dataType: 'json',
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                $('#updateBtn').html('User Updated');
            }
        });
    });
    $('body').on('click','.disapproveApp',function () {
        var u = $(this).data('id');
        var urlUpdate = "{{route('application.disapprove',':id')}}";
        urlUpdate = urlUpdate.replace(':id',u);
        $(this).html('Updating..');
        $.ajax({
            url: urlUpdate,
            type: "PATCH",
            dataType: 'json',
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                $('#updateBtn').html('User Updated');
            }
        });
    });
    $('#notifyBell').click(function(){
        // table.draw();
        $('#notifyBell').css('color','rgba(0, 0, 0, 0.5)')
    })
    });
  </script>
@endsection
