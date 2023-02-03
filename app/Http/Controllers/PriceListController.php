<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use App\Http\Requests\StorePriceListRequest;
use App\Http\Requests\UpdatePriceListRequest;
use App\Models\Sports;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $priceLists = PriceList::paginate(10);
        return view('Dashboard.PriceLists.index',compact('priceLists'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sports = Sports::get();
        return view('Dashboard.PriceLists.create',compact('sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePriceListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePriceListRequest $request)
    {
        PriceList::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'sport_id'=>$request->sport_id,
            'desc'=>$request->desc,
        ]);
        return redirect()->route('price-list.index')->with('message','تم اضافه قائمه سعر بنجاح ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function show(PriceList $priceList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceList $priceList)
    {
        $sports = Sports::get();


        return view('Dashboard.PriceLists.edit',compact('priceList','sports'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriceListRequest  $request
     * @param  \App\Models\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePriceListRequest $request, PriceList $priceList)
    {
        $priceList->name = $request->name;
        $priceList->price = $request->price;
        $priceList->sport_id = $request->sport_id;
        $priceList->desc = $request->desc;
        $priceList->save();
        return redirect()->route('price-list.index')->with('message','تم تعديل قائمه سعر بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceList $priceList)
    {
        $priceList->delete();
        return redirect()->route('price-list.index')->with('error','تم حذف قائمه سعر بنجاح ');

    }
}
