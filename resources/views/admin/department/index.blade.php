@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-role-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">View and Search Department</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/user')}}">admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/department/')}}">department</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@endsection
@section('content')
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
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
                <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <label for="name" class="control-label">Department Name:</label>
                            <div>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary form-control" id="saveBtn" value="create">Save changes
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
          ajax: "{{ route('departments.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'created_at', name: 'created at'},
              {data: 'updated_at', name: 'updated at'},
              {data: 'actions', name: 'actions', orderable: false, searchable: true},
          ]
      });
      $('body').on('click', '.editUser', function () {
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        var user_id = $(this).data('id');
        $('#id').val(user_id);
        var url = "{{route('departments.edit',':id')}}";
        url = url.replace(':id',user_id);
        $.get(url, function (data) {
            $('#modelHeading').html("Edit Department");
            $('#updateBtn').html("UPDATE");
            $('#ajaxModel').modal('show');
            $('#name').val(data.name);
            $('#product_id').val(data.id);
        })
     });
      
      $('#saveBtn').click(function (e) {
        var user_id = $('#product_id').val();
        console.log(user_id)
        var urlUpdate = "{{route('departments.update',':id')}}";
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
        var url_destroy = "{{route('departments.destroy',':id')}}";
        url_destroy = url_destroy.replace(':id',user_id);
        if (confirm("Are you sure want to delete this department?") == true) {
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