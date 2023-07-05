<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Renter;
use App\Sale;
use App\SaleProduct;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class PointOfSaleController extends Controller
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

        if($request->sale_type == 'direct'){
            $this->salesDirectValidation($request);
        }else{
            $this->salesValidation($request);
        }
        
        $sale = Sale::create([
            'customer_name' => $request->cust_name,
            'payment' => $request->payment,
            'total_items' => $request->totalProduct,
            'tax' => $request->tax,
            'total_payment' => $request->totalPayment,
            'sale_type' => $request->sale_type,
            'created_by' => Auth::id(),
        ]);

        $request->merge(['activity' => 'Add POS']);
        $request->merge(['activity_id' => $sale->id]);
        $request->merge(['details' => $sale]);

        event(new SystemLogEvent($request));

        $updateReference = Sale::findOrFail($sale->id);

        $referenceNumber = sprintf('%08d', $sale->id);
        $updateReference->reference_no = $referenceNumber;
        $updateReference->save();

        $saleID = $sale->id;

        foreach($request->products as $key => $product){
            if($key != 0){
                $saleProduct = SaleProduct::create([
                    'sale_id' => $sale->id,
                    'location_id' => $product['location_id'],
                    'product_id' =>$product['id'],
                    'quantity'=> $product['quantity'],
                    'saleprice' => $product['saleprice'],
                    'price' => $product['price'],
                    'subtotal' => $product['total']

                    // ,'price','saleprice'
                ]);
            }
        }


         // GET BRANCH
         if(Auth::user()->branch_id){
            $branch_name = DB::table('branches as b')
                ->select('b.id','b.name','b.address')
                ->where('b.id','=', Auth::user()->branch_id)
                ->first();

            $invoice_return = array('reference_number' => $referenceNumber, 'branch_name' => $branch_name->name, "address" => $branch_name->address);

            return $invoice_return;
         }

        // return $referenceNumber;
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
        //
    }

    public function barcodeSearch(Request $request){

        
        if($request->barcode){
            $inventories = DB::table('inventories as i')
            ->select('p.id','p.sku','p.product_name','p.cost_price as price','p.sell_price', DB::raw("sum(DISTINCT i.quantity) as quantity"), DB::raw("sum(DISTINCT rp.quantity) as rp_quantity"), DB::raw("sum(sp.quantity) as sp_quantity"))
            ->join('products as p','p.id','=','i.product_id')
            ->leftJoin('sale_products as sp','sp.product_id','=','i.product_id')
            ->leftJoin('return_products as rp','rp.product_id','=','i.product_id')
            ->join('box_managements as bm','bm.id','=','p.renter_id')
            ->where('p.sku','=', $request->barcode)
            ->groupBy('i.product_id');


        // if(Auth::user()->branch_id){
        //     $inventories->where('bm.branch', Auth::user()->branch_id);
        // }

        $inventories = $inventories->get();

        foreach($inventories as &$inventory){
            $renters = DB::table('inventories as i')
                ->select('r.fullname', 'bo.box_number','i.location_id')
                ->leftjoin('products as ps' , 'ps.id' , '=' , 'i.product_id' )
                ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
                ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
                ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
                ->where('ps.id', $inventory->id)
                ->first();


            $inventory->location_id = $renters->location_id;
            $inventory->fullname = $renters->fullname;
            $inventory->box_number = $renters->box_number;


            $inventory->quantity = $inventory->quantity - $inventory->rp_quantity - $inventory->sp_quantity;

            if($inventory->quantity <= 0){
                $inventory->stock = "Out of stock";
                $inventory->number = 0;
            }else{
                $inventory->stock = "Instock";
                $inventory->number = 1;
            }
        }

        return $inventories;
        }
    }

    public function searchProducts(Request $request){

        if($request->product){
            $box_managements = DB::table('box_managements')
                ->select('id')
                ->where('renter_id', Auth::user()->renter_id)
                ->first();

            $renter_id = $box_managements->id;
            
            $inventories = DB::table('inventories as i')
                ->select('product_id', DB::raw("SUM(quantity) as quantity"))
                ->join('products as p','p.id','=','i.product_id')
                ->join('box_managements as bm','bm.id','=','p.renter_id')
                // ->join('users as u','u.renter_id','=','bm.renter_id')
                ->groupBy('i.location_id')
                ->groupBy('i.product_id');
                // ->where('p.id', 976);

            $sales_product = DB::table('sale_products as i')
                ->select('product_id', DB::raw("SUM(quantity) as sp_quantity"))
                ->join('products as p','p.id','=','i.product_id')
                ->join('box_managements as bm','bm.id','=','p.renter_id')
                // ->join('users as u','u.renter_id','=','bm.renter_id')
                ->groupBy('i.location_id')
                ->groupBy('i.product_id');
                // ->where('p.id', 976);

            $return_products  = DB::table('return_products  as i')
                ->select('product_id', DB::raw("SUM(quantity) as rp_quantity"))
                ->join('products as p','p.id','=','i.product_id')
                ->join('box_managements as bm','bm.id','=','p.renter_id')
                // ->join('users as u','u.renter_id','=','bm.renter_id')
                ->groupBy('i.location_id')
                ->groupBy('i.product_id');
                // ->where('p.id', 976);

            if($renter_id != 6){
                $inventories->where('i.location_id', $renter_id);
                $sales_product->where('i.location_id', $renter_id);
                $return_products->where('i.location_id', $renter_id);
            }

            $renters = DB::table('inventories as i')
                ->select('i.product_id','r.fullname', 'bo.box_number','i.location_id','bs.id as branch_id')
                ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
                ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
                ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
                ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
                ->distinct();

            $products = DB::table('products as p')
                ->select('p.id','p.sku','p.product_name','p.cost_price as price','p.sell_price', DB::raw("IFNULL(i.quantity, 0) - (IFNULL(sp.sp_quantity,0) + IFNULL(rp.rp_quantity, 0)) as quantity"),'r.fullname','r.box_number','r.location_id')
                ->leftJoinSub($sales_product, 'sp', function ($join) {
                    $join->on('sp.product_id', '=', 'p.id');                
                })
                ->leftJoinSub($inventories, 'i', function ($join) {
                    $join->on('i.product_id', '=', 'p.id');                
                })
                ->leftJoinSub($return_products, 'rp', function ($join) {
                    $join->on('rp.product_id', '=', 'p.id');                
                })
                // ->where('p.id', 976)
                ->leftJoinSub($renters, 'r', function ($join) {
                    $join->on('r.product_id', '=', 'p.id');                
                });

            if($request->product){
                $products->where('p.product_name','LIKE','%'.$request->product.'%');
            }
    
            if(Auth::user()->role != "admin"){
                if(Auth::user()->branch_id){
                    $products->where('r.branch_id', Auth::user()->branch_id);
                }
            }

            return $products->get();

            

            // $box_managements = DB::table('box_managements')
            //     ->select('id')
            //     ->where('renter_id', Auth::user()->renter_id)
            //     ->get();

            // $sales_product = DB::table('sale_products as sp')
            //     ->select('product_id', DB::raw("SUM(quantity) as sp_quantity"))
            //     ->join('products as p','p.id','=','sp.product_id')
            //     ->join('box_managements as bm','bm.id','=','p.renter_id')
            //     ->join('users as u','u.renter_id','=','bm.renter_id')
            //     ->groupBy('sp.location_id')
            //     ->groupBy('product_id');
                
            // $inventories = DB::table('inventories as i')
            //     ->select('product_id', DB::raw("SUM(quantity) as quantity"))
            //     ->join('products as p','p.id','=','i.product_id')
            //     ->join('box_managements as bm','bm.id','=','p.renter_id')
            //     ->join('users as u','u.renter_id','=','bm.renter_id')
            //     ->groupBy('i.location_id')
            //     ->groupBy('i.product_id');
                
            // $return_products = DB::table('return_products as rp')
            //     ->select('product_id', DB::raw("SUM(quantity) as rp_quantity"))
            //     ->join('products as p','p.id','=','rp.product_id')
            //     ->join('box_managements as bm','bm.id','=','p.renter_id')
            //     ->join('users as u','u.renter_id','=','bm.renter_id')
            //     ->groupBy('rp.location_id')
            //     ->groupBy('product_id');

            // if( Auth::user()->renter_id != 6){
            //     $inventories->where('i.location_id', $box_managements[0]->id);
            //     $sales_product->where('sp.location_id', $box_managements[0]->id);
            //     $return_products->where('rp.location_id', $box_managements[0]->id);
            // }
    
            // $renters = DB::table('inventories as i')
            //     ->select('i.product_id','r.fullname', 'bo.box_number','i.location_id','bs.id as branch_id')
            //     ->leftjoin('box_managements as b' , 'b.id' , '=' , 'i.location_id' )
            //     ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
            //     ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
            //     ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
            //     ->distinct();

    
            // $products = DB::table('products as p')
            //     ->select('p.id','p.sku','p.product_name','p.cost_price as price','p.sell_price','i.quantity','sp.sp_quantity','rp.rp_quantity','r.fullname','r.box_number','r.location_id')
            //     ->leftJoinSub($sales_product, 'sp', function ($join) {
            //         $join->on('sp.product_id', '=', 'p.id');                
            //     })
            //     ->leftJoinSub($inventories, 'i', function ($join) {
            //         $join->on('i.product_id', '=', 'p.id');                
            //     })
            //     ->leftJoinSub($return_products, 'rp', function ($join) {
            //         $join->on('rp.product_id', '=', 'p.id');                
            //     })
            //     ->leftJoinSub($renters, 'r', function ($join) {
            //         $join->on('r.product_id', '=', 'p.id');                
            //     });
    
            // if($request->product){
            //     $products->where('p.product_name','LIKE','%'.$request->product.'%');
            // }
    
            // if(Auth::user()->role != "admin"){
            //     if(Auth::user()->branch_id){
            //         $products->where('r.branch_id', Auth::user()->branch_id);
            //     }
            // }
    
            // $products = $products->get();
    
            // foreach($products as &$inventory){
   
            //     $inventory->quantity = $inventory->quantity - $inventory->rp_quantity - $inventory->sp_quantity;
    
            //     if($inventory->quantity <= 0){
            //         $inventory->stock = "Out of stock";
            //         $inventory->number = 0;
            //     }else{
            //         $inventory->stock = "Instock";
            //         $inventory->number = 1;
            //     }
            // }
    
            // return $products;
            }
    }

    public function salesValidation($request){

        $producttotal = $request->totalProduct;

        if(count($request->products) > 1){

            $this->validate($request,[
                    'payment' => 'required|integer|min:'.$producttotal,
                    'products.*.quantity' => 'required',
                    'cust_name' => 'required'
                ],
                [
                    'payment.required' => 'Payment field is required',
                    'products.*.quantity.required' => 'Quantity field is required',
                    'cust_name.required' => 'Customer field is required'
                ]
            );
        }else{
            $error = \Illuminate\Validation\ValidationException::withMessages([
                "No product listed"
             ]);
             throw $error;
        }
    }

    public function salesDirectValidation($request){

        if(count($request->products) > 1){

            $this->validate($request,[
                    'products.*.quantity' => 'required',
                    'cust_name' => 'required'
                ],
                [
                    'products.*.quantity.required' => 'Quantity field is required',
                    'cust_name.required' => 'Customer field is required'
                ]
            );
        }else{
            $error = \Illuminate\Validation\ValidationException::withMessages([
                "No product listed"
             ]);
             throw $error;
        }
    }

    public function salePrice(Request $request){

        $sell_prices = DB::table('products as p')
            ->select('p.id','p.wholesale_price','p.wholesale_quantity','p.sell_price','p.cost_price')
            ->where('p.id','=', $request->id)
            ->first();

        return array('wholesale' => $sell_prices->wholesale_price, 'quantity' => $sell_prices->wholesale_quantity,'sell_price' => $sell_prices->sell_price);

    }
}
