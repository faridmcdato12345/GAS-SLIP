<?php

namespace App\Http\Controllers;

use Gate;
use DataTables;
use App\Applicant;
use App\Department;
use function compact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate as IlluminateGate;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Gate::allows('superadmin',Auth::user())){
            $data = Applicant::all();
            if ($request->ajax()) {
                
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" data-placement="top" title="Edit user" class="edit btn btn-primary btn-sm editUser "><i class="fas fa-user-edit"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" data-placement="top" title="Delete user" class="btn btn-danger btn-sm deleteUser"><i class="fas fa-user-minus"></i></a>';
                            return $btn;
                        })  
                        ->rawColumns(['actions'])
                        ->make(true);
            }
            return view('admin.applicant.index',compact('data'));
        }
        return abort(403, 'You are not authorized to visit this page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::pluck('name','id')->all();
        return view('admin.applicant.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Applicant::where('name', '=', Input::get('name'))->exists()) {
            Session::flash('created_department_fail',$request['name'].' was already created');
        }
        else{
            Applicant::create($request->all());
            Session::flash('created_department',$request['name'].' has been created');
        }
        
        return redirect('admin/applicants/create');
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
        $applicant = Applicant::find($id);
        return response()->json($applicant);
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
        $applicant = Applicant::findOrFail($id);
        $applicant->update($request->all());
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
        $applicant = Applicant::find($id)->delete();
        return response()->json(['success'=>'deleted successfully.']); 
    }
}
