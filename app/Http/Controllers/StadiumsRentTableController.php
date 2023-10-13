<?php

namespace App\Http\Controllers;

use App\Models\EventTrainerPlayers;
use App\Models\Players;
use App\Models\Sports;
use App\Models\Stadium;
use App\Models\StadiumRentCancellations;
use App\Models\StadiumsRentTable;
use App\Http\Requests\StoreStadiumsRentTableRequest;
use App\Http\Requests\UpdateStadiumsRentTableRequest;
use App\Models\TrainerAndPlayer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StadiumsRentTableController extends Controller
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
        $stadiums = Stadium::where('type','1')->get();
        return  view('Dashboard.StadiumsRentTables.index',compact('players','users','sports','stadiums'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreStadiumsRentTableRequest $request)
    {
        if($request->ajax())
        {
            $events=[];
            $data = StadiumsRentTable::get();
            $type = '';
            foreach ($data as $event){
                if($event->type == 'trainer'){
                    $type = 'C:';
                }  else{
                    $type = 'MR:';

                }
                $events[]=[
                    "id"=>$event->id,
                    'title'=> $event->stadiums->name. $type .$event->name.'. P:'.$event->price ,
                    'start'=>$event->time_from,
                    'end'=>$event->time_to,
                ];

            }
            return response()->json($events);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStadiumsRentTableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStadiumsRentTableRequest $request)
    {
        $day =  Carbon::parse($request->day);
        $counter = 1 ;
        $weekRepeater=0;

        $number = $request->number ? $request->number : 1;

        while($counter <= $number) {
            $ReceivedDay = $day->addWeeks($weekRepeater)->format('Y-m-d');
            if(!$weekRepeater){$weekRepeater=1;}

            $from = $ReceivedDay . " " . $request->from;
            $to = $ReceivedDay . " " . $request->to;
            $name = $request->name;
            $type = 'strange';
            if ($request->user_id) {
                $user = User::find($request->user_id);
                $name = $user->name;
                $type = 'trainer';

            }

            $event = StadiumsRentTable::create([
                'stadium_id' => $request->stadium_id,
                'user_id' => $request->user_id,
                'name' => $name,
                'type' => $type,
                'date' => $request->day,
                'price' => $request->hour_rate,
                'time_from' => $from,
                'time_to' => $to,
                'number' => $number,
            ]);
            $counter++;

        }
        $data = StadiumsRentTable::get();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StadiumsRentTable  $stadiumsRentTable
     * @return \Illuminate\Http\Response
     */
    public function show(StadiumsRentTable $stadiumsRentTable,StoreStadiumsRentTableRequest $request)
    {

        if($request->ajax())
        {
            $events=[];
            $data = StadiumsRentTable::with('stadiums')
                ->where('id',$request->id)->get();
            $type = '';

                if($data[0]->type == 'trainer'){
                    $type = 'كابتن';
                }  else{
                    $type = 'مستاحر';

                }
                $stadium = $data[0]->stadiums->name;
                $name = $data[0]->name;
                $price = $data[0]->price;


            $html =<<<line
     <tr>
                                                    <th class="text-nowrap" scope="row">الملعب</th>
                                                    <td colspan="5">$stadium</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">السعر</th>
                                                    <td colspan="5">$price</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">اسم صاحب الحجز </th>
                                                    <td colspan="5">$name</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap" scope="row">كابتن او مستاجر</th>
                                                    <td colspan="5">$type</td>
                                                </tr>
line;

            return response()->json(["html"=>$html]);

//            return response()->json(['players'=>$players,'stadium_name'=>$stadium_name,'trainer_name'=>$trainer_name]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StadiumsRentTable  $stadiumsRentTable
     * @return \Illuminate\Http\Response
     */
    public function edit(StadiumsRentTable $stadiumsRentTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStadiumsRentTableRequest  $request
     * @param  \App\Models\StadiumsRentTable  $stadiumsRentTable
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStadiumsRentTableRequest $request, StadiumsRentTable $stadiumsRentTable)
    {
        $event = StadiumsRentTable::find($request->id);
        $event->time_from =$request->start;
        $event->time_to =$request->end;
        $event->save();
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StadiumsRentTable  $stadiumsRentTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(StadiumsRentTable $stadiumsRentTable,StoreStadiumsRentTableRequest $request)
    {
//        dd($request->all());
        $StadiumRentCancellations = new StadiumRentCancellations();

        $event = StadiumsRentTable::find($request->id);

        $StadiumRentCancellations->stadium_id =$event->stadium_id;
        $StadiumRentCancellations->user_id =$event->user_id;
        $StadiumRentCancellations->name =$event->name;
        $StadiumRentCancellations->type =$event->type;
        $StadiumRentCancellations->price =$event->price;
        $StadiumRentCancellations->date =$event->date;
        $StadiumRentCancellations->time_from =$event->time_from;
        $StadiumRentCancellations->time_to =$event->time_to;

        $StadiumRentCancellations->from_who =$request->from_who;
        $StadiumRentCancellations->reason =$request->reason;

        $StadiumRentCancellations->save();




        $event->delete();
    }
}
