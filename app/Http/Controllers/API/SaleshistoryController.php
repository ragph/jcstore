<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sale;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class SaleshistoryController extends Controller
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
        //
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
        $history = Sale::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete sales']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $history]);

        event(new SystemLogEvent($request));

        DB::table('sales')->where('id', $history->id)->delete();
        DB::table('sale_products')->where('sale_id', $history->id)->delete();
    }

    public function searchSalehistory(Request $request){
        $history = DB::table('sales as ss')
            ->select('ss.id','ss.reference_no' ,'ss.payment' , 'ss.total_items' , 'ss.created_at', 'ss.tax' , 'ss.total_payment', 's.name', 's.username','ss.customer_name')
            ->leftJoin('users as s' , 's.id' , '=' , 'ss.created_by')
            ->join('sale_products as sp' ,'sp.sale_id' ,'ss.id')
            ->join('products as p' ,'p.id' ,'sp.product_id')
            ->join('box_managements as b' , 'b.id' , 'p.renter_id')
            ->join('branches as bs' , 'bs.id' , 'b.branch')
            ->whereNull('ss.status')
            ->where('ss.sale_type','=','nondirect')
            ->distinct('sp.sale_id');
            // ->orderBy('ss.id' , $request->sort);

            $history->where(function ($query) use ($request){
                $query
                ->where('ss.reference_no','LIKE','%'.$request->searchForm.'%')
                ->orWhere("ss.total_items", $request->searchForm);
            });
          
          
          if(Auth::user()->role != "admin"){
              if(Auth::user()->branch_id){
                  $history->where('bs.id', Auth::user()->branch_id);
              }
          }

          if($request->dateFrom && $request->dateTo){
            $history->whereDate('ss.created_at', '>=', $request->dateFrom);
            $history->whereDate('ss.created_at', '<=', $request->dateTo);
          }

          if($request->sort){
            $history->orderBy($request->sort, 'asc');
          }else{
            $history->orderBy('ss.id' , 'desc');
          }

        $totalVal = self::getTotalVal($history);
        $history = $history->paginate(50);

        foreach($history as $item){
            $products = DB::table('sale_products as sp')
            ->select('sp.id as spid','p.product_name' , 'p.sku' , 'rs.fullname' , 'bx.box_number' , 'b.name' , 'sp.quantity' ,'p.cost_price','sp.saleprice','sp.price','sp.subtotal')
            ->leftJoin('products as p' , 'p.id' , '=' , 'sp.product_id')
            ->leftJoin('box_managements as bs' , 'bs.id' , '=' , 'sp.location_id')
            ->leftJoin('renters as rs' , 'rs.id' , '=' , 'bs.renter_id')
            ->leftJoin('branches as b' , 'b.id' , '=' , 'bs.branch')
            ->leftJoin('boxes as bx' , 'bx.id' , '=' , 'bs.box_id')
            ->where('sp.sale_id' , $item->id);

            if(Auth::user()->role != "admin"){
                if(Auth::user()->branch_id){
                    $history->where('bs.id', Auth::user()->branch_id);
                }
            }
            
           $products =  $products->get();

            foreach($products as $perItem){
                $perProduct = DB::table('products as p')
                ->select('p.cost_price','p.wholesale_price')
                ->leftJoin('sale_products as sp' , 'p.id' , '=' , 'sp.product_id')
                ->where('sp.id' , $perItem->spid)
                ->first();

                if($perItem->saleprice == 'wholesale'){
                    $perItem->totalper = $perProduct->wholesale_price * $perItem->quantity;
                    $perItem->cost_price = $perProduct->wholesale_price;
                }else{
                    $perItem->totalper = isset($perProduct->cost_price) ? $perProduct->wholesale_price : 0 * $perItem->quantity;
                }
            }

            $item->salesproduct = $products;
        }

        $return = collect($history)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);
        return $return;
    }

    public function searchSalehistoryDirect(Request $request){
        $history = DB::table('sales as ss')
            ->select('ss.id','ss.reference_no' ,'ss.payment' , 'ss.total_items' , 'ss.created_at', 'ss.tax' , 'ss.total_payment', 's.name', 's.username' )
            ->leftJoin('users as s' , 's.id' , '=' , 'ss.created_by')
            ->join('sale_products as sp' ,'sp.sale_id' ,'ss.id')
            ->join('products as p' ,'p.id' ,'sp.product_id')
            ->join('box_managements as b' , 'b.id' , 'p.renter_id')
            ->join('branches as bs' , 'bs.id' , 'b.branch')
            // ->where('ss.reference_no','LIKE','%'.$request->searchForm.'%')
            ->whereNull('ss.status')
            ->where('ss.sale_type','=','direct')
            ->distinct('sp.sale_id');

          $history->where(function ($query) use ($request){
              $query
              ->where('ss.reference_no','LIKE','%'.$request->searchForm.'%')
              ->orWhere("ss.total_items", $request->searchForm);
          });
     
     
        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $history->where('bs.id', Auth::user()->branch_id);
            }
        }
    
        if($request->dateFrom && $request->dateTo){
          $history->whereDate('ss.created_at', '>=', $request->dateFrom);
          $history->whereDate('ss.created_at', '<=', $request->dateTo);
        }

        if($request->sort){
          $history->orderBy($request->sort, 'asc');
        }else{
          $history->orderBy('ss.id' , 'desc');
        }

        $totalVal = self::getTotalVal($history);
        $history = $history->paginate(50);

        foreach($history as $item){
            $products = DB::table('sale_products as sp')
            ->select('sp.id as spid','p.product_name' , 'p.sku' , 'rs.fullname' , 'bx.box_number' , 'b.name' , 'sp.quantity' ,'p.cost_price','sp.saleprice','sp.price','sp.subtotal')
            ->leftJoin('products as p' , 'p.id' , '=' , 'sp.product_id')
            ->leftJoin('box_managements as bs' , 'bs.id' , '=' , 'sp.location_id')
            ->leftJoin('renters as rs' , 'rs.id' , '=' , 'bs.renter_id')
            ->leftJoin('branches as b' , 'b.id' , '=' , 'bs.branch')
            ->leftJoin('boxes as bx' , 'bx.id' , '=' , 'bs.box_id')
            ->where('sp.sale_id' , $item->id);
            if(Auth::user()->role != "admin"){
                if(Auth::user()->branch_id){
                    $history->where('bs.id', Auth::user()->branch_id);
                }
            }
           $products =  $products->get();

            foreach($products as $perItem){
                $perProduct = DB::table('products as p')
                ->select('p.cost_price','p.wholesale_price')
                ->leftJoin('sale_products as sp' , 'p.id' , '=' , 'sp.product_id')
                ->where('sp.id' , $perItem->spid)
                ->first();
                // ->value('p.cost_price');

                if($perItem->saleprice == 'wholesale'){
                    $perItem->totalper = $perProduct->wholesale_price * $perItem->quantity;
                    $perItem->cost_price = $perProduct->wholesale_price;
                }else{
                    $perItem->totalper = $perProduct->cost_price * $perItem->quantity;
                }
                
            }

            $item->salesproduct = $products;
        }

        $return = collect($history)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);

        return $return;
    }

    public function getTotalVal($result){
      $result = $result->get();
      $totalAmount = 0;
      foreach ($result as $item) {
        $totalAmount += $item->total_items;
      }

      return $totalAmount;
    }
    
    public function selectSaleHsDelte(Request $request){
        // return $request;
            DB::table('sales')->whereIn('id', $request->productID)->delete();
            DB::table('sale_products')->whereIn('sale_id', $request->productID)->delete();
    }

    public function branchAssign(){
        // GET BRANCH
        $branch_name = DB::table('branches as b')
            ->select('b.id','b.name','b.address')
            ->where('b.id','=', Auth::user()->branch_id)
            ->first();

        $branch = array('branch_name' => $branch_name->name, "address" => $branch_name->address);

        return $branch;
    }
}
