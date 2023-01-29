<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use App\Http\Requests\StorePackagesRequest;
use App\Http\Requests\UpdatePackagesRequest;
use App\Models\PriceList;
use App\Models\Sports;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\Models\PackagesDetails;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Packages::with('packages_details.sports')->paginate(10);
//        dd($packages);

         return view('Dashboard.Packages.index',compact('packages'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sports = Sports::get();

        return view('Dashboard.Packages.create',compact('sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackagesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackagesRequest $request)
    {
//dd($request->all());
        $package = Packages::create([
            'name'=>$request->name,
            'total_package'=>$request->total_price,
            'desc'=>$request->desc,
        ]);
        for($x=0; $x < count($request->sport_id); $x++)
        {

            PackagesDetails::create([
                'package_id'=>$package->id,
                'sport_id'=>$request->sport_id[$x],
                'price'=>$request->price[$x],
                'number_of_training'=>$request->number_of_training[$x],
                'total_price_of_training'=>$request->total_of_training[$x],
            ]);
        }
        return redirect()->route('package.index')->with('message','تم اضافه الباكدج  بنجاح ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function show(Packages $packages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function edit(Packages $packages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackagesRequest  $request
     * @param  \App\Models\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackagesRequest $request, Packages $packages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Packages  $packages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packages $package)
    {
        $package->packages_details()->delete();
        $package->delete();
        return redirect()->route('package.index')->with('error','تم حذف الباكدج  بنجاح ');

    }


    public function getPrice(Request $request){
        $sport_id = $request->sport_id;
        $price_list =PriceList::where('sport_id',$sport_id)->first();
        if($price_list){
            return  Response()->json(['price'=>$price_list->price]);
        }
        return 0;

    }
}
