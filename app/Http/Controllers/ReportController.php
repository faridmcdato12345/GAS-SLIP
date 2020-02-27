<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);
        if($application->applicant_id != null){
            $appName = $application->applicant->name;
        }
        else{
            $appName = $application->unregistered_applicant;
        }
        $deptName = $application->department->name;
        if($deptName == 0){
            $deptName = 'NO DEPARTMENT';
        }
        return response()->json(array('data'=>$application,'appname'=>$appName,'deptname'=>$deptName));
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
        $input['UP']=$request->up;
        $input['request_liters']=$request->liters;
        $application->update($input);
        return response()->json(['data'=>'Product saved successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function printReport(Request $request){
        $appDate = Application::whereBetween('created_at',[$request->startDate,$request->endDate])->where('gm_flag','=','1')->where('dm_flag','=','1')->where('gas_slip_flag','=','1')->orWhere('emergency','=','0')->orderBy('created_at','desc')->get();
        return view('report_print',compact('appDate'));
    }
    
}
