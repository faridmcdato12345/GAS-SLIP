@extends('layouts.report_layout')
@section('content')
<div>
    <div style="float:left;width:10%;"><img src="{{asset('img/logo.gif')}}" alt="lasureco logo" style="width: 100%;"></div>
    <div style="float:right;width:90%;padding-left:1%;">
        <h3>LANAO DEL SUR ELECTRIC COOPERATIVE, INC.</h3>
        <h5>Satellite Office, Provincial Capitol Complex, Marawi City 9700</h5>
        <span><a href="">teamlasureco@ymail.com</a></span>
    </div>
</div>
<div style="padding-top:10%;padding-bottom:1%;text-align:center;font-weight:bolder"><h5 style="font-weight:bolder;font-size:32px;">ORDER/GAS SLIP</h5></div>
<table id="myTable" class="table-bordered table" cellspacing="0" width="100%">
    <tbody multiple>
        @foreach ($gas_slip as $user)
            <tr>
                <td><strong>TO: C & D PETRON</strong></td>
                <td><strong>CONTROL NO.: {{ $user['control_number'] }}</strong></td>
            </tr>
            <tr>
                @if($user->applicant_id != null )
                    <td>{{ $user->applicant->name }}</td>
                @else
                    <td>{{ $user->unregistered_applicant }}</td>
                @endif
                <td><strong>DATE:</strong> {{ $user->created_at }}</td>
            </tr>
            <tr>
                @if($user->applicant_id != null )
                    <td><strong>DEPARTMENT:</strong> {{ $user->applicant->department->name }}</td>
                    <td>{{ $user->applicant->vehicle }}</td>
                @else
                    <td> </td>
                    <td> </td>
                @endif
            </tr>
            <tr>
                <td><strong>LITER/S:</strong> {{ $user->request_liters }}</td>
                <td>GASOLINE( )  DIESEL( )  UNLEADED( )</td>
            </tr>
            <tr>
                <td colspan="3"><strong>PURPOSE/MISSION/PLACE:</strong> {{ $user->purposes }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="container">
    <div class="row">
      <div class="col-sm">
        <p>Requested by:</p>
        <div style="height:20px;position:relative;">
            <hr>
        </div>
        <div style="text-align:center">
            @foreach ($gas_slip as $user)
                @if($user->applicant_id != null )
                    <span class="name"><strong>{{ $user->applicant->name }}</strong></span>
                @else
                    <span class="name"><strong>{{ $user->unregistered_applicant }}</strong></span>
                @endif
           
            @endforeach
            <br>
            <span>Print name & Signature <br> Employee</span>
        </div>
      </div>
      <div class="col-sm">
        <p>Recommended by:</p>
        <div style="height:20px;position:relative;">
            @if($signature != null)
            <img src="{{asset('img/'.$signature.'')}}" alt="signature" style="top:-30px;width:50%;display:block;position:relative;margin:0 auto;">
            @endif
            <hr>
        </div>
        <div style="text-align:center">
            <span class="name"><strong>{{$dmName}}</strong></span>
            <br>
            <span>Print name & Signature <br> Department Manager</span>
        </div>
      </div>
      <div class="col-sm">
        <p>Checked by:</p>
        <div style="height:20px;position:relative;">
            <hr>
        </div>
        <div style="text-align:center">
            <span class="name"></span>
            <br>
            <span>Print name & Signature</span>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-sm" style="text-align:center;position:relative;">
            <img src="{{asset('img/gm-signature.png')}}" alt="gm-signature" style="width: 22%;text-align: center;position: relative;top:30px;">
            <h5 style="font-width:bolder;text-decoration:underline;"><strong>NORDJIANA L. DIPATUAN-DUCOL, DPA</strong></h5><span>General Manager</span>
        </div>
    </div>
  </div>
<script type="text/javascript">
    $(document).ready(function(){
        var TotalValue = 0;
        $("table tr").each(function(){
            var checkNum = parseFloat($(this).find('.amount').text())
            if(isNaN(checkNum)){
                checkNum = 0;
            }
            else{
                TotalValue += parseFloat($(this).find('.amount').text());
            } 
        });
        if (localStorage.getItem("daterange") != null) {
            var daterange = localStorage.getItem('daterange');
            var array_date = JSON.parse(daterange);
            $('#minDate').text(array_date[0])
            $('#maxDate').text(array_date[1])
        }
        $('.total').text("P "+TotalValue.toLocaleString("en-US"))
        window.print()
        
    })
    window.onafterprint = function() {
        window.location = '/';
    };
</script>
@endsection