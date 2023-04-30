<?php

namespace App\Http\Controllers;

use App\Models\Tournaments;
use App\Models\TournamentSubscriptions;
use App\Http\Requests\StoreTournamentSubscriptionsRequest;
use App\Http\Requests\UpdateTournamentSubscriptionsRequest;
use Illuminate\Http\Request;

class TournamentSubscriptionsController extends Controller
{
//TournamentSubscription
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments_subscriptions = TournamentSubscriptions::get();
        return view('Dashboard.TournamentSubscription.index',compact('tournaments_subscriptions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tournaments = Tournaments::with('tournament_branches.branches')->with('tournament_files')->get();
//        dd($tournaments);
        return view('Dashboard.TournamentSubscription.create',compact('tournaments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTournamentSubscriptionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTournamentSubscriptionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TournamentSubscriptions  $tournamentSubscriptions
     * @return \Illuminate\Http\Response
     */
    public function show(TournamentSubscriptions $tournamentSubscriptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TournamentSubscriptions  $tournamentSubscriptions
     * @return \Illuminate\Http\Response
     */
    public function edit(TournamentSubscriptions $tournamentSubscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTournamentSubscriptionsRequest  $request
     * @param  \App\Models\TournamentSubscriptions  $tournamentSubscriptions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTournamentSubscriptionsRequest $request, TournamentSubscriptions $tournamentSubscriptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TournamentSubscriptions  $tournamentSubscriptions
     * @return \Illuminate\Http\Response
     */
    public function destroy(TournamentSubscriptions $tournamentSubscriptions)
    {
        //
    }

    /*
     *
     * */
    public function getTournamentInformation(Request $request){
//        dd($request->all());
        $tournament = Tournaments::with('tournament_branches.branches.players')->find($request->tournament_id);
         $html_branches ='';
         $html_players ='';
           foreach ($tournament->tournament_branches as $branch){
               $name = $branch->branches->name;
               $html_branches.=<<<line
             <option selected value="$branch->branch_id"> $name </option>
line;
//               dd($branch);
              foreach ($branch->branches->players as $player ){
                  $html_players.=<<<line
             <option value="$player->id"> $player->name </option>

line;

              }
           }
        return     \Response::json(['branches'=>$html_branches,'players'=>$html_players])  ;
    }
}
