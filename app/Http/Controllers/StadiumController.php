<?php

namespace App\Http\Controllers;

use App\Models\Branchs;
use App\Models\Sports;
use App\Models\Stadium;
use App\Http\Requests\StoreStadiumRequest;
use App\Http\Requests\UpdateStadiumRequest;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $stadiums = Stadium::paginate(10);
        return view('Dashboard.Stadiums.index', compact('stadiums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branchs::get();

        return view('Dashboard.Stadiums.create', compact('branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreStadiumRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStadiumRequest $request)
    {
//        dd($request->all());
        Stadium::create(
            [
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'type' => $request->type,
                'hour_rate' => $request->hour_rate
            ]);
        return redirect()->route('stadium.index')->with('message','تم اضافه الملعب ');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Stadium $stadium
     * @return \Illuminate\Http\Response
     */
    public function show(Stadium $stadium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Stadium $stadium
     * @return \Illuminate\Http\Response
     */
    public function edit(Stadium $stadium)
    {
        $branches = Branchs::get();


        return view('Dashboard.Stadiums.edit',compact('stadium','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateStadiumRequest $request
     * @param \App\Models\Stadium $stadium
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStadiumRequest $request, Stadium $stadium)
    {
        Stadium::where('id',$stadium->id)->update(
            [
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'type' => $request->type,
                'hour_rate' => $request->hour_rate
            ]);
        return redirect()->route('stadium.index')->with('message','تم تعديل الملعب ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Stadium $stadium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stadium $stadium)
    {
        $stadium->delete();
        return redirect()->route('stadium.index')->with('message','تم حذف الملعب ');

    }

    /**
     * Get  the Stadiums for the calendar
     *
     * @param \App\Models\Stadium $stadium
     * @return \Illuminate\Http\Response
     */
    public function getStadiums(Request $request){

        $stadiums = Stadium::where('branch_id',$request->branch_id)->get();
        $option  = "
      <option value=0  >اختر الملعب   </option> ";
        foreach ($stadiums as  $stadium){
            $option .= "
      <option value=$stadium->id  > $stadium->name </option> ";

        }
        return     \Response::json(['data'=>$option])  ;

    }
}
