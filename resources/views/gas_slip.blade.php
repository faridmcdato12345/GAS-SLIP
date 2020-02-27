@extends('layouts.app')
@section('content')
<cashierapplication-alert department_id="{{auth()->user()->department_id}}"></cashierapplication-alert>
<br>
<div class="input-group md-form form-sm form-1 pl-0 form-group">
    <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-search text-white"
          aria-hidden="true"></i></span>
    </div>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search..." title="Type in a name" class="form-control my-0 py-1">
</div>
<table id="myTable" class="display compact cell-border table-bordered table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>CONTROL NUMBER</th>
            <th>DATE</th>
            <th>APPLICANT NAME</th>
            <th>REQUESTED LITER</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody multiple>
        @foreach ($gmapplication as $user)
            <tr>
                <td class="appId" style="display:none;">{{ $user->id}}</td>
                <td>{{ $user->control_number }}</td>
                <td>{{ $user->created_at }}</td>
                @if($user->applicant_id != null)
                    <td>{{ $user->applicant->name }}</td>
                @else
                    <td>{{ $user->unregistered_applicant}}</td>
                @endif
                <td>{{ $user->request_liters }}</td>
                {{-- <td><button class="btn btn-primary printSlip">PRINT</button></td> --}}
                <td>{!! Form::open(['method'=>'POST','action'=>'HomeController@gas_slip_get_info','files'=>true]) !!}
                    <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <input type="hidden" name="gas_slip_flag" id="gas_slip_flag" value="1">
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Print',['class'=>'btn btn-primary form-control']) !!}
                    </div>
                {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('datatable-script')
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = '';
        $('.editSum').on('click',function(){  
            id = $(this).closest("tr").find("td:first-child").text();
            var url = "{{route('report.edit',':id')}}";
            var urls = url.replace(':id',id);
            $.get(urls, function (data) {
                $('#modelHeading').html("Update");
                $('#ajaxModel').modal('show');
                $('#name').val(data.data.applicant.name);
                $('#liters').val(data.data.request_liters);
                $('#up').val(data.data.UP);
                $('#id').val(data.data.id);
            })
        })
        $('.saveBtn').on('click',function (e) {
            var urlUpdate = "{{route('report.update',':id')}}";
            urlUpdate = urlUpdate.replace(':id',id);
            e.preventDefault();
            $(this).html('Updating..');
            $.ajax({
                data:$('form').serialize(),
                url: urlUpdate,
                type: "PATCH",
                dataType: 'json',
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#updateBtn').html('User Updated');
                }
            });
        });
        $('.printSlip').on('click',function(){
            var id = $(this).closest("tr").find("td:first-child").text();
            localStorage.setItem("gas_slip_id",id);
        })
    });
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td_one = tr[i].getElementsByTagName("td")[1];
            td_two = tr[i].getElementsByTagName("td")[2];
            td_three = tr[i].getElementsByTagName("td")[3];
            if (td_one || td_two || td_three) {
            txtValue = td_one.textContent || td_one.innerText;
            txtValue_two = td_two.textContent || td_two.innerText;
            txtValue_three = td_three.textContent || td_three.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue_two.toUpperCase().indexOf(filter) > -1 || txtValue_three.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            }       
        }
    }
</script>
@endsection