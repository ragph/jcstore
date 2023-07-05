<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ReturnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class ReturnProductController extends Controller
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
        $this->returnvalidation($request);
        $return = ReturnProduct::create([
            'location_id' => $request->location_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'created_by' => Auth::id(),
            'note' => $request->note,
        ]);

        $request->merge(['activity' => 'Add return product']);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->returnvalidation($request);

        $return = ReturnProduct::findOrFail($id);

        $return->location_id = $request->location_id;
        $return->product_id = $request->product_id;
        $return->quantity = $request->quantity;
        $return->date = $request->date;
        $return->created_by = Auth::id();
        $return->note = $request->note;

        $request->merge(['activity' => 'Edit return product']);
        $request->merge(['details' => $return]);

        event(new SystemLogEvent($request));

        $return->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return = ReturnProduct::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete return product']);
        $request->merge(['details' => $return]);

        event(new SystemLogEvent($request));

        DB::table('return_products')->where('id', $return->id)->delete();
    }

    public function searchReturnProduct(Request $request){

        $return = DB::table('return_products as i')
        ->select('i.id','ps.product_name' , 'ps.sku' , 'r.fullname' , 'bs.name' , 'bo.box_number' , 'i.quantity' ,'i.location_id' , 'i.product_id' , 'i.date', 'i.note')
        ->leftjoin('products as ps' , 'ps.id' , '=' , 'i.product_id' )
        ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
        ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
        ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
        ->where(function($query) use ($request) {
                $query->where('ps.product_name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('ps.sku','LIKE','%'.$request->searchForm.'%')
                ->orWhere('r.fullname','LIKE','%'.$request->searchForm.'%');
        })
        ->orderBy('ps.product_name', $request->sort);

        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $return->where('bs.id', Auth::user()->branch_id);
            }
        }
        $return = $return->paginate(50);

        return $return ;
    }

    public function selectRrnPrdctDelte(Request $request){
        // return $request;
            DB::table('return_products')->whereIn('id', $request->productID)->delete();
    }

    public function returnvalidation($request){
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

}