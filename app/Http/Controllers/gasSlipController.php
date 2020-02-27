<?php

namespace App\Http\Controllers;

use App\User;
use App\Applicant;
use App\Department;
use App\Application;
use Illuminate\Http\Request;

class gasSlipController extends Controller
{
    public function getSlipInfo(Request $request){
        $gas_slip = Application::where('dm_flag','=','1')->where('gm_flag','=','1')->where('gas_slip_flag','=','0')->orderBy('created_at','desc')->get();
        return view('gas_slip',compact('gmapplication'));
    }
    public function store(Request $request){
        date_default_timezone_set("Asia/Manila");
        $date = date("Y-m-d");
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $timeNow = date("H:i:s");
        $time = str_replace(":","",$timeNow);
        $controlNumber = $month.$day;
        $input['request_liters']=$request->liters;
        if($request->unregistered_applicant != null){
            $input['unregistered_applicant'] = $request->unregistered_applicant;
        }
        $input['applicant_id']=$request->applicant_id;
        $input['department_id']=$request->department_id;
        $input['purposes']=$request->purposes;
        $input['personnel']=$request->personnel;
        $input['emergency']='2';
        $input['weekly_trigger']='0';
        $input['UP']= 0;
        $input['dm_flag']= 1;
        $input['gm_flag']= 1;
        $input['control_number'] = $year."-".$controlNumber."-".$time;
        Application::create($input);
        $gas_slip = Application::where('emergency','=','2')->get();
        return view('emergency/gas_slip_show',compact('gas_slip'));
    }
    public function index(){
        $applicant = Applicant::pluck('name','id')->all();
        $departments = Department::pluck('name','id')->all();
        return view('emergency.index',compact('departments','applicant'));
    }
    public function update($id){
        $application = Application::findOrFail($id);
        $input['emergency']='0';        
        $application->update($input);
        return response()->json(['data'=>'Product saved successfully.']);
    }
    public function gas_slip_get_info(Request $request){
        $application = Application::findOrFail($request->id);
        $input['emergency'] = '0';
        $application->update($input);
        $gas_slip = Application::where('id','=',$request->id)->get();
        $departmentManager = User::where('department_id',$gas_slip[0]->department_id)->where('role_id','=','3')->get();
        $dmName = $departmentManager[0]->name;
        $signature = $departmentManager[0]->signature->path;
        return view('gas_slip_print',compact('gas_slip','dmName','signature'));
    }
}
