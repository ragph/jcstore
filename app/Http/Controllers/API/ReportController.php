<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Renter;
use Auth;
class ReportController extends Controller
{
    public function reportrenterList(Request $request){
            $renters = DB::table('renters as r')
            ->select('r.fullname' , 'r.address' , 'r.contact_number' , 'r.date_registered' , 'bs.date_of_contract', 'b.name', 'bx.box_number')
            ->leftJoin('box_managements as bs' , 'bs.renter_id' , 'r.id')
            ->leftJoin('branches as b' , 'b.id' , 'bs.branch')
            ->leftJoin('boxes as bx' , 'bx.id' , 'bs.box_id');
            if($request->renter){
                $renters->where('r.fullname','LIKE','%'.$request->renter.'%');
                $renters->orWhere('b.name','LIKE','%'.$request->renter.'%');
                $renters->orWhere('bx.box_number','LIKE','%'.$request->renter.'%');
                $renters->orWhere('r.address','LIKE','%'.$request->renter.'%');
                $renters->orWhere('r.contact_number','LIKE','%'.$request->renter.'%');
            }
            if($request->sort){
                $renters->orderBy($request->sort, 'asc');
              }else{
                $renters->orderBy('r.date_registered', 'desc');
              }
            if(Auth::user()->role != "admin"){
                if(Auth::user()->branch_id){
                    $renters->where('b.id', Auth::user()->branch_id);
                }
            }
            $renters = $renters->paginate(50);
            return $renters;
    }

    public function reportproductlist(Request $request){
        $product = DB::table('products as ps')
        ->select('ps.product_name' ,'ps.sku', 'ps.cost_price' , 'ps.sell_price' , 'ps.stock_level', 'r.fullname', 'b.name' , 'bo.box_number')
        ->leftJoin('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->leftJoin('branches as b' , 'b.id' , 'bs.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'bs.box_id')
        ->leftJoin('renters as r' , 'r.id' , 'bs.renter_id');
        if($request->renter){
            $product->where('r.fullname','LIKE','%'.$request->renter.'%');
            $product->orWhere('ps.product_name','LIKE','%'.$request->renter.'%');
            $product->orWhere('ps.sku','LIKE','%'.$request->renter.'%');
            $product->orWhere('b.name','LIKE','%'.$request->renter.'%');
            $product->orWhere('bo.box_number','LIKE','%'.$request->renter.'%');
        }
        if($request->sort){
            $product->orderBy($request->sort, 'asc');
          }else{
            $product->orderBy('r.Fullname', 'desc');
          }
        if(Auth::check() && Auth::user()->role != "admin"){
            if( Auth::check() && Auth::user()->branch_id){
                $product->where('b.id', Auth::user()->branch_id);
            }
        }
        $product = $product->paginate(50);

        return $product;
    }

    public function reportinventoryList(Request $request){
           $inventory = DB::table('inventories as i')
           ->select('p.product_name' , 'p.sku' , 'p.stock_level', 'i.product_id' , DB::raw("SUM(i.quantity) as quantity") )
           ->join('products as p' , 'p.id' , 'i.product_id')
           ->leftJoin('box_managements as bs' , 'bs.id' , 'p.renter_id')
           ->leftJoin('branches as b' , 'b.id' , 'bs.branch')
           ->groupBy('i.product_id');
           if($request->renter){
            $inventory->where('p.product_name','LIKE','%'.$request->renter.'%');
            $inventory->orWhere('p.sku','LIKE','%'.$request->renter.'%');
           }
           if($request->sort){
            $inventory->orderBy($request->sort, 'asc');
          }else{
            $inventory->orderBy('p.product_name', 'desc');
          }
           if( Auth::check() &&Auth::user()->role != "admin"){
            if( Auth::check() && Auth::user()->branch_id){
                $inventory->where('b.id', Auth::user()->branch_id);
            }
        }
           $inventory = $inventory->paginate(50);

           foreach($inventory as $item){
               $return = DB::table('return_products as rp')
               ->select(DB::raw("SUM(rp.quantity) as quantity") )
               ->join('products as p' , 'p.id' , 'rp.product_id')
               ->where('rp.product_id' , $item->product_id)
               ->groupBy('rp.product_id')
               ->value('quantity');
               $sales = DB::table('sale_products as sp')
               ->select(DB::raw("SUM(sp.quantity) as quantity"))
               ->join('products as p' , 'p.id' , 'sp.product_id')
               ->where('sp.product_id' , $item->product_id)
               ->groupBy('sp.product_id')
               ->value('quantity');
               $receiving = DB::table('inventories as i')
               ->select(DB::raw("SUM(i.quantity) as quantity"))
               ->join('products as p' , 'p.id' , 'i.product_id')
               ->where('i.product_id' , $item->product_id)
               ->groupBy('i.product_id')
               ->value('quantity');

                if($return == null || $sales == null ){
                    $item->Return_quantity = 0;
                    $item->Sales_quantity = 0;
                }else{
                    $item->Return_quantity = $return;
                    $item->Sales_quantity = $sales;
                }
                $A = $receiving - $item->Return_quantity;
                $item->Onhand = $A - $item->Sales_quantity;
           }
           return $inventory;
    }
    public function filterMonthlyTotal($start, $end){
        $sales = DB::table('sale_products as ss')
        ->select('ss.id','p.product_name' , 'p.sku' , 'ss.sale_id' ,'s.reference_no' , 'r.fullname' , 'ss.quantity', 'ss.product_id' , 's.created_at', 'b.name', 'bx.box_number' )
        ->join('products as p' , 'p.id' , 'ss.product_id')
        ->join('sales as s' , 's.id' , 'ss.sale_id')
        ->join('box_managements as bs' , 'bs.id' , 'p.renter_id')
        ->join('branches as b','b.id' , 'bs.branch')
        ->join('boxes as bx' ,'bx.id' , 'bs.box_id')
        ->join('renters as r' , 'r.id' , 'bs.renter_id')

        ->paginate(50);
        return $sales;
    }
    public function reportsaleshistory(Request $request){
        $sales = DB::table('sale_products as ss')
        ->select('ss.id','p.product_name' , 'p.sku' , 'ss.sale_id' ,'s.reference_no' , 'r.fullname' , 'ss.quantity', 'ss.product_id' , 's.created_at', 'b.name', 'bx.box_number','s.customer_name',DB::raw("DATE(ss.created_at) as created_at"), 'ss.location_id')
        ->join('products as p' , 'p.id' , 'ss.product_id')
        ->join('sales as s' , 's.id' , 'ss.sale_id')
        ->join('box_managements as bs' , 'bs.id' , 'p.renter_id')
        ->join('branches as b','b.id' , 'bs.branch')
        ->join('boxes as bx' ,'bx.id' , 'bs.box_id')
        ->join('renters as r' , 'r.id' , 'bs.renter_id')
        ->join('sale_collections as sc' , 'sc.renter_id' , 'ss.location_id')
        ->where('s.sale_type' ,'=', 'nondirect')
        ->where(function ($query) use ($request) {
            return $query->where('p.product_name','LIKE','%'.$request->renter.'%')
                ->orWhere('p.sku','LIKE','%'.$request->renter.'%')
                ->orWhere('s.reference_no','LIKE','%'.$request->renter.'%')
                ->orWhere('r.fullname','LIKE','%'.$request->renter.'%')
                ->orWhere('b.name','LIKE','%'.$request->renter.'%');
        });
        // if($request->renter){
        //     $sales->where('p.product_name','LIKE','%'.$request->renter.'%');
        //     $sales->orWhere('p.sku','LIKE','%'.$request->renter.'%');
        //     $sales->orWhere('s.reference_no','LIKE','%'.$request->renter.'%');
        //     $sales->orWhere('r.fullname','LIKE','%'.$request->renter.'%');
        //     $sales->orWhere('b.name','LIKE','%'.$request->renter.'%');
        //    }
        if($request->sort){
            $sales->orderBy($request->sort , 'asc');
        }else{
            $sales->orderBy('s.created_at' , 'desc');
        }
           if($request->from != null && $request->to != null){
            $sales->wherebetween(DB::raw("DATE(s.created_at)") , [$request->from , $request->to] );
           }
           if( Auth::check() && Auth::user()->role != "admin"){
            if( Auth::check() && Auth::user()->branch_id){
                $sales->where('b.id', Auth::user()->branch_id);
            }
        }
           $sales = $sales->paginate(50);

        //    $released = DB::table('sale_products as sp')
        //    ->select('sp.id')
        // //    ->leftJoin('sale_collections as sc' , 'sp.location_id' , 'sc.renter_id')
        //    ->whereIn('sp.location_id' ,[2])
        //    ->wherebetween(DB::raw("DATE(sp.created_at)") , ['sc.sales_from' , 'sc.sales_to'] )
        //    ->get();
        //    return $released;
           foreach($sales as $item){
            //    $released = DB::table('sale_products as ss')
            $released = DB::table('sale_products as ss')
            ->select('ss.location_id')
            ->join('sale_collections as sc' , 'sc.renter_id' , 'ss.location_id')
            ->where('ss.id' , $item->id)
            // ->where('sc.renter_id' , 'ss.location_id')
            ->wherebetween(DB::raw("DATE(ss.created_at)") , [DB::raw("DATE(sc.sales_from)") ,DB::raw("DATE(sc.sales_to)")] )
            ->value('ss.location');

            if($released != null){
                $item->status = "Released";
            }else{
                $item->status = "Pending";
            }
            $sellprice = DB::table('sale_products as ss')
            ->select('ss.saleprice')
            ->where('ss.id' , $item->id)
            ->value('ss.saleprice');
            if($sellprice == 'retail'){
             $sell__price = DB::table('sale_products as ss')
             ->select('p.sell_price')
             ->join('products as p' , 'p.id' , 'ss.product_id')
             ->where('ss.id' , $item->id)
             ->value('p.sell_price');
             $item->sell_price = $sell__price;
             $item->totalsales = $sell__price * $item->quantity;
            }else{
             $sell__price = DB::table('sale_products as ss')
             ->select('p.wholesale_price')
             ->join('products as p' , 'p.id' , 'ss.product_id')
             ->where('ss.id' , $item->id)
             ->value('p.wholesale_price');
             $item->sell_price = $sell__price;
             $item->totalsales = $sell__price * $item->quantity;
            }
           }
        $total = 0;
        foreach($sales as $resultItem){
            $total += $resultItem->totalsales;
        }
    $newArray = array([
        'data'  => $sales,
        'total' => $total ,
    ]);
           return $newArray;
    }
    public function reportdirectsales(Request $request){
        $sales = DB::table('sale_products as ss')
        ->select('ss.id','p.product_name' , 'p.sku' , 'ss.sale_id' ,'s.reference_no' , 'r.fullname' , 'ss.quantity', 'ss.product_id' , 's.created_at', 'b.name', 'bx.box_number' , 's.customer_name')
        ->join('products as p' , 'p.id' , 'ss.product_id')
        ->join('sales as s' , 's.id' , 'ss.sale_id')
        ->join('box_managements as bs' , 'bs.id' , 'p.renter_id')
        ->join('branches as b','b.id' , 'bs.branch')
        ->join('boxes as bx' ,'bx.id' , 'bs.box_id')
        ->join('renters as r' , 'r.id' , 'bs.renter_id')
        ->where('s.sale_type' ,'=', 'direct')
        ->where(function ($query) use ($request) {
            return $query->where('p.product_name','LIKE','%'.$request->renter.'%')
                ->orWhere('p.sku','LIKE','%'.$request->renter.'%')
                ->orWhere('s.reference_no','LIKE','%'.$request->renter.'%')
                ->orWhere('r.fullname','LIKE','%'.$request->renter.'%')
                ->orWhere('b.name','LIKE','%'.$request->renter.'%');
        });
        if($request->sort != null){
            $sales->orderBy($request->sort , 'asc');
        }else{
            $sales->orderBy('s.created_at' , 'desc');
        }
           if($request->from != null && $request->to != null){
            $sales->wherebetween(DB::raw("DATE(s.created_at)") , [$request->from , $request->to] );
           }
           if(Auth::check() && Auth::user()->role != "admin"){
            if(Auth::check() && Auth::user()->branch_id){
                $sales->where('b.id', Auth::user()->branch_id);
            }
        }
           $sales = $sales->paginate(50);
           foreach($sales as $item){
               $sellprice = DB::table('sale_products as ss')
               ->select('ss.saleprice')
               ->where('ss.id' , $item->id)
               ->value('ss.saleprice');
               if($sellprice == 'retail'){
                $sell__price = DB::table('sale_products as ss')
                ->select('p.sell_price')
                ->join('products as p' , 'p.id' , 'ss.product_id')
                ->where('ss.id' , $item->id)
                ->value('p.sell_price');
                $item->sell_price = $sell__price;
                $item->totalsales = $sell__price * $item->quantity;
               }else{
                $sell__price = DB::table('sale_products as ss')
                ->select('p.wholesale_price')
                ->join('products as p' , 'p.id' , 'ss.product_id')
                ->where('ss.id' , $item->id)
                ->value('p.wholesale_price');
                $item->sell_price = $sell__price;
                $item->totalsales = $sell__price * $item->quantity;
               }

           }
        $total = 0;
        foreach($sales as $resultItem){
            $total += $resultItem->totalsales;
        }
    $newArray = array([
        'data'  => $sales,
        'total' => $total ,
    ]);
           return $newArray;
    }

    public function reportSalesrel(Request $request){
        $collection = DB::table ('sale_collections as sc')
        ->select('sc.id','sc.amount', 'sc.note' ,  'r.fullname' , 'bs.name' , 'bo.box_number' , 'sc.renter_id' , 'sc.date_released' , 'sc.sales_from' , 'sc.sales_to')
        ->leftjoin('box_managements as b' , 'b.id' , '=' , 'sc.renter_id' )
        ->leftjoin('renters as r' , 'r.id' , '=' , 'b.renter_id')
        ->leftjoin('branches as bs' , 'bs.id' , '=' , 'b.branch')
        ->leftjoin('boxes as bo' , 'bo.id' , '=' , 'b.box_id')
        ->where(function($query) use ($request) {
            $query->where('r.fullname','LIKE','%'.$request->renter.'%')
                ->orWhere('bs.name','LIKE','%'.$request->renter.'%')
                ->orWhere('bo.box_number','LIKE','%'.$request->renter.'%');
        });
        if($request->sort){
            $collection->orderBy($request->sort, 'asc');
          }else{
            $collection->orderBy('sc.id', 'desc');
          }
          if($request->from != null && $request->to != null){
            $collection->whereBetween(DB::raw("DATE(sc.date_released)") , [$request->from , $request->to] );
           }
           if(Auth::check() && Auth::user()->role != "admin"){
            if(Auth::check() && Auth::user()->branch_id){
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
    public function reportcubeSummary(Request $request){
        $cube = DB::table('boxes as bx')
        ->select('bx.box_number' , 'r.fullname' , 'b.name')
        ->leftJoin('box_managements as bs' , 'bs.box_id' , 'bx.id')
        ->leftJoin('renters as r' , 'r.id' , 'bs.renter_id')
        ->leftJoin('branches as b' , 'b.id' , 'bs.branch');
        if($request->renter){
            $cube->where('r.fullname','LIKE','%'.$request->renter.'%');
            $cube->orWhere('b.name','LIKE','%'.$request->renter.'%');
            $cube->orWhere('bx.box_number','LIKE','%'.$request->renter.'%');
        }
        if($request->sort){
            $cube->orderBy($request->sort, 'asc');
          }else{
            $cube->orderBy('bx.id', 'desc');
          }
        if(Auth::check() && Auth::user()->role != "admin"){
            if( Auth::check() && Auth::user()->branch_id){
                $cube->where('b.id', Auth::user()->branch_id);
            }
        }
        $cube = $cube->paginate(50);
        return $cube;
    }

    public function inventoryhistory(Request $request){
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
                ->orWhere('bo.box_number','LIKE','%'.$request->searchForm.'%');
        });
        if($request->from != null && $request->to != null){
            $inventory->whereBetween(DB::raw("DATE(i.date)") , [$request->from , $request->to] );
           }
           if($request->sort){
            $inventory->orderBy($request->sort, 'asc');
          }else{
            $inventory->orderBy('i.id', 'desc');
          }
    if(Auth::check() && Auth::user()->role != "admin"){
        if(Auth::check() && Auth::user()->branch_id){
            $inventory->where('bs.id', Auth::user()->branch_id);
        }
    }

        $inventory = $inventory->paginate(50);

        return $inventory ;
    }

    public function returnSalesReport(Request $request){

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

        if($request->from && $request->to){
          $return->whereDate('rs.date_return', '>=', $request->from);
          $return->whereDate('rs.date_return', '<=', $request->to);
        }

        if($request->sort){
          $return->orderBy($request->sort, 'asc');
        }else{
          $return->orderBy('rs.id','desc');
        }

        if(Auth::check() && Auth::user()->role != "admin"){
          if(Auth::check() && Auth::user()->branch_id){
              $return->where('b.id', Auth::user()->branch_id);
          }
        }
        $return = $return->paginate(50);

        return $return;
    }
}
