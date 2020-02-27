@extends('layouts.app')
@section('content')
<cashierapplication-alert department_id="{{auth()->user()->department_id}}"></cashierapplication-alert>
<input type="text" name="dates" class="form-control pull-right dates">
<br>
{!! Form::open(['method'=>'POST','action'=>'HomeController@getReportDate','files'=>true]) !!}
    <div class="form-group">
        <input type="hidden" name="startDate" id="startDate">
        <input type="hidden" name="endDate" id="endDate">
    </div>
    <div class="form-group">
        {!! Form::submit('View',['class'=>'form-control btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
@endsection
@section('datatable-script')

<script type="text/javascript">
$(document).ready(function(){
    $('input[name="dates"]').daterangepicker({
        "opens": "center"
    },function(start, end, label) {
        var dateArray = [start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD')]
        localStorage.setItem("daterange",JSON.stringify(dateArray))
        $('#startDate').val(start.format('YYYY-MM-DD'))
        $('#endDate').val(end.format('YYYY-MM-DD'))
    });
    $('.printReport').on('click',function(){
        console.log($('.dates').val());
    })
    $('.gas_slip').click(function(){
        table.draw();
        $('.gas_slip').css('color','rgba(0, 0, 0, 0.7)')
    })
});
  </script>
 
@endsection
