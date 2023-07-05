<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
class RenterViewController extends Controller
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
        //
    }


    // renter profile
    public function renterProfile(Request $request){

        $profile = DB::table('renters as r')
        ->select('r.id','r.fullname' , 'r.address' , 'r.contact_number' , 'r.email' , 'r.date_registered' , 'u.username' , 'u.role' , 'b.name','bx.box_number' )
        ->join('users as u' , 'u.renter_id' , '=' , 'r.id')
        ->join('box_managements as bs' , 'bs.renter_id' , 'u.renter_id')
        ->join('branches as b' , 'b.id' , 'u.branch_id')
        ->join('boxes as bx' ,'bx.id' , 'bs.box_id')
        ->where('r.id' , $request->userid)
        ->get();

        return $profile;
    }
    // renter products

    public function renterProducts(Request $request){

        $products = DB::table('products as ps')
        ->select('ps.id','ps.product_name' , 'ps.sku' , 'ps.cost_price' , 'ps.sell_price' , 'ps.stock_level')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid);

        if($request->searchForm){
            $products->where(function ($query) use ($request) {
                $query->where('ps.sku','LIKE','%'.$request->searchForm.'%');
                $query->orWhere('ps.product_name','LIKE','%'.$request->searchForm.'%');
            });
        }
        $products = $products->paginate(50);

        foreach($products as $item){
            $inventory = DB::table('inventories as i')
            ->select(DB::raw("SUM(i.quantity) as inv_quantity"))
            ->where('i.product_id' , $item->id)
            ->groupBy('i.location_id' , 'i.product_id')
            ->value('inv_quantity');
            $return = DB::table('return_products as rp')
            ->select(DB::raw("SUM(rp.quantity) as inv_quantity"))
            ->where('rp.product_id' , $item->id)
            ->groupBy('rp.location_id' , 'rp.product_id')
            ->value('inv_quantity');
            $sales = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as sale_quantity"))
            ->where('sp.product_id' , $item->id)
            ->groupBy('sp.location_id' , 'sp.product_id')
            ->value('sale_quantity');

            if($return == null){
                $item->return_total = 0;
            }else{
                $item->return_total = $return;
            }
            if($sales == null){
                $item->sale_total = 0;
            }else{
                $item->sale_total = $sales;
            }
            if($inventory == null ){
                $item->inv_total = 0;
            }else{
                $item->inv_total = $inventory;
            }
            $inve_return = $inventory - $return;
            $item->returnandinventory =  $inve_return;
            $item->final_onhand =  $inve_return - $sales;
        }
        return $products;
    }

    // renter inventory
    public function renterInventory(Request $request){
        $inventory = DB::table('products as ps')
        ->select('ps.id','ps.product_name' , 'ps.sku' ,'b.name' , 'bx.box_number' , 'i.date' , 'i.quantity')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->join('inventories as i' , 'i.product_id' , 'ps.id')
        ->join('branches as b' , 'b.id' , 'bs.branch')
        ->join('boxes as bx' , 'bx.id' , 'bs.box_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->orderBy('i.date' , 'asc');

        if($request->searchForm){
            $inventory->where(function ($query) use ($request) {
                $query->where('ps.sku','LIKE','%'.$request->searchForm.'%');
                $query->orWhere('ps.product_name','LIKE','%'.$request->searchForm.'%');
            });
        }
        if($request->date){
            $inventory->where(function ($query) use ($request) {
                $query->where('i.date','LIKE','%'.$request->date.'%');
            });
        }
        $inventory = $inventory->paginate(50);
        return $inventory;

    }
    // renter product returns
    public function renterProductReturns(Request $request){
        $return = DB::table('products as ps')
        ->select('ps.id','ps.product_name' , 'ps.sku' , 'rp.date')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->join('return_products as rp' , 'rp.product_id' , 'ps.id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->groupBy('rp.product_id' , 'rp.date');

        if($request->searchForm){
            $return->where(function ($query) use ($request) {
                $query->where('ps.sku','LIKE','%'.$request->searchForm.'%');
                $query->orWhere('ps.product_name','LIKE','%'.$request->searchForm.'%');
            });
        }
        if($request->date){
            $return->where(function ($query) use ($request) {
                $query->where('rp.date','LIKE','%'.$request->date.'%');
            });
        }


        $return = $return->paginate(50);

        return $return;
    }
    // renter sales history
    public function renterSalesHistory(Request $request){
        $sales = DB::table('products as ps')
        ->select('ps.id','ps.product_name' , 'ps.sku' , 's.created_at' , 'sp.id as saleid' , 's.reference_no' )
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->join('sale_products as sp' , 'sp.product_id' , 'ps.id')
        ->join('sales as s' , 's.id' , 'sp.sale_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid);

        if($request->searchForm){
            $sales->where(function ($query) use ($request) {
                $query->where('ps.product_name','LIKE','%'.$request->searchForm.'%');
                $query->orWhere('ps.sku','LIKE','%'.$request->searchForm.'%');
                $query->orWhere('s.reference_no','LIKE','%'.$request->searchForm.'%');
            });
        }
        if($request->date){
            $sales->where(function ($query) use ($request) {
                $query->where('s.created_at','LIKE','%'.$request->date.'%');
            });
        }
        $sales = $sales->paginate(50);

        foreach($sales as $item){
            $total = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as quantity"))
            ->where('sp.id' , $item->saleid)
            ->groupBy('sp.location_id' , 'sp.product_id')
            ->value('sp.quantity');

            $total_amount = DB::table('products as ps')
            ->select('ps.sell_price')
            ->where('ps.id' , $item->id)
            ->value('ps.sell_price');
            $item->quantity = $total;
            $item->amount = $total_amount;
            $item->totalamount = $total_amount  * $total;

        }
        return $sales;
    }
    // renter boxes
    public function renterBoxes(Request $request){

        $boxes = DB::table('box_managements as bs')
        ->select('bs.date_of_contract', 'b.name' , 'bx.box_number' ,'bs.rental_cost')
        ->join('branches as b' , 'b.id' , '=' , 'bs.branch')
        ->join('boxes as bx' , 'bx.id' , '=' , 'bs.box_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        // ->groupBy('bs.renter_id' , 'bs.date_of_contract')
        ->paginate(50);

        return $boxes;
    }
    // renter rent manager
    public function renterRentManager(Request $request){
            $rent = DB::table('billings as b')
            ->select('b.cheque_number' , 'b.bank' , 'b.month_covered','b.box_id' , 'br.name' , 'bx.box_number' , 'b.amount' ,DB::raw("MONTH(b.month_covered) month") , 'r.status')
            ->leftJoin('box_managements as bs' , 'bs.box_id' ,'b.box_id' )
            ->leftJoin('branches as br' , 'br.id' ,'bs.branch' )
            ->leftJoin('boxes as bx' , 'bx.id' ,'bs.box_id' )
            ->leftJoin('rents as r' , 'r.box_id' , 'b.box_id')
            ->whereDate('b.month_covered' , 'LIKE','%'.$request->date.'%')
            ->where('r.status' , 'Paid')
            ->where('bs.renter_id' , $request->userid)
            ->where('bs.branch' , $request->branchid)
            ->paginate(50);

            return $rent;
    }

    public function DuesRenterManager(Request $request){
        $dues = DB::table('rents as r')
        ->select('b.name' , 'bx.box_number' , 'r.due_date' , 'r.status')
        ->join('box_managements as bs' , 'bs.box_id' , 'r.box_id')
        ->join('branches as b', 'b.id' , 'bs.branch')
        ->join('boxes as bx' , 'bx.id' , 'bs.box_id')
        ->where('r.status' , 'Unpaid')
        ->whereDate('r.due_Date' , 'LIKE','%'.$request->date.'%')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->orderBy('r.due_date')
        ->paginate(50);

        return $dues;

    }

    public function renterDashboardDAILY(Request $request){

        $salestoday = DB::table('sale_products as sp')
        ->select('ps.product_name' , 'ps.sku' , 'sp.product_id')
        ->join('sales as s' , 's.id' , 'sp.sale_id')
        ->join('products as ps' , 'ps.id' , 'sp.product_id')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->whereDate('s.created_at', Carbon::today())
        ->groupBy('sp.product_id')
        ->get();

        foreach($salestoday as $item){
            $total_amount = DB::table('products as ps')
            ->select('ps.sell_price')
            ->where('ps.id' , $item->product_id)
            ->value('ps.sell_price');

            $totalquantity = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as quantity"))
            ->join('sales as s' , 's.id' , 'sp.sale_id')
            ->join('products as ps' , 'ps.id' , 'sp.product_id')
            ->whereDate('s.created_at', Carbon::today())
            ->where('ps.id' ,$item->product_id )
            ->groupBy('sp.product_id')
            ->value('quantity');

            $item->quantitysale = $totalquantity;
            $item->amount = $total_amount;
            $item->totalsaletoday = $total_amount * $totalquantity;
        }
        $totalsale = 0;
        foreach($salestoday as $resultItem){
                $totalsale += $resultItem->totalsaletoday;
        }
        $newArray = array([
            'data'  => $salestoday,
            'price' => $totalsale ,
            'datetoday' => Carbon::today()
        ]);
        return $newArray;
    }

    public function renterDashboardMONTH(Request $request){
        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Manila');
        $serverDate = $carbon->format('m-Y');

        $saleMonth = DB::table('sale_products as sp')
        ->select('ps.product_name' , 'ps.sku' , 'sp.product_id')
        ->join('sales as s' , 's.id' , 'sp.sale_id')
        ->join('products as ps' , 'ps.id' , 'sp.product_id')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->where(DB::raw("DATE_FORMAT(s.created_at, '%m-%Y')"),'=',"$serverDate")
        ->groupBy('sp.product_id')
        ->get();

        foreach($saleMonth as $item){
            $total_amount = DB::table('products as ps')
            ->select('ps.sell_price')
            ->where('ps.id' , $item->product_id)
            ->value('ps.sell_price');

            $totalquantity = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as quantity"))
            ->join('sales as s' , 's.id' , 'sp.sale_id')
            ->join('products as ps' , 'ps.id' , 'sp.product_id')
            ->where(DB::raw("DATE_FORMAT(s.created_at, '%m-%Y')"),'=',"$serverDate")
            ->where('ps.id' ,$item->product_id )
            ->groupBy('sp.product_id')
            ->value('quantity');

            $item->quantitysale = $totalquantity;
            $item->amount = $total_amount;
            $item->totalsaletoday = $total_amount * $totalquantity;
        }
        $totalsale = 0;
        foreach($saleMonth as $resultItem){
                $totalsale += $resultItem->totalsaletoday;
        }
        $newArray = array([
            'data'  => $saleMonth,
            'price' => $totalsale ,
            'datetoday' => Carbon::today()
        ]);
        return $newArray;
    }
    public function renterDashboardWEEK(Request $request){
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $saleWeek = DB::table('sale_products as sp')
        ->select('ps.product_name' , 'ps.sku' , 'sp.product_id')
        ->join('sales as s' , 's.id' , 'sp.sale_id')
        ->join('products as ps' , 'ps.id' , 'sp.product_id')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->whereBetween('s.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->groupBy('sp.product_id')
        ->get();

        foreach($saleWeek as $item){
            $total_amount = DB::table('products as ps')
            ->select('ps.sell_price')
            ->where('ps.id' , $item->product_id)
            ->value('ps.sell_price');

            $totalquantity = DB::table('sale_products as sp')
            ->select(DB::raw("SUM(sp.quantity) as quantity"))
            ->join('sales as s' , 's.id' , 'sp.sale_id')
            ->join('products as ps' , 'ps.id' , 'sp.product_id')
            ->whereBetween('s.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('ps.id' ,$item->product_id )
            ->groupBy('sp.product_id')
            ->value('quantity');

            $item->quantitysale = $totalquantity;
            $item->amount = $total_amount;
            $item->totalsaletoday = $total_amount * $totalquantity;
        }
        $totalsale = 0;
        foreach($saleWeek as $resultItem){
                $totalsale += $resultItem->totalsaletoday;
        }
        $newArray = array([
            'data'  => $saleWeek,
            'price' => $totalsale ,
            'datetoday' => Carbon::today()
        ]);
        return $newArray;

    }

    public function lasttransaction(Request $request){
        $sales = DB::table('sale_products as sp')
        ->select('ps.product_name' , 'ps.sku' , 'sp.quantity' , 'sp.product_id','sp.id' , 's.created_at')
        ->join('products as ps' , 'ps.id' , 'sp.product_id')
        ->join('sales as s' , 's.id' , 'sp.sale_id')
        ->join('box_managements as bs' , 'bs.id' , 'ps.renter_id')
        ->where('bs.renter_id' , $request->userid)
        ->where('bs.branch' , $request->branchid)
        ->limit(5)
        ->orderBy('sp.id', 'desc')
        ->get();

        foreach($sales as $item){
            $quantitysales =  DB::table('sale_products as sp')
            ->select('sp.quantity')
            ->where('sp.id' , $item->id)
            ->value('sp.quantity');

            $total_amount = DB::table('products as ps')
            ->select('ps.sell_price')
            ->where('ps.id' , $item->product_id)
            ->value('ps.sell_price');
            $item->price_prod=$total_amount;
            $item->quantity=$quantitysales;
            $item->totalcollect = $total_amount * $quantitysales;

        }

        return $sales;

    }


}
