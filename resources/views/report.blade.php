@extends('layouts.app')
@section('content')
{!! Form::open(['method'=>'POST','action'=>'ReportController@printReport','files'=>true]) !!}
    <div class="form-group">
        <input type="hidden" name="startDate" id="startDate">
        <input type="hidden" name="endDate" id="endDate">
    </div>
    <div class="form-group">
        {!! Form::submit('Print Report',['class'=>'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
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
            <th>U/P</th>
            <th>AMOUNT</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody multiple>
        @foreach ($appDate as $user)
            <tr onmousedown="RowClick(this,false);">
                <td class="appId" style="display:none;">{{ $user->id}}</td>
                <td>{{ $user->control_number }}</td>
                <td>{{ $user->created_at }}</td>
                @if($user->applicant_id != null)
                    <td>{{ $user->applicant->name }}</td>
                @else
                    <td>{{ $user->unregistered_applicant}}</td>
                @endif
                <td>{{ $user->request_liters }}</td>
                <td>{{ $user->UP }}</td>
                <td>{{ $user->request_liters * $user->UP}}</td>
                <td><button class="btn btn-primary editSum">EDIT</button></td> 
            </tr>
        @endforeach
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
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <label for="name" class="control-label">Applicant Name:</label>
                            <div>
                                <input type="text" class="form-control" id="name" name="name" value="" maxlength="50" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <label for="name" class="control-label">Liters:</label>
                            <div>
                                <input type="text" class="form-control" id="liters" name="liters" value="" maxlength="50" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <label for="name" class="control-label">U/P:</label>
                            <div>
                                <input type="text" class="form-control" id="up" name="up" value="" maxlength="50" required="">
                            </div>
                        </div>
                    </div>  
                </form>
                <div class="col-sm-offset-2">
                    <button class="btn btn-primary form-control saveBtn" id="saveBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('datatable-script')
<script type="text/javascript">
    $(document).ready(function(){
        var daterange = localStorage.getItem('daterange');
        var array_date = JSON.parse(daterange);
        $('#startDate').val(array_date[0])
        $('#endDate').val(array_date[1])
        console.log($('#endDate').val(array_date[1]))
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = '';
        $('input[name="dates"]').daterangepicker({
        "opens": "center"
        });
        $('.editSum').on('click',function(){  
            id = $(this).closest("tr").find("td:first-child").text();
            var url = "{{route('report.edit',':id')}}";
            var urls = url.replace(':id',id);
            $.get(urls, function (data) {
                console.log(data.data.unregistered_applicant);
                $('#modelHeading').html("Update");
                $('#ajaxModel').modal('show');
                if(data.data.applicant_id != null){
                    $('#name').val(data.data.applicant.name);
                }else{
                    $('#name').val(data.data.unregistered_applicant)
                }
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
        $('table tr').click(function(){
            var index = $(this).index()
            console.log($('table tr:eq('+(index+1)+') td:eq(0)').text());
        })
    });
    var rowArray = [];
    var lastSelectedRow;
    var trs = document.getElementById('myTable').tBodies[0].getElementsByTagName('tr');

    // disable text selection
    document.onselectstart = function() {
        return false;
    }

    function RowClick(currenttr, lock) {
        if (window.event.ctrlKey) {
            toggleRow(currenttr);
        }
        
        if (window.event.button === 0) {
            if (!window.event.ctrlKey && !window.event.shiftKey) {
                clearAll();
                toggleRow(currenttr);
            }
        
            if (window.event.shiftKey) {
                selectRowsBetweenIndexes([lastSelectedRow.rowIndex, currenttr.rowIndex])
            }
        }
    }
    function toggleRow(row) {
        row.className = row.className == 'selected' ? '' : 'selected';
        lastSelectedRow = row;
    }
    function selectRowsBetweenIndexes(indexes) {
        indexes.sort(function(a, b) {
            return a - b;
        });

        for (var i = indexes[0]; i <= indexes[1]; i++) {
            trs[i-1].className = 'selected';
        }
    }
    function clearAll() {
        for (var i = 0; i < trs.length; i++) {
            trs[i].className = '';
        }
    }
    
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