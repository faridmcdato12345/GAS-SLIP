@extends('layouts.app')
@section('content')
    <gmapplication-alert department_id="{{auth()->user()->department_id}}"></gmapplication-alert>
    <table class="table table-bordered data-table" data-order='[[0,"desc"]]'>
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>DESTINATION</th>
                <th>PURPOSES</th>
                <th>PERSONNEL</th>
                <th>APPLIED AT</th>
                <th width="280px">ACTION</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('modal')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="gm_flag" id="gm_flag">
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <div>
                                <textarea class="form-control" id="remarks" name="remarks" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-2">
                    <button type="button" class="btn btn-primary form-control saveBtn" id="saveBtn" value="create">Ok
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
          ajax: "{{ route('gm.applicant') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'applicant_id', name: 'applicant_id'},
              {data: 'destination', name: 'destination'},
              {data: 'purposes', name: 'purposes'},
              {data: 'personnel', name: 'personnel'},
              {data: 'created_at', name: 'created at'},
              {data: 'actions', name: 'actions', orderable: false, searchable: true},
          ]
      });
    $('body').on('click','.approveApp',function () {
        var u = $(this).data('id');
        var urlUpdate = "{{route('application.gmapprove',':id')}}";
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
    $('body').on('click','.saveBtn',function () {
        var u = $('#id').val();
        console.log(u);
        var urlUpdate = "{{route('application.gmdisapprove',':id')}}";
        urlUpdate = urlUpdate.replace(':id',u);
        $(this).html('Updating..');
        $.ajax({
            data: $('#productForm').serialize(),
            url: urlUpdate,
            type: "PATCH",
            dataType: 'json',
            success: function (data) {
                $('#productForm').trigger("reset");
                $('#ajaxModel').modal('hide');
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
        $('.label-danger').css('background-color','none!important');
    })
     $('body').on('click','.disapproveApp',function () {
        var user_id = $(this).data('id');
        var url = "{{route('gm_disapprove.edit',':id')}}";
        url = url.replace(':id',user_id);
        $('#productForm').trigger("reset");
        $.get(url, function (data) {
            $('#modelHeading').html("Add Remarks");
            $('#updateBtn').html("Ok");
            $('#ajaxModel').modal('show');
            $('#id').val(data.id);
            $('#gm_flag').val('2');
        })
    });
    });
    </script>
@endsection
