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
<div style="padding-top:15%;padding-bottom:5%;text-align:center;"><h5>As of <span id="minDate"></span> to <span id="maxDate"></span></h5></div>
<table id="myTable" class="table-bordered table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>CONTROL NUMBER</th>
            <th>DATE</th>
            <th>APPLICANT NAME</th>
            <th>REQUESTED LITER</th>
            <th>U/P</th>
            <th>AMOUNT</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody multiple>
        @foreach ($appDate as $user)
            <tr>
                <td>{{ $user->control_number }}</td>
                <td>{{ $user->created_at }}</td>
                @if($user->applicant_id != null)
                    <td>{{ $user->applicant->name }}</td>
                @else
                    <td>{{ $user->unregistered_applicant}}</td>
                @endif
                <td>{{ $user->request_liters }}</td>
                <td>{{ $user->UP }}</td>
                <td class="amount">{{ $user->request_liters * $user->UP}}</td>
                <td></td>
            </tr>
        @endforeach
            <tr>
                <td><strong>OVER ALL TOTAL</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="total" style="font-weight:bold;"></td>
            </tr>
    </tbody>
    
</table>
<div style="display:flex;margin-top:50px;">
    <div style="flex:auto;width:50%;">
        <p>Prepared by:</p>
        <div style="height:20px;">
        </div>
        <div style="text-align:center">
            <span class="name"><strong>{{Auth::user()->name}}</strong></span>
            <br>
            <span>Employee</span>
        </div>
    </div>
    <div style="flex:auto;width:50%;">
        <p>Checked by:</p>
        <div style="height:20px;">

        </div>
        <div style="text-align:center">
            <span class="name"><strong>SOHAYA D. MARANGIT, CPA</strong> </span>
            <br>
            <span>Department Manager, Finance Services</span>
        </div>
    </div>
</div>
<div style="display:flex;margin-top:50px;">
    <div style="flex:auto;width:50%;">
        <p>Audited by:</p>
        <div style="height:20px;">

        </div>
        <div style="text-align:center">
            <span class="name">SAMSIA G. ALI</span>
            <br>
            <span>Internal Audit</span>
        </div>
    </div>
    <div style="flex:auto;width:50%;">
        <p>Approved by:</p>
        <div style="height:20px;">

        </div>
        <div style="text-align:center">
            <span class="name">NORDJIANA L. DIPATUAN-DUCOL, DPA</span>
            <br>
            <span>GENERAL MANAGER</span>
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
        var daterange = localStorage.getItem('daterange');
        var array_date = JSON.parse(daterange);
        $('#minDate').text(array_date[0])
        $('#maxDate').text(array_date[1])
        $('.total').text("P "+TotalValue.toLocaleString("en-US"))
        window.print()
        
    })
    window.onafterprint = function() {
        history.go(-1);
    };
</script>
@endsection