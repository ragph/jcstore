<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ReturnSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class ReturnSalesController extends Controller
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
        $this->returnSalevalidation($request);
        $product = ReturnSale::create([
            'sale_id' => $request->sale_id,
            'saleprod_id' => $request->saleprod_id,
            'quantity' => $request->quantity,
            'date_return' => $request->date_return,
            'created_by' => Auth::id(),
            'notes' => $request->notes,
        ]);

        $request->merge(['activity' => 'Add return']);
        $request->merge(['activity_id' => $product->id]);
        $request->merge(['details' => $product]);

        event(new SystemLogEvent($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturnSales  $returnSales
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnSales $returnSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnSales  $returnSales
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnSales $returnSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnSales  $returnSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->returnSalevalidation($request);

        $return  = ReturnSale::findOrFail($id);

        $return->sale_id             =    $request->get('sale_id');
        $return->saleprod_id         =    $request->get('saleprod_id');
        $return->quantity            =    $request->get('quantity');
        $return->date_return         =    $request->get('date_return');
        $return->created_by          =    Auth::id();
        $return->notes               =    $request->get('notes');

        $request->merge(['activity' => 'Edit return']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $return]);

        event(new SystemLogEvent($request));

        $return->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnSales  $returnSales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return = ReturnSale::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete return']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $return]);

        event(new SystemLogEvent($request));

        DB::table('return_sales')->where('id', $return->id)->delete();
    }

    public function returnSalevalidation($request){
        return $this->validate($request,[
            'sale_id'           => 'required',
            'saleprod_id'        => 'required',
            'quantity'          => 'numeric|min:0',
            'date_return'        => 'required'
        ],
        [
            'sale_id'          => 'Sales id field is required',
            'saleprod_id'        => 'Location field is required',
            'quantity'          => 'Quantity field is required',
            'quantity'          => 'Date field is required',
         ]
    );
    }


    public function salesList(){
        $sales = DB::table('sales as s')
            ->select('s.id','s.reference_no');

        if(Auth::user()->branch_id){
            $sales->where('s.created_by', Auth::user()->branch_id);
        }

        return $sales->get();
    }

    public function productList(Request $request){
        $product = DB::table('sale_products as sp')
        ->select('sp.id','s.sku' , 's.product_name' , 'rs.fullname' , 'b.name' , 'bx.box_number')
        ->leftJoin('products as s' , 's.id' , '=' ,'sp.product_id')
        ->leftJoin('box_managements as bs' , 'bs.id' , '=' , 'sp.location_id')
        ->leftJoin('renters as rs' , 'rs.id' , '=' , 'bs.renter_id')
        ->leftJoin('branches as b' , 'b.id' , '=' , 'bs.branch')
        ->leftJoin('boxes as bx' , 'bx.id' , '=' , 'bs.box_id')
        ->leftJoin('sales as ss' , 'ss.id' , '=' , 'sp.sale_id')
        ->where('sp.sale_id' , $request->sale_id)
        ->get();

        return $product;
    }


    public function searchReturnsales(Request $request){
        $return  = DB::table('return_sales as rs')
        ->select('rs.id','s.reference_no' , 'rs.quantity' , 'p.product_name' , 'p.sku', 'rs.date_return' , 'rs.sale_id', 'rs.saleprod_id')
        ->leftJoin('sales as s' , 's.id' , '=' , 'rs.sale_id')
        ->leftJoin('sale_products as sp' , 'sp.id' , '=' , 'rs.saleprod_id')
        ->leftJoin('products as p' , 'p.id' , '=', 'sp.product_id')
        ->leftJoin('box_managements as bs' , 'bs.id' , 'p.renter_id')
        ->leftJoin('branches as b' , 'b.id' , 'bs.branch')
        ->where(function ($query) use ($request){
            $query
            ->where("s.reference_no", "LIKE", '%'. $request->searchForm .'%')
            ->orWhere("p.product_name", "LIKE", '%'. $request->searchForm .'%')
            ->orWhere("rs.quantity", $request->searchForm);
        });
        // ->where('s.reference_no','LIKE','%'.$request->searchForm.'%');
        // ->orderBy('p.product_name' , $request->sort);

        if($request->dateFrom && $request->dateTo){
          $return->whereDate('rs.date_return', '>=', $request->dateFrom);
          $return->whereDate('rs.date_return', '<=', $request->dateTo);
        }

        if($request->sort){
          $return->orderBy($request->sort, 'asc');
        }else{
          $return->orderBy('rs.id','desc');
        }

        if(Auth::user()->role != "admin"){
          if(Auth::user()->branch_id){
              $return->where('b.id', Auth::user()->branch_id);
          }
        }
        $return = $return->paginate(50);

        return $return;

    }




}
