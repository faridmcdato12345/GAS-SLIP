<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepartmentPosition;
use Gate;
use App\Role;
use App\Signature;
use App\User;
use DataTables;
use function compact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate as IlluminateGate;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Gate::allows('superadmin',Auth::user())){
            $data = User::where('id', '!=', '1')->get();
            if ($request->ajax()) {
                
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->editColumn('role_id', function($row){
                            $roleName = DB::table('roles')->where('id',$row->role_id)->value('name');
                            return $roleName;
                        })
                        ->editColumn('department_id', function($row){
                            $departmentName = DB::table('departments')->where('id',$row->department_id)->value('name');
                            return $departmentName;
                        })
                        ->addColumn('status', function($row){
                            if($row->is_active == 1){
                                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm userActive disabled">Active</a>';
                                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm userInActive">In Active</a>';
                            }
                            else{
                                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm userActive">Active</a>';
                                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm userInActive disabled">In Active</a>';
                            }
                            
                            return $btn;
                        })  
                        ->addColumn('actions', function($row){
    
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" data-placement="top" title="Edit user" class="edit btn btn-primary btn-sm editUser "><i class="fas fa-user-edit"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" data-placement="top" title="Delete user" class="btn btn-danger btn-sm deleteUser"><i class="fas fa-user-minus"></i></a>';
    
                            return $btn;
                        })  
                        ->rawColumns(['status','actions'])
                        ->make(true); 
            }
            $role = Role::pluck('name','id')->all();
            $departments = Department::pluck('name','id')->all();
            return view('admin.users.index',compact('data','role','departments'));
        }
        return abort(403, 'You are not authorized to visit this page');
    }
    public function create()
    {
        $roles = Role::pluck('name','id')->all();
        $departments = Department::pluck('name','id')->all();
        $randompassword =  Hash::make(str_random(8));
        return view('admin.users.create',compact('roles','randompassword','departments'));
    }
    public function store(Request $request)
    {
            
        if(trim($request->password) == ''){
            $request->except('password');
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        if($file = $request->file('signature_id')){
            $name = time().$file->getClientOriginalName();
            $file->move('img',$name);
            $photo = Signature::create(['path'=>$name]);
            $input['signature_id']=$photo->id;
        }
        User::create($input);
        Session::flash('created_user',$input['name'].' has been created');
        return redirect('admin/users/create');
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
        $user = User::find($id);
        return response()->json($user);
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
        $user = User::findOrFail($id);
        $role_id = DB::table('roles')->where('id',$request->role_id)->value('id');
        $input['role_id'] = $role_id;
        $input = $request->all();
        $user->update($input);
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
        $user = User::find($id)->delete();
        return response()->json(['success'=>'deleted successfully.']); 
    }
    public function isActive($id){
        $user = User::find($id);
        $user->is_active = '1';
        $user->save();
        return response()->json(['success'=>'status updated.']);
    }
    public function inActive($id){
        $user = User::find($id);
        $user->is_active = '0';
        $user->save();
        return response()->json(['success'=>'status updated.']);
    }
}
