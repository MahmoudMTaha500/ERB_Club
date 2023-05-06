<?php

namespace App\Http\Controllers;

use App\Models\TournamentPlayersDetails;
use App\Http\Requests\StoreTournamentPlayersDetailsRequest;
use App\Http\Requests\UpdateTournamentPlayersDetailsRequest;

class TournamentPlayersDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTournamentPlayersDetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTournamentPlayersDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TournamentPlayersDetails  $tournamentPlayersDetails
     * @return \Illuminate\Http\Response
     */
    public function show(TournamentPlayersDetails $tournamentPlayersDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TournamentPlayersDetails  $tournamentPlayersDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(TournamentPlayersDetails $tournamentPlayersDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTournamentPlayersDetailsRequest  $request
     * @param  \App\Models\TournamentPlayersDetails  $tournamentPlayersDetails
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTournamentPlayersDetailsRequest $request, TournamentPlayersDetails $tournamentPlayersDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TournamentPlayersDetails  $tournamentPlayersDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(TournamentPlayersDetails $tournamentPlayersDetails)
    {
        //
    }
}
