<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\File;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_trainer','0')->latest('id')->paginate(10);
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
//        dd($request->all());
        $fileNamePath="";
        if($request->hasFile('image')){
            $objFile =$request->image;
            $fileName = time() . $objFile->getClientOriginalName();
            $pathFile = public_path("storage/employee/images");
            $objFile->move($pathFile, $fileName);
            $fileNamePath = "storage/employee/images" . '/' . $fileName;
        }

        $admin = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt("$request->password"),
            "birth_day" => $request->birth_day,
            "national_id" => $request->national_id,
            "degree" => $request->degree,
            "military_status" => $request->military_status,
            "image" => $fileNamePath,

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
        $admin->birth_day =  $request->birth_day;
        $admin->national_id =  $request->national_id;
        $admin->degree =  $request->degree;
        $admin->military_status =  $request->military_status;

        $fileNamePath="";
        if($request->hasFile('image')){
        File::delete($admin->image);

            $objFile =$request->image;
            $fileName = time() . $objFile->getClientOriginalName();
            $pathFile = public_path("storage/employee/images");
            $objFile->move($pathFile, $fileName);
            $fileNamePath = "storage/employee/images" . '/' . $fileName;
            $admin->image =  $fileNamePath;

        }

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
