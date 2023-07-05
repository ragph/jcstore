<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class InventoryController extends Controller
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

        $this->inventoryvalidation($request);

        $inventory = Inventory::create([
            'location_id' => $request->location_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'created_by' => Auth::id(),
            'note' => $request->note,
        ]);

        $request->merge(['activity' => 'Add inventory']);
        $request->merge(['activity_id' => $inventory->id]);
        $request->merge(['details' => $inventory]);

        event(new SystemLogEvent($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->inventoryvalidation($request);

        $transaction = Inventory::findOrFail($id);

        $transaction->location_id = $request->location_id;
        $transaction->product_id = $request->product_id;
        $transaction->quantity = $request->quantity;
        $transaction->date = $request->date;
        $transaction->created_by = Auth::id();
        $transaction->note = $request->note;

        $request->merge(['activity' => 'Edit inventory']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $transaction]);

        event(new SystemLogEvent($request));

        $transaction->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Inventory::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete inventory']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $transaction]);

        event(new SystemLogEvent($request));

        DB::table('inventories')->where('id', $transaction->id)->delete();
    }

    public function inventoryvalidation($request){
        return $this->validate($request,[
            'location_id'       => 'required',
            'product_id'        => 'required',
            'quantity'          => 'numeric|min:0',
        ],
        [
            'location_id'       => 'Location field is required',
            'product_id'        => 'Product field is required',
            'quantity'          => 'Quantity field is required',
         ]
    );
    }


    public function searchInventory(Request $request){

        $inventory = DB::table('inventories as i')
        ->select('ps.product_name' , 'ps.sku' , 'r.fullname' , 'bs.name' , 'bo.box_number' , DB::raw("SUM(i.quantity) as total") , 'i.product_id','i.location_id')
        ->leftjoin('products as ps' , 'ps.id' , '=' , 'i.product_id' )
        ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
        ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
        ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
        ->where(function($query) use ($request) {
            $query
                ->where('ps.product_name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('ps.sku','LIKE','%'.$request->searchForm.'%')
                ->orWhere('r.fullname','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bs.name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bo.box_number','LIKE','%'.$request->searchForm.'%');
        })
        ->groupBy('i.location_id' , 'i.product_id');

        if($request->sort){
          $inventory->orderBy($request->sort, 'asc');
        }else{
          $inventory->orderBy('ps.product_name', 'asc');
        }

        if(Auth::user()->role != "admin"){
        if(Auth::user()->branch_id){
            $inventory->where('bs.id', Auth::user()->branch_id);
        }
    }

        $inventory = $inventory->paginate(50);

        foreach($inventory as $item){
            $return = DB::table('return_products as r')
            ->select(DB::raw("SUM(r.quantity) as finaltotal"))
            ->where('r.product_id' , $item->product_id)
            ->where('r.location_id' , $item->location_id)
            ->groupBy('r.location_id' , 'r.product_id')
            ->value('finaltotal');

            $sales = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as salequantity"))
            ->where('sp.product_id' , $item->product_id)
            ->where('sp.location_id' , $item->location_id)
            ->groupBy('sp.location_id' , 'sp.product_id' )
            ->value('salequantity');

            $item->salequantity = $sales;
            $item->returnquantity = $return;
            $item->TRTotal = $item->total - $return;
            $item->TSTotal = $item->TRTotal - $sales;

        }
        return $inventory ;
    }

    public function selectIvtryDelte(Request $request){
        // return $request;
            DB::table('inventories')->whereIn('id', $request->productID)->delete();
}

    public function searchTransaction(Request $request){

        $inventory = DB::table('inventories as i')
        ->select('i.id','ps.product_name' , 'ps.sku' , 'r.fullname' , 'bs.name' , 'bo.box_number' , 'i.quantity' ,'i.location_id' , 'i.product_id' , 'i.date', 'i.note')
        ->leftjoin('products as ps' , 'ps.id' , '=' , 'i.product_id')
        ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
        ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
        ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
        ->where(function($query) use ($request) {
            $query->where('ps.product_name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('ps.sku','LIKE','%'.$request->searchForm.'%')
                ->orWhere('r.fullname','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bs.name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('bo.box_number','LIKE','%'.$request->searchForm.'%')
                ->orWhere('i.quantity', $request->searchForm);
        });

        if($request->sort){
          $inventory->orderBy($request->sort, 'asc');
        }else{
          $inventory->orderBy('i.id', 'asc');
        }


        if($request->from != null && $request->to != null){
            $inventory->whereBetween(DB::raw("DATE(i.date)") , [$request->from , $request->to] );
           }
    if(Auth::user()->role != "admin"){
        if(Auth::user()->branch_id){
            $inventory->where('bs.id', Auth::user()->branch_id);
        }
    }
        $inventory = $inventory->paginate(50);

        return $inventory ;
    }
}
