@extends('layouts.application')
@section('content')
@if(Session::has('created_department'))
<p class="bg-success" style="font-weight: bold;font-size: 16px;padding: 10px 10px;text-align:center;">{{session('created_department')}}</p>
@endif
@if(Session::has('created_department_fail'))
<p class="bg-danger" style="font-weight: bold;font-size: 16px;padding: 10px 10px;text-align:center;">{{session('created_department_fail')}}</p>
@endif
    {!! Form::open(['method'=>'POST','action'=>'ApplicationController@store','files'=>true]) !!}
        <div class="form-group">
            {{-- {!! Form::hidden('applicant_id',null,['class'=>'form-control applicant_id','disabled']) !!} --}}
            <input type="hidden" name="applicant_id" id="applicant_id" class="applicant_id">
            <input type="hidden" name="department_id" id="department_id" class="department_id">
        </div>
        <div class="form-group">
            {!! Form::label('date','Date:') !!}
            {!! Form::text('date',null,['class'=>'form-control','disabled']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('vehicle','Vehicle:') !!}
            {!! Form::text('vehicle',null,['class'=>'form-control','disabled']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('liters','Liters:') !!}
            {!! Form::text('liters',null,['class'=>'form-control liters','required','disabled']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('destination','Destination:') !!}
            {!! Form::text('destination',null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group purposes">
            {!! Form::label('purposes','Purpose(s):',['class'=>'purposes-class']) !!}
            {!! Form::select('purposes', [
                'disconnection or reconnection' => 'Disconnection/Reconnection', 
                'maintenance' => 'Maintenance',
                'collection' => 'Collection',
                'purchase' => 'Purchase',
                'official travel' => 'Official Trave',
                'others'=>'Others...'
                ], 
                null, 
                [
                    'placeholder' => 'Click to choose your purpose...',
                    'class'=>'form-control',
                    'id'=>'mySelect'
                ]) 
            !!}
        </div>
        <div class="form-group">
            {!! Form::label('personnel','Personnel Concern:') !!}
            {!! Form::textarea('personnel', null, ['id' => 'personnel', 'rows' => 4, 'cols' => 54, 'style' => 'resize:none','class'=>'form-control','placeholder'=>'Add comma (,) after each name']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('SUBMIT REQUEST',['class'=>'form-control btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    {{-- @include('includes.errors') --}}
@endsection
@section('datatable-script')
<script src="{{asset('libs/js/jquery.js')}}"></script>
<script type="text/javascript">
$(document).ready(function($){
    var alloLiters = '';
    var applicantId = JSON.parse(localStorage.getItem("savedData"))[0];
    $('.applicant_id').val(applicantId);
    console.log(JSON.parse(localStorage.getItem("savedData"))[0]);
    var url = "{{route('applications.showApplicant',':id')}}";
    url = url.replace(':id',applicantId);
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        success: function (data) {
            var vehicle = data.vehicle;
            $('#vehicle').val(vehicle.toUpperCase());
            $('#date').val(data.date);
            $("#liters").val(data.liters);
            $('#department_id').val(data.department_id);
            alloLiters = parseFloat(data.liters)
            console.log(data.vehicle);
        },
        error: function (data) {
        }
    });
    $('#liters').on('change', function() {
        // console.log($('#liters').val());
        var url = "{{route('applications.showApplicant',':id')}}";
        url = url.replace(':id',JSON.parse(localStorage.getItem("savedData"))[0]);
        var remLiters = JSON.parse(localStorage.getItem("savedData"))[2];
        var reqLiters = $('#liters').val();
        if(parseFloat(reqLiters) > parseFloat(remLiters) && parseFloat(remLiters) != 0){
            alert("Your request has exceeded the remaining liters that you have left for this week.")
            $('#liters').val('')
        }
        else if(parseFloat(reqLiters) > parseFloat(alloLiters)){
            alert("Your request has exceeded the allocated liters.")
            $('#liters').val('')
        }
    });

    $('#mySelect').on('change',function(){ 
        var value = $(this).val();
        if(value === 'others'){
            $('#mySelect').remove()
            $('.purposes').append('<textarea name="purposes" class="form-control purposesText" id="purposesText" rows="4" cols="50" placeholder="Write your purpose/s here...">')
        }
    });
}); 
function isNumber(evt) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        return false;

    return true;
}   
</script>
@endsection