<?php

namespace App\Http\Controllers;

use App\Models\Receipts;
use App\Http\Requests\StoreReceiptsRequest;
use App\Http\Requests\UpdateReceiptsRequest;

class ReceiptsController extends Controller
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
     * @param  \App\Http\Requests\StoreReceiptsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function show(Receipts $receipts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipts $receipts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptsRequest  $request
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptsRequest $request, Receipts $receipts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipts $receipts)
    {
        //
    }
}
