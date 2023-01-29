<?php

namespace App\Http\Controllers;

use App\Models\Players;
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
        $receipts = Receipts::paginate(10);
        return view('Dashboard.Receipts.index',compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players =Players::get();
        return view('Dashboard.Receipts.create',compact('players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReceiptsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptsRequest $request)
    {
        Receipts::create([
            'user_id'=>auth()->user()->id,
            'player_id'=>$request->player_id,
            'amount'=>$request->amount,
            'date_receipt'=>$request->date,
        ]);
        return redirect()->route('receipt.index')->with('message','تم اضافه الايصال بنجاح ');

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
    public function edit(Receipts $receipt)
    {
        $players =Players::get();
        return view('Dashboard.Receipts.edit',compact('players','receipt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptsRequest  $request
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptsRequest $request, Receipts $receipt)
    {
        $receipt->player_id=$request->player_id;
        $receipt->amount=$request->amount;
        $receipt->date_receipt=$request->date;
        $receipt->save();
        return redirect()->route('receipt.index')->with('message','تم تعديل الايصال بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipts $receipt)
    {
        $receipt->delete();
        return redirect()->route('receipt.index')->with('error','تم تعديل الايصال بنجاح ');

    }
}
