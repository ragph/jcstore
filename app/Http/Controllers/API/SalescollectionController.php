<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SaleCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class SalescollectionController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->saleCollectionvalid($request);
        $setting = SaleCollection::create([
            'renter_id' => $request->location_id,
            'amount' => $request->amount,
            'sales_from' => $request->sales_from,
            'sales_to' => $request->sales_to,
            'date_released' => $request->date_released,
            'note' => $request->note,
            'created_by' =>Auth::id(),
        ]);

        $request->merge(['activity' => 'Add sales released']);
        $request->merge(['activity_id' => $setting->id]);
        $request->merge(['details' => $setting]);

        event(new SystemLogEvent($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleCollection  $saleCollection
     * @return \Illuminate\Http\Response
     */
    public function show(SaleCollection $saleCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SaleCollection  $saleCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleCollection $saleCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleCollection  $saleCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->saleCollectionvalid($request);
        $collections = SaleCollection::findOrFail($id);
        $collections->renter_id = $request->location_id;
        $collections->amount = $request->amount;
        $collections->sales_from = $request->sales_from;
        $collections->sales_to = $request->sales_to;
        $collections->date_released = $request->date_released;
        $collections->note = $request->note;
        $collections->created_by = Auth::id();

        $request->merge(['activity' => 'Edit sales released']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $collections]);

        event(new SystemLogEvent($request));

        $collections->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCollection  $saleCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coll = SaleCollection::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete sales released']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $coll]);

        event(new SystemLogEvent($request));

        DB::table('sale_collections')->where('id', $coll->id)->delete();
    }

    public function saleCollectionvalid($request){
        return $this->validate($request,[
            'location_id' => 'required',
            'amount' => 'required',
            'sales_from' => 'required',
            'sales_to' => 'required',
            'date_released' => 'required',

        ],
        [
            'location_id.required'    => 'Supplier field is required.',
            'amount.required'    => 'Amount field is required.',
            'sales_from.required'    => 'Sales from field is required.',
            'sales_to.required'    => 'Sales to field is required.',
            'date_released.required'    => 'Date released to field is required.',


        ]
    );
    }
    public function searchCollection(Request $request){
        $collection = DB::table ('sale_collections as sc')
        ->select('sc.id','sc.amount', 'sc.note' ,  'r.fullname' , 'bs.name' , 'bo.box_number' , 'sc.renter_id' , 'sc.date_released' , 'sc.sales_from' , 'sc.sales_to')
        ->leftjoin('box_managements as b' , 'b.id' , '=' , 'sc.renter_id' )
        ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
        ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
        ->where(function($query) use ($request) {
            $query->where('r.fullname','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bs.name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bo.box_number','LIKE','%'.$request->searchForm.'%');
        });
        if($request->sort){
            $collection->orderBy($request->sort, 'asc');
          }else{
            $collection->orderBy('sc.id', 'desc');
          }
          if($request->from != null && $request->to != null){
            $collection->whereBetween(DB::raw("DATE(sc.date_released)") , [$request->from , $request->to] );
           }
           if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $collection->where('bs.id', Auth::user()->branch_id);
            }
        }
        $collection = $collection->paginate(50);
        $total = 0;
        foreach($collection as $resultItem){
            $total += $resultItem->amount;
        }
    $newArray = array([
        'data'  => $collection,
        'total' => $total ,
    ]);
           return $newArray;
    }
    public function selectColl(Request $request){
        // return $request;
            DB::table('sale_collections')->whereIn('id', $request->productID)->delete();
}
}
