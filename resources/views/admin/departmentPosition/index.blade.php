@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-role-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">View and Search Positions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/user')}}">admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/departmentPositions/')}}">position</a></li>
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
                        <label for="name" class="control-label">Name</label>
                        <div class="">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
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
          ajax: "{{ route('departmentPositions.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'actions', name: 'actions', orderable: false, searchable: true},
          ]
      });
       
      $('#createNewProduct').click(function () {
          $('#saveBtn').val("create-product");
          $('#product_id').val('');
          $('#productForm').trigger("reset");
          $('#modelHeading').html("Create New Product");
          $('#ajaxModel').modal('show');
      });
      
      $('body').on('click', '.editUser', function () {
        var product_id = $(this).data('id');
        $.get("{{ route('departmentPositions.index') }}" +'/' + product_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Product");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#detail').val(data.detail);
        })
     });
      
     $('#saveBtn').click(function (e) {
        var user_id = $('#product_id').val();
        var urlUpdate = "{{route('departmentPositions.update',':id')}}";
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
        var url_destroy = "{{route('departmentPositions.destroy',':id')}}";
        url_destroy = url_destroy.replace(':id',user_id);
        if (confirm("Are you sure want to delete this position?") == true) {
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