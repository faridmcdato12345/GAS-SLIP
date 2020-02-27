<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use App\Application;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Events\CashierNotice;
use App\Events\OrderStatusChanged;
use App\GmDisapproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(Auth::check()){
            if(Auth::user()->superAdmin()){
                return redirect('admin/users');
            }
            if(Auth::user()->role_id == 2){
                $data = Application::all();
                return view('home',compact('data'));
            }
            if(Auth::user()->role_id == 3){
                return view('department_manager');
            }
            if(Auth::user()->role_id == 4){
                return view('general_manager');
            }
        }
    }
    public function getReportDate(Request $request){
        $appDate = Application::whereBetween('created_at',[$request->startDate,$request->endDate])->where('gm_flag','=','1')->where('dm_flag','=','1')->where('gas_slip_flag','=','1')->orWhere('emergency','=','0')->orderBy('created_at','desc')->get();
        return view('report',compact('appDate'));
    }
    public function getDmapplication(Request $request){
        $departmentId = Auth::user()->department_id;
        $dmapplication = Application::where('dm_flag','=','0')->where('emergency','=','0')->where('department_id','=',$departmentId)->get();
        if ($request->ajax()) {
                
            return Datatables::of($dmapplication)
                    ->addIndexColumn()
                    ->editColumn('applicant_id', function($row){
                        $applicantName = DB::table('applicants')->where('id',$row->applicant_id)->value('name');
                        return $applicantName;
                    })
                    ->editColumn('department_id', function($row){
                        $departmentName = DB::table('departments')->where('id',$row->department_id)->value('name');
                        return $departmentName;
                    })
                    ->addColumn('actions', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" data-placement="top" title="Approve" class="edit btn btn-primary btn-sm approveApp" id="approveApp"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" data-placement="top" title="Disapprove" class="btn btn-danger btn-sm disapproveApp"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></a>';
                        return $btn;
                    })  
                    ->rawColumns(['actions'])
                    ->make(true); 
        }
        return view('department_manager',compact('dmapplication'));
    }
    public function approve($id){
        $user = Application::findOrFail($id);
        $user->dm_flag = '1';
        $user->save();
        event(new NewMessage($user));
        return response()->json(['success'=>'status updated.']);
    }
    public function disapprove($id){
        $user = Application::findOrFail($id);
        $user->dm_flag = '2';
        $user->save();
        return response()->json(['success'=>'status updated.']);
    }
    public function gmapprove($id){
        $user = Application::findOrFail($id);
        $user->gm_flag = '1';
        $user->save();
        event(new CashierNotice($user));
        return response()->json(['success'=>'status updated.']);
    }
    public function gmdisapprove($id, Request $request){
        $user = Application::findOrFail($id);
        $user->update($request->all());
        event(new OrderStatusChanged($user));
        return response()->json(['success'=>'update success!']);
    }
    public function getGmApplication(Request $request){
        $gmapplication = Application::where('dm_flag','=','1')->where('gm_flag','=','0')->orderBy('created_at','desc')->get();
        if ($request->ajax()) {
            return Datatables::of($gmapplication)
                    ->addIndexColumn()
                    ->editColumn('applicant_id', function($row){
                        $applicantName = DB::table('applicants')->where('id',$row->applicant_id)->value('name');
                        return $applicantName;
                    })
                    ->editColumn('department_id', function($row){
                        $departmentName = DB::table('departments')->where('id',$row->department_id)->value('name');
                        return $departmentName;
                    })
                    ->addColumn('actions', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" data-placement="top" title="Approve" class="edit btn btn-primary btn-sm approveApp" id="approveApp"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" data-placement="top" title="Disapprove" class="btn btn-danger btn-sm disapproveApp"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></a>';
                        return $btn;
                    })  
                    ->rawColumns(['actions'])
                    ->make(true); 
        }
        return view('department_manager',compact('gmapplication'));
    }
    public function getGmApplicationDisapprove(Request $request){
        $departmentId = Auth::user()->department_id;
        $gmapplication = Application::where('gm_flag','=','2')->orderBy('created_at','desc')->where('department_id','=',$departmentId)->get();
        if ($request->ajax()) {
            return Datatables::of($gmapplication)
                    ->addIndexColumn()
                    ->editColumn('applicant_id', function($row){
                        $applicantName = DB::table('applicants')->where('id',$row->applicant_id)->value('name');
                        return $applicantName;
                    })
                    ->editColumn('department_id', function($row){
                        $departmentName = DB::table('departments')->where('id',$row->department_id)->value('name');
                        return $departmentName;
                    })
                    ->addColumn('actions', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" data-placement="top" title="Edit user" class="edit btn btn-primary btn-sm approveApp" id="approveApp"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" data-placement="top" title="Delete user" class="btn btn-danger btn-sm disapproveApp"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></a>';
                        return $btn;
                    })  
                    ->rawColumns(['actions'])
                    ->make(true); 
        }
        return view('applicant_disapproved',compact('gmapplication'));
    }
    public function gasSlip(Request $request){
        $gmapplication = Application::where('dm_flag','=','1')->where('gm_flag','=','1')->where('gas_slip_flag','=','0')->where('emergency','0')->orderBy('created_at','desc')->get();
        return view('gas_slip',compact('gmapplication'));
    }
    public function gas_slip_get_info(Request $request){
        $gas_slip = Application::findOrFail($request->id);
        $input['gas_slip_flag'] = '1';
        $gas_slip->update($input);
        $gas_slip = Application::where('id','=',$request->id)->get();
        $departmentManager = User::where('department_id',$gas_slip[0]->department_id)->where('role_id','=','3')->get();
        $dmName = $departmentManager[0]->name;
        $signature = $departmentManager[0]->signature->path;
        return view('gas_slip_print',compact('gas_slip','dmName','signature'));
    }
}
