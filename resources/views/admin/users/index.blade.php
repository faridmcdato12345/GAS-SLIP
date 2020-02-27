@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-user-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">users</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>USERNAME</th>
                <th>EMAIL ADDRESS</th>
                <th>ROLE</th>
                <th>DEPARTMENT</th>
                <th width="280px">STATUS</th>
                <th width="280px">ACTIONS</th>
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
                        <label for="name" class="control-label">Name</label>
                        <div class="col-sm-offset-2">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            {!! Form::label('role_id','Role:') !!}
                            {!! Form::select('role_id',$role ,null,['class'=>'form-control role']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            {!! Form::label('department_id','Department:') !!}
                            {!! Form::select('department_id',$departments ,null,['class'=>'form-control department']) !!}
                        </div>
                    </div>
                    <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary form-control" id="updateBtn" value="create">
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
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'username', name: 'username'},
              {data: 'email', name: 'email'},
              {data: 'role_id', name: 'role_id'},
              {data: 'department_id', name: 'department_id'},
              {data: 'status', name: 'status', orderable: false, searchable: true},
              {data: 'actions', name: 'actions', orderable: false, searchable: true},
          ]
      });
      $('body').on('click', '.editUser', function () {
        $('#product_id').val('');
          $('#productForm').trigger("reset");
        var user_id = $(this).data('id');
        $('#id').val(user_id);
        var url = "{{route('users.edit',':id')}}";
        url = url.replace(':id',user_id);
        $.get(url, function (data) {
            $('#modelHeading').html("Edit User");
            $('#updateBtn').html("UPDATE");
            $('#ajaxModel').modal('show');
            $('#name').val(data.name);
            $('.role').val(data.role_id);
            $('.department').val(data.department_id);
            $('.position').val(data.department_position_id);
        })
     });
     $('body').on('click','.userActive',function () {
        var u = $(this).data('id');
        var urlUpdate = "{{route('user.active',':id')}}";
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
      $('body').on('click','.userInActive',function () {
        var u = $(this).data('id');
        var urlUpdate = "{{route('user.inactive',':id')}}";
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
      
      $('#updateBtn').click(function (e) {
            var u = $('#id').val();
            var urlUpdate = "{{route('users.update',':id')}}";
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
      
      $('body').on('click', '.deleteUser', function () {
        var user_id = $(this).data("id");
        var user_name = $(this).data("name");
        var url_destroy = "{{route('users.destroy',':id')}}";
        url_destroy = url_destroy.replace(':id',user_id);
        if (confirm("Are you sure want to delete this user?") == true) {
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
