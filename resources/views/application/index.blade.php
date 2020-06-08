@extends('layouts.application')
@section('content')
@if(Session::has('created_user'))
<p class="bg-success success-box" style="font-weight: bold;font-size: 16px;padding: 10px 10px;">{{session('created_user')}}</p>
@endif
<div>
    <div>
        <h1><strong>APPLICANT NAME</strong></h1>
        <div class="form-group">
            <div class="col-sm-offset-2">
                {!! Form::select('user_id',$applicant ,null,['class'=>'form-control user','placeholder'=>'Click to choose applicant...']) !!}
            </div>
        </div>
    </div>
    <div>
        <h1><strong>DEPARTMENT</strong></h1>
        <div class="form-group">
            <div class="col-sm-offset-2">
                {!! Form::select('department_id',$department ,null,['class'=>'form-control department','placeholder'=>'Click to choose department...']) !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <div class="modal-dialog">
        <div class="modal-content" style="background:red;color:white;">
            <div class="modal-body">
                <div style="text-align:center;">
                    <h1 style="font-size:18px;">You have already consumed all your allocated gasoline for this week. Sorry, you can re-apply next week.</h1>
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('datatable-script')
<script type="text/javascript"> 
    $(function () {
        if($('.success-box').length>0){
            setInterval(function(){ $('.success-box').css('display','none'); }, 3000);
        }
        var userId = ''
        var deptId = ''
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      var rLiters='';
      var aLiter = '';
      $('.department').on('change', function() {
        deptId = $('.department').val()
      });
        $('.user').on('change', function() {
            var z = '0';
            var url = "{{route('applications.getApplicant',':id')}}";
            url = url.replace(':id',this.value);
            userId = this.value;
            deptId = $('.department').val();
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (data) {
                    console.log(data.sum)
                    console.log(data.o)
                    contentAppend()
                },
                error: function (data) {
                    if(data.status == 404){
                        contentAppend()
                    }
                    else if(data.status == 403){
                        $('.removable').remove();
                        $('#ajaxModel').modal('show');
                    }
                }
            });
        });
        $('.content').on('click','.updateBtn',function(){
            var url = "{{route('applications.create')}}"
            localStorage.setItem("savedData", JSON.stringify([userId,deptId,rLiters]));
            window.location.replace(url);
        });
        function contentAppend(){
            if($('.removable').length>0){
                $('.removable').remove();
            }
            return $('.content').append("<div class='col-sm-offset-2 removable'><a href='#' class='btn btn-primary form-control updateBtn' id='updateBtn'>NEXT</a></div>");
        }
    });
    
  </script>
@endsection