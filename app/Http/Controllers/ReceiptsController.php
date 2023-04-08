<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\PriceList;
use App\Models\Receipts;
use App\Http\Requests\StoreReceiptsRequest;
use App\Http\Requests\UpdateReceiptsRequest;
use App\Models\ReceiptsPay;
use App\Models\ReceiptTypes;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\Services\PDF\ConvertDataToPDF;
use ZanySoft\LaravelPDF\PDF;
use App\Exports\ExportToExcelSheet;
use Maatwebsite\Excel\Facades\Excel;
class ReceiptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filter){
            $receipts = $this->filter($request);
            if($request->pdf){
                $viewName = "Dashboard.Receipts.pdf";
                $fileName = "ايصالات التوريد";
               $FilePdf = new ConvertDataToPDF($viewName,$receipts,$viewName);
            }
            if($request->excel){
                $ExportToExcelSheet  = new ExportToExcelSheet($receipts ,'Dashboard.Receipts.pdf');
                 return Excel::download($ExportToExcelSheet , 'ايصالات التوريد.xlsx');
            }
        } else{
            $receipts = Receipts::paginate(10);

        }
        $players =Players::with('PlayerSportPrice')->get();
//        dd($players[0]->PlayerSportPrice->price);
        $receiptTypes= ReceiptTypes::get();
        return view('Dashboard.Receipts.index',compact('receipts','players','receiptTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players =Players::with('PlayerSportPrice')->get();
//        dd($players[0]->PlayerSportPrice->price);
        $receiptTypes= ReceiptTypes::get();
        return view('Dashboard.Receipts.create',compact('players','receiptTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReceiptsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptsRequest $request)
    {
//        dd($request->all());
        Receipts::create([
            'user_id'=>auth()->user()->id,

            'type_of_from'=>$request->from_type,
            'from'=>$request->from,
            'to'=>$request->to,
            'type_of_amount'=>$request->type_of_amount,
            'amount'=>$request->amount,
            'paid'=>$request->paid,
            'statement'=>$request->statement,
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
        $receiptTypes= ReceiptTypes::get();
        $players =Players::get();
        return view('Dashboard.Receipts.edit',compact('players','receipt','receiptTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReceiptsRequest  $request
     * @param  \App\Models\Receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReceiptsRequest $request, Receipts $receipt)
    {
        $receipt->user_id=auth()->user()->id;
        $receipt->from=$request->from;
        $receipt->to=$request->to;
        $receipt->type_of_from=$request->from_type;
        $receipt->type_of_amount=$request->type_of_amount;
        $receipt->amount=$request->amount;
        $receipt->paid=$request->paid;
        $receipt->statement=$request->statement;
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

    public function getPlayerSportPrice(Request  $request){
    $player=      Players::find($request->player_id);
        $sport_id =  $player->sport_id;
          $price_list =  PriceList::where('sport_id',$sport_id)->get()->first();
        return     \Response::json(['price'=>$price_list->price])  ;
    }

    public function filter($request){
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $type = $request->type;
        $Receipts = new Receipts();

//dd($request->all());
        if($fromDate && $toDate && $fromDate <=  $toDate){
            $Receipts = $Receipts->whereBetween("$request->type_date", [$fromDate, $toDate]);
        }



        if($type){
            $Receipts = $Receipts->whereHas('receiptType' , function($query) use ($type){
                $query->where('type',$type);
            });
        }

        if($request->from_others){
            $Receipts = $Receipts->where("from", $request->from_others)->where('type_of_from',"others");
        }
        if($request->from_player){
            $Receipts = $Receipts->where("from", $request->from_player)->where('type_of_from',"players");
        }
        if($request->to){
            $Receipts = $Receipts->where("to", $request->to);
        }
        $Receipts =$Receipts->paginate(10);
        return $Receipts;


    }

    /*
     *  pdf file
     * */

}
