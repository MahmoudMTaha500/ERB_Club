<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest('id')->paginate(10);
//        dd($users);
        return view('Dashboard.Employees.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard.Employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt("$request->password"),
        ]);
        if($request->role =="admin"){
            $admin->attachRole($request->role);
        } else{
            $admin->attachRole($request->role);
            $admin->attachPermissions($request->permession);
        }
        return redirect()->route('employee.index')->with('message','تم اضافه المؤظف بنجاح ');

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
        $user=User::find($id);
        return view('Dashboard.Employees.edit',compact('user'));

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
        $admin = User::find($id);
        $admin->name =  $request->name;
        $admin->email =  $request->email;
        if($request->password){
            $admin->password =  bcrypt("$request->password");
        }
        if($request->role =="admin"){
            $per = \DB::table('permission_user')->where('user_id',$id)->delete();
            $role = \DB::table('role_user')->where('user_id',$id)->delete();
            $admin->attachRole($request->role);
        } else{
            $role = \DB::table('role_user')->where('user_id',$id)->delete();
            $per = \DB::table('permission_user')->where('user_id',$id)->delete();
            $admin->attachRole($request->role);
            $admin->attachPermissions($request->permession);
        }
        $admin->save();
        return redirect()->route('employee.index')->with('message','تم تعديل المؤظف بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = \DB::table('role_user')->where('user_id',$id)->delete();
        $per = \DB::table('permission_user')->where('user_id',$id)->delete();
        $admin = User::find($id);
$admin->delete();
        return redirect()->route('employee.index')->with('error','تم حذف المؤظف بنجاح ');



    }
}
