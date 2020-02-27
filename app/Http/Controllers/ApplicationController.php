<?php

namespace App\Http\Controllers;

use Gate;
use App\User;
use DataTables;
use App\Applicant;
use Carbon\Carbon;
use App\Department;

use App\Application;
use function compact;
use Illuminate\Http\Request;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Notifications\ApproveNotification;
use Illuminate\Support\Facades\Gate as IlluminateGate;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $d = array();
    private $o;
    public function index(Request $request)
    {
        // dd($this->getWeekday(date("Y-m-d")));
        $theDate = $this->getWeekday(date("Y-m-d"));
        if($theDate > 5 || $theDate == 0){
            abort(404);
        }
        $applicant = Applicant::pluck('name','id')->all();
        $department = Department::pluck('name','id')->all();
        return view('application.index',compact('applicant','department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        date_default_timezone_set("Asia/Manila");
        $date = date("Y-m-d");
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $timeNow = date("H:i:s");
        $time = str_replace(":","",$timeNow);
        $controlNumber = $month.$day;
        $applicantLiters = Applicant::findOrFail($request->applicant_id);
        $input['request_liters']=$applicantLiters->liters;
        $input['applicant_id']=$request->applicant_id;
        $input['department_id']=$request->department_id;
        $input['destination']=$request->destination;
        $input['purposes']=$request->purposes;
        $input['personnel']=$request->personnel;
        $input['weekly_trigger']='1';
        $input['UP']= 0;
        $input['control_number'] = $year."-".$controlNumber."-".$time;
        $department = Department::where('id',$request->department_id)->get();
        $userPerDepartment = User::where('department_id',$request->department_id)->get();
        Application::create($input);
        $application_id = Application::latest()->first()->id;
        $application = Application::where('id','=',$application_id)->get();
        $id = Application::latest()->first();
        event(new OrderStatusChanged($id));
        Session::flash('created_user','Your request is submitted.');
        return redirect('applications');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::find($id);
        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->update($request->all());
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $application = Application::find($id)->delete();
        return response()->json(['success'=>'deleted successfully.']);
    }
    public function showApplicant($id){
        $applicant = Applicant::findOrFail($id);
        $date = date('F jS, Y');
        return response()->json(array('vehicle'=>$applicant->vehicle,'date'=>$date,'liters'=>$applicant->liters,'department_id'=>$applicant->department_id),200);
    }
    public function getApplicant($id){
        $o = array();
        $sumZ = array();
        if(Application::where('applicant_id','=',$id)->exists()){
            $dates = $this->getWeekday(date("Y-m-d"));
            for($i=0;$i<$dates;$i++){
                array_push($o,date('Y-m-d',strtotime("-".$i." days")));    
            }
            for($z=0;$z<count($o);$z++){
                array_push($sumZ,Application::whereDate('created_at','=',$o[$z])->where('applicant_id','=',$id)->sum('weekly_trigger'));
            }
            $sumTotal = array_sum($sumZ);
            $a = Application::where('applicant_id',$id)->sum('weekly_trigger');
            $wTrigger = Applicant::where('id','=',$id)->value('weekly_consumption');
            if($sumTotal < $wTrigger ){
                return response()->json(array('message'=>'can proceed','data'=>$a,'o'=>$o,'w'=>$wTrigger,'sum'=>$sumTotal),200);
            }
            else{
                return response()->json(array('message'=>'forbidden request'),403); 
            }
        }
        else{
            return response()->json(array('message'=>'forbidden request'),404);
        }
    }
    private function getWeekday($date) {
        return date('w', strtotime($date));
    }
    private function compareDate($d,$id){
        $applicationDate = Application::whereIn('created_at',json_encode($this->d))->where('id',$id)->value('');
    }
}
