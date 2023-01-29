<?php

namespace App\Http\Controllers;

use App\Models\Branchs;
use App\Models\Players;
use App\Http\Requests\StorePlayersRequest;
use App\Http\Requests\UpdatePlayersRequest;
use App\Models\PlayersFiles;
use Illuminate\Support\Facades\File;


class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Players::with('sports')->with('branches')->paginate(10);
        return view('Dashboard.Players.index',compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branchs::get();
        return view("dashboard.Players.create",compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlayersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlayersRequest $request)
    {
//        dd($request->all());
      $player =  Players::create([
            'name'=>$request->name,
            'birth_day'=>$request->birth_day,
            'join_day'=>$request->join_date,
            'father_name'=>$request->father_name,
            'father_phone'=>$request->father_phone,
            'father_job'=>$request->father_job,
            'father_email'=>$request->father_email,
            'branch_id'=>$request->branch_id,
            'sport_id'=>$request->sport_id,
            'anther_sport'=>$request->anther_sports,
            'join_by'=>$request->join_by,
            'goal_of_sport'=>$request->goal_of_sport,
        ]);
        if($request->file){

            for($x=0;  $x < count($request->name_of_file)   ;$x++)
            {
                $media_name=$request->name_of_file[$x];
                $objfile =$request->file[$x];
                $fileName = time() . $objfile->getClientOriginalName();
                $pathFile = public_path("storage/studentsMedia");
                $objfile->move($pathFile, $fileName);
                $fileNamePath = "storage/PlayersMedia" . '/' . $fileName;
                PlayersFiles::create([
                    'player_id'=> $player->id,
                    'file_name'=>$media_name,
                    'file_path'=> $fileNamePath,
                ]);

            }

        }
        return redirect()->route('player.index')->with('message','تم اضافه اللاعب بنجاح ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Players  $players
     * @return \Illuminate\Http\Response
     */
    public function show(Players $players)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Players  $players
     * @return \Illuminate\Http\Response
     */
    public function edit(Players $player)
    {
        $branches = Branchs::get();
//        dd($player_files);
        return view("dashboard.Players.edit",compact('branches','player'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlayersRequest  $request
     * @param  \App\Models\Players  $players
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayersRequest $request, Players $player)
    {
//        dd($request->all());
        $player->name = $request->name;
        $player->birth_day = $request->birth_day;
        $player->join_day = $request->join_date;
        $player->father_name = $request->father_name;
        $player->father_phone = $request->father_phone;
        $player->father_job = $request->father_job;
        $player->father_email = $request->father_email;
        $player->branch_id = $request->branch_id;
        $player->sport_id = $request->sport_id;
        $player->anther_sport = $request->anther_sports;
        $player->join_by = $request->join_by;
        $player->goal_of_sport = $request->goal_of_sport;
        $player->save();
        if($request->file){

            for($x=0;  $x < count($request->name_of_file)   ;$x++)
            {
                $media_name=$request->name_of_file[$x];
                $objfile =$request->file[$x];
                $fileName = time() . $objfile->getClientOriginalName();
                $pathFile = public_path("storage/studentsMedia");
                $objfile->move($pathFile, $fileName);
                $fileNamePath = "storage/PlayersMedia" . '/' . $fileName;
                PlayersFiles::create([
                    'player_id'=> $player->id,
                    'file_name'=>$media_name,
                    'file_path'=> $fileNamePath,
                ]);

            }

        }
        return redirect()->route('player.index')->with('message','تم تعديل اللاعب بنجاح ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Players  $players
     * @return \Illuminate\Http\Response
     */
    public function destroy(Players $player)
    {
        PlayersFiles::where('player_id',$player->is)->delete();
        $player->delete();
        return redirect()->route('player.index')->with('error','تم حذف اللاعب مع ملفاته بنجاح ');

    }


    public function deleteFiles($id){
        $player_file = PlayersFiles::find($id);
        File::delete($player_file->file_path);
        $player_file->delete();

        return back()->with('error','تم حذف الفايل اللاعب بنجاح ');
    }
}
