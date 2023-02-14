<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeesRequest;
use App\Http\Requests\UpdateEmployeesRequest;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_trainer' ,'1')->paginate(10);
        return view('Dashboard.Trainers.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard.Trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeesRequest $request)
    {
//        dd($request->all());
        $admin = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "phone2" => $request->phone2,
            "address" => $request->address,
            "is_trainer" => '1',
            "password" => bcrypt("$request->password"),
        ]);

        return redirect()->route('trainer.index')->with('message','تم اضافه المدرب بنجاح ');

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
        return view('Dashboard.Trainers.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeesRequest $request, $id)
    {
        $admin = User::find($id);
        $admin->name =  $request->name;
        $admin->email =  $request->email;
        $admin->phone =  $request->phone;
        $admin->phone2 =  $request->phone2;
        $admin->address =  $request->address;

        $admin->save();
        return redirect()->route('trainer.index')->with('message','تم تعديل المدرب بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $admin = User::find($id);
        $admin->delete();
        return redirect()->route('trainer.index')->with('error','تم حذف المدرب بنجاح ');



    }
}
