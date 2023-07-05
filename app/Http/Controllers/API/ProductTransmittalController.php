<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductTransmittal;
use Illuminate\Support\Facades\DB;
use App\Product;

use App\Events\SystemLog\SystemLogEvent;

class ProductTransmittalController extends Controller
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
        $this->validation($request);
        $product_rent = Product::findOrFail($request->product_id);

        $transfer = ProductTransmittal::create([
            'product_id' => $request->product_id,
            'previous_supplier' => $product_rent->renter_id,
            'current_supplier' => $request->location_id,
            'date_transferred' => $request->date,
            'note' => $request->note
        ]);

        $request->merge(['activity' => 'Transfer product']);
        $request->merge(['activity_id' => $transfer->id]);
        $request->merge(['details' => $transfer]);

        event(new SystemLogEvent($request));

        $product = Product::findOrFail($request->product_id);
        $product->renter_id = $request->location_id;
        $product->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $boxes = ProductTransmittal::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete transfer product']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));

        DB::table('product_transmittals')->where('id', $id)->delete();
    }

    public function searchProductTransmittal(Request $request){

        $previous = DB::table('box_managements as bm')
            ->select('bm.id',DB::raw("CONCAT(COALESCE(r.fullname,''),' - ',COALESCE(b.name,''),' - ',COALESCE(bx.box_number,'')) as previous"))
            ->leftJoin('renters as r','r.id','=','bm.renter_id')
            ->leftJoin('branches as b','b.id','=','bm.branch')
            ->leftJoin('boxes as bx','bx.id','=','bm.box_id');

        $current = DB::table('box_managements as bm')
            ->select('bm.id',DB::raw("CONCAT(COALESCE(r.fullname,''),' - ',COALESCE(b.name,''),' - ',COALESCE(bx.box_number,'')) as current"))
            ->leftJoin('renters as r','r.id','=','bm.renter_id')
            ->leftJoin('branches as b','b.id','=','bm.branch')
            ->leftJoin('boxes as bx','bx.id','=','bm.box_id');

        $product_transmittal = DB::table('product_transmittals as pt')
            ->select('pt.id','p.product_name','pr.previous','cr.current','pt.date_transferred','pt.note')
            ->leftJoin('products as p','p.id','=','pt.product_id')
            ->leftJoinSub($previous, 'pr', function ($join) {
                $join->on('pr.id', '=', 'pt.previous_supplier');                
            })
            ->leftJoinSub($current, 'cr', function ($join) {
                $join->on('cr.id', '=', 'pt.current_supplier');                
            })
            ->where(function ($query) use ($request){
              $query
              ->where("p.product_name", "LIKE", '%'. $request->searchForm .'%')
              ->orWhere("cr.current", "LIKE", '%'. $request->searchForm .'%')
              ->orWhere("pr.previous", "LIKE", '%'. $request->searchForm .'%')
              ->orWhere("pt.note", "LIKE", '%'. $request->searchForm .'%');
          });;

        if($request->from && $request->to){
          $product_transmittal->whereDate('pt.date_transferred', '>=', $request->from);
          $product_transmittal->whereDate('pt.date_transferred', '<=', $request->to);
        }

        if($request->sort){
          $product_transmittal->orderBy($request->sort, 'asc');
        }else{
          $product_transmittal->orderBy('pt.id', 'desc');
        }

        $product_transmittal = $product_transmittal->paginate(50);

        return $product_transmittal;
            
    }

    public function previousSupplier(Request $request){

       $previous = DB::table('products as p')
        ->select('bm.id','r.fullname','b.name','bx.box_number', DB::raw("CONCAT(COALESCE(r.fullname,''),' - ',COALESCE(b.name,''),' - ',COALESCE(bx.box_number,'')) as supplier"))
        ->leftJoin('box_managements as bm','bm.id','=','p.renter_id')
        ->leftJoin('renters as r','r.id','=','bm.renter_id')
        ->leftJoin('branches as b','b.id','=','bm.branch')
        ->leftJoin('boxes as bx','bx.id','=','bm.box_id')
        ->where('p.id','=', $request->product_id)
        ->get();

        return $previous;
        
    }

    public function deleteSelectedTrans(Request $request){
        DB::table('product_transmittals')->whereIn('id', $request->productID)->delete();
    }

    public function validation($request){
        
        return $this->validate($request,[
                'product_id' => 'required',
                'location_id' => 'required',
                'date' => 'required'
            
            ]
        );

    }
}
