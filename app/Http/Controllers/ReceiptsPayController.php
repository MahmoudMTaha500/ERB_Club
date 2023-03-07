<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Receipts;
use App\Models\ReceiptsPay;
use App\Http\Requests\StoreReceiptsPayRequest;
use App\Http\Requests\UpdateReceiptsPayRequest;
use App\Models\ReceiptTypePay;
use App\Models\ReceiptTypes;

class ReceiptsPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = ReceiptsPay::paginate(10);
        return view('Dashboard.ReceiptsPay.index',compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players =Players::get();
        $receiptTypes= ReceiptTypePay::get();
        return view('Dashboard.ReceiptsPay.create',compact('players','receiptTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReceiptsPayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptsPayRequest $request)
    {
        ReceiptsPay::create([
            'user_id'=>auth()->user()->id,

            'type_of_to'=>$request->to_type,
            'from'=>$request->from,
            'to'=>$request->to,
            'amount'=> -$request->amount,
            'statement'=>$request->statement,
            'date_receipt'=>$request->date,
        ]);
        return redirect()->route('receipt-pay.index')->with('message','تم اضافه الايصال بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiptsPay  $receiptsPay
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptsPay $receiptsPay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiptsPay  $receiptsPay
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiptsPay $receiptsPay,$id)
    {
        $receiptsPay = ReceiptsPay::find($id);
        $receiptTypes= ReceiptTypePay::get();
        $players =Players::get();
        return view('Dashboard.ReceiptsPay.edit',compact('players','receiptsPay','receiptTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptsPayRequest  $request
     * @param  \App\Models\ReceiptsPay  $receiptsPay
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReceiptsPayRequest $request, ReceiptsPay $receiptsPay,$id)
    {
        $receiptsPay = ReceiptsPay::find($id);

        $receiptsPay->user_id=auth()->user()->id;
        $receiptsPay->from=$request->from;
        $receiptsPay->to=$request->to;
        $receiptsPay->type_of_to=$request->to_type;
        $receiptsPay->amount= (-$request->amount);
        $receiptsPay->date_receipt=$request->date;
        $receiptsPay->save();
        return redirect()->route('receipt-pay.index')->with('message','تم تعديل الايصال بنجاح ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiptsPay  $receiptsPay
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptsPay $receiptsPay,$id)
    {
        $receiptsPay = ReceiptsPay::find($id);

        $receiptsPay->delete();
        return redirect()->route('receipt-pay.index')->with('error','تم حذف الايصال بنجاح ');
    }
}
