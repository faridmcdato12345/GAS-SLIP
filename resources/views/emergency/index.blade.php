@extends('layouts.app')
@section('content')
<cashierapplication-alert department_id="{{auth()->user()->department_id}}"></cashierapplication-alert>
{!! Form::open(['method'=>'POST','action'=>'gasSlipController@store','files'=>true]) !!}
<div class="form-group registered_applicant">
    {!! Form::label('applicant','Applicant:') !!}
    {!! Form::select('applicant_id',$applicant ,null,['class'=>'form-control','placeholder'=>'Click to choose applicants...']) !!}
</div>
<div class="form-group unregistered_applicant" style="display:none;">
    {!! Form::label('unregistered_applicant','Unregistered Applicant:') !!}
    {!! Form::text('unregistered_applicant',null,['class'=>'form-control','placeholder'=>'Write the name here..']) !!}
</div>
<button type="button" class="unregistered_btn btn btn-success form-control" id="unregistered_btn" style="margin-top:1%">Unregistered Applicant</button>
<button type="button" class="registered_btn btn btn-success form-control" id="registered_btn" style="margin-top:1%;display:none;">Registered Applicant</button>
<div class="form-group">
    {!! Form::label('department','Department:') !!}
    {!! Form::select('department_id',$departments ,null,['class'=>'form-control department','placeholder'=>'Click to choose departments...']) !!}
</div>
<div class="form-group">
    {!! Form::label('liters','Liters:') !!}
    {!! Form::text('liters',null,['class'=>'form-control']) !!}
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
    {!! Form::submit('SAVE',['class'=>'form-control btn btn-primary']) !!}
</div>
{!! Form::close() !!}
@endsection
@section('datatable-script')
<script type="text/javascript">
    $(document).ready(function(){
        $('.unregistered_btn').click(function(){
            
            $('.unregistered_applicant').css('display','block');
            $('.registered_applicant').css('display','none');
            $('#registered_btn').css('display','block');
            $('#unregistered_btn').css('display','none');
        })
        $('.registered_btn').click(function(){
            $('.unregistered_applicant').css('display','none');
            $('.registered_applicant').css('display','block');
            $('#registered_btn').css('display','none');
            $('#unregistered_btn').css('display','block');
        })
        $('#mySelect').on('change',function(){ 
            var value = $(this).val();
            if(value === 'others'){
                $('#mySelect').remove()
                $('.purposes').append('<textarea name="purposes" class="form-control purposesText" id="purposesText" rows="4" cols="50" placeholder="Write your purpose/s here...">')
            }
        });
        
    })
</script>
@endsection