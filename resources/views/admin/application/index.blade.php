@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-role-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">View, Search, Edit, Delete Application</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/user')}}">admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/applicant/')}}">applicant</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@endsection
@section('content')
<table class="table table-bordered data-table">
    {{-- <thead>
        <tr>
            <th>ID</th>
            <th>APPLICANT NAME</th>
            <th>DEPARTMENT</th>
            <th>DESTINATION</th>
            <th>PURPOSE</th>
            <th>PERSONNEL CONCERN</th>
            <th>VEHICLE</th>
            <th>LITER</th>
            <th>CREATED AT</th>
            <th>UPDATED AT</th>
            <th width="280px">ACTION</th>
        </tr>
    </thead> --}}
    <tbody>
        @foreach ($data as $user)
            <p>This is user {{ $user->applicant_id->name }}</p>
        @endforeach
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

    //   var table = $('.data-table').DataTable({
    //       processing: true,
    //       serverSide: true,
    //       ajax: "{{ route('applicants.index') }}",
    //       columns: [
    //           {data: 'id', name: 'id'},
    //           {data: 'applicant_id', name: 'applicant_id'},
    //           {data: 'department_id', name: 'department_id'},
    //           {data: 'destination', name: 'destination'},
    //           {data: 'request_liters', name: 'request_liters'},
    //           {data: 'purpose', name: 'purpose'},
    //           {data: 'personnel', name: 'personnel'},
    //           {data: 'created_at', name: 'created at'},
    //           {data: 'actions', name: 'actions', orderable: false, searchable: true},
    //       ]
    //   });
      $('body').on('click', '.editUser', function () {
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        var user_id = $(this).data('id');
        $('#id').val(user_id);
        var url = "{{route('applicants.edit',':id')}}";
        url = url.replace(':id',user_id);
        $.get(url, function (data) {
            $('#modelHeading').html("Edit Department");
            $('#updateBtn').html("UPDATE");
            $('#ajaxModel').modal('show');
            $('#name').val(data.name);
            $('#vehicle').val(data.vehicle);
            $('#liters').val(data.liters);
            $('#id').val(data.id);
        })
     });
      
      $('#saveBtn').click(function (e) {
        var user_id = $('#id').val();
        var urlUpdate = "{{route('applicants.update',':id')}}";
        urlUpdate = urlUpdate.replace(':id',user_id);
        e.preventDefault();
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
      
      $('body').on('click', '.deleteUser', function () {
        var user_id = $(this).data("id");
        var user_name = $(this).data("name");
        var url_destroy = "{{route('applicants.destroy',':id')}}";
        url_destroy = url_destroy.replace(':id',user_id);
        if (confirm("Are you sure want to delete this applicant?") == true) {
            $.ajax({
                type: "DELETE",
                url: url_destroy,
                dataType: 'json',
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } 
      }); 
       
    });
  </script>
@endsection