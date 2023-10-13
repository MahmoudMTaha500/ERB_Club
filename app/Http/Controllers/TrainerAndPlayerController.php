<?php

namespace App\Http\Controllers;

use App\Models\Branchs;
use App\Models\EventTrainerPlayers;
use App\Models\Players;
use App\Models\Sports;
use App\Models\Stadium;
use App\Models\TrainerAndPlayer;
use App\Http\Requests\StoreTrainerAndPlayerRequest;
use App\Http\Requests\UpdateTrainerAndPlayerRequest;
use App\Models\User;
use http\Env\Request;
use Carbon\Carbon;
class TrainerAndPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Players::get();
        $users = User::where('is_trainer' ,'1')->get();
        $sports = Sports::get();
        $branches = Branchs::get();
        $stadiums = Stadium::get();
        return  view('Dashboard.TrainerAndPlayers.index',compact('branches','stadiums'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreTrainerAndPlayerRequest $request)
    {

        if($request->ajax())
        {
            $events=[];
            $data = TrainerAndPlayer::get();
            foreach ($data as $event){

                $events[]=[
                    "id"=>$event->id,
                    'title'=> $event->stadiums->name.'. C:'.$event->traniers->name.'. S:'.$event->sports->name ,
                    'start'=>$event->time_from,
                    'end'=>$event->time_to,
                    ];

            }
            return response()->json($events);
        }
//        return  view('Dashboard.TrainerAndPlayers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainerAndPlayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainerAndPlayerRequest $request)
    {
       $day =  Carbon::parse($request->day);
     $counter = 1 ;
     $weekRepeater=0;

     $number = $request->number ? $request->number : 1;
        while($counter <= $number){
$ReceivedDay = $day->addWeeks($weekRepeater)->format('Y-m-d');
if(!$weekRepeater){$weekRepeater=1;}
            $from = $ReceivedDay." ". $request->from;
            $to = $ReceivedDay." ". $request->to;
            $event =    TrainerAndPlayer::create([
                'stadium_id'=>$request->stadium_id,
                'trainer_id'=>$request->user_id,
                'sport_id'=>$request->sport_id,
                'level_id'=>$request->level_id,
                'date'=>$ReceivedDay,
                'time_from'=>$from,
                'time_to'=>$to,
                'number'=>$number,
            ]);
            foreach ($request->player_id as $player ){
                EventTrainerPlayers::create([
                    'player_id'=>$player,
                    'event_id'=>$event->id,
                ]);
            }
$counter++;

     }
        $data = TrainerAndPlayer::get();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function show(TrainerAndPlayer $trainerAndPlayer,StoreTrainerAndPlayerRequest $request)
    {

        if($request->ajax())
        {
            $events=[];
            $data = TrainerAndPlayer::with('stadiums')->with('traniers')
                ->with('EventTrainer.players')
                ->where('id',$request->id)->get();
//            dd($data);
            $players='';
            $stadium_name ='';
            $trainer_name ='';
                $stadium_name = $data[0]->stadiums->name;
                $trainer_name= $data[0]->traniers->name;
                $name='';
                foreach ($data[0]->EventTrainer as $ev){
                    $name = $ev->players->name;
                    $players .= "<tr> <td> $name</td></tr>";

                }

            return response()->json(['players'=>$players,'stadium_name'=>$stadium_name,'trainer_name'=>$trainer_name]);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainerAndPlayer $trainerAndPlayer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainerAndPlayerRequest  $request
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTrainerAndPlayerRequest $request, TrainerAndPlayer $trainerAndPlayer)
    {
        $event = TrainerAndPlayer::find($request->id);
        $event->time_from =$request->start;
        $event->time_to =$request->end;
        $event->save();
        return response()->json($event);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreTrainerAndPlayerRequest $request)
    {
        $event = TrainerAndPlayer::find($request->id);
        EventTrainerPlayers::where('event_id',$request->id)->delete();
        $event->delete();

    }
}
