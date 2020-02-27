@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-cpanel-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">View and Search Cpanel Accounts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/users')}}">admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/cpanels/')}}">cpanel</a></li>
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
                <th>URL</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
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
               <input type="hidden" name="product_id" id="id">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Url</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Enter Url" value="" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-12">
                        <input type="text" id="username" name="username" required="" placeholder="Enter username" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-12">
                        <input type="text" id="password" name="password" required="" placeholder="Enter password" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12">
                 <button type="submit" class="btn btn-primary form-control" id="updateBtn" value="create">Save changes
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
          ajax: "{{ route('cpanels.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'url', name: 'url'},
              {data: 'username', name: 'username'},
              {data: 'password', name: 'password'},
              {data: 'created_at', name: 'created at'},
              {data: 'updated_at', name: 'updated at'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
      $('body').on('click', '.editCpanel', function () {
        var user_id = $(this).data('id');
        $('#id').val(user_id);
        var url = "{{route('cpanels.edit',':id')}}";
        url = url.replace(':id',user_id);
        $.get(url, function (data) {
            $('#modelHeading').html("Edit Cpanel Account");
            $('#updateBtn').html("UPDATE");
            $('#ajaxModel').modal('show');
            $('#url').val(data.url);
            $('#username').val(data.username);
            $('#password').val(data.password);
        })
     });
      
     $('#updateBtn').click(function (e) {
            var u = $('#id').val();
            var urlUpdate = "{{route('cpanels.update',':id')}}";
            urlUpdate = urlUpdate.replace(':id',u);
          e.preventDefault();
          $(this).html('Updating..');
      
          $.ajax({
            data: $('#productForm').serialize(),
            url: urlUpdate,
            type: "PUT",
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
      $('body').on('click', '.deleteCpanel', function () {
          var user_id = $(this).data("id");
          console.log(user_id);
          var user_name = $(this).data("name");
          var url_destroy = "{{route('users.destroy',':id')}}";
            url_destroy = url_destroy.replace(':id',user_id);
          if (confirm("Are You sure want to delete this cpanel account?") == true) {
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