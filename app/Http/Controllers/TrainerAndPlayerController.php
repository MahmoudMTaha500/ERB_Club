<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Sports;
use App\Models\TrainerAndPlayer;
use App\Http\Requests\StoreTrainerAndPlayerRequest;
use App\Http\Requests\UpdateTrainerAndPlayerRequest;
use App\Models\User;

class TrainerAndPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('Dashboard.TrainerAndPlayers.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players = Players::get();
        $users = User::where('is_trainer' ,'1')->get();
        $sports = Sports::get();
        return  view('Dashboard.TrainerAndPlayers.create',compact('players','users','sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainerAndPlayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainerAndPlayerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function show(TrainerAndPlayer $trainerAndPlayer)
    {
        //
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
    public function update(UpdateTrainerAndPlayerRequest $request, TrainerAndPlayer $trainerAndPlayer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainerAndPlayer  $trainerAndPlayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainerAndPlayer $trainerAndPlayer)
    {
        //
    }
}
