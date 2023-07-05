<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class DashboardController extends Controller
{
    //



    public function todaysMonth(){
        $dateToday = Carbon::now();
        $today = $dateToday->format('Y-m-d');

        $month = Carbon::parse($dateToday)->format('m');

        return $month;
    }
    public function dashBoard()
    {
        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Manila');
        $startDate = Carbon::now();
        $year = Carbon::parse( $startDate)->format('Y');
        $sales = DB::table('sales')
                ->select(DB::raw("SUM(total_items) as total") , DB::raw("DATE_FORMAT(created_at, '%M %Y') new_date"), DB::raw("MONTH(created_at) month"))
                ->whereYear('created_at', '>=', $year)
                ->groupBy('new_date','month')
                ->orderBy('month', 'asc')
                ->get();
        // return $sales ;
        $lableForDate = array();
        $labelGross = array();
        foreach($sales as $key => $value1) {
            $date = new Carbon($value1->new_date);
            $lableForDate[] =  $date->format('M Y');
            $labelGross[] = $value1->total;
        }
        $graph = [
            'labels' => $lableForDate,
            'datasets' => array (
                [
                'label' => 'Gross',
                'backgroundColor' => '#f87979',
                'borderColor' => 'red',
                'fill'=> true,
                'data' => $labelGross,
                ],

            )
        ];
        $dataresult = $graph;
        return $dataresult;
    }
    // TOTAL PRODUCTS
    public function totalProducts(){

        $month = $this->todaysMonth();

        $totalProducts = DB::table('products as p')
            ->select(DB::raw('count(id) as total_products'))
            ->whereMonth('p.created_at','=',$month)
            ->get();

        return $totalProducts;
    }

    // TOTAL SALES
    public function totalSales(){

        $month = $this->todaysMonth();

        $totalSales = DB::table('sales as s')
            ->select(DB::raw('SUM(total_items) as total'))
            ->whereMonth('s.created_at','=',$month)
            ->get();

        return $totalSales;
    }

    // TOTAL RENTERS
    public function totalRenters(){
        $month = $this->todaysMonth();

        $totalRenters = DB::table('renters as r')
            ->select(DB::raw('count(id) as total_renters'))
            ->whereMonth('r.date_registered','=',$month)
            ->get();

        return $totalRenters;
    }

    // TOTAL COLLECTIONS
    public function totalCollections(){

        $month = $this->todaysMonth();

        $box_managements = DB::table('box_managements as bm')
            ->select('bm.renter_id','bm.rental_cost','bm.due_date','br.name','bm.box_id')
            ->join('branches as br','br.id','=','bm.branch');
        

        $totalCollections = DB::table('billings as bill')
            ->select(DB::raw('SUM(bm.rental_cost) as collection'))
            ->join('renters as rnt','rnt.id','=','bill.renter_id')
            ->join('boxes as b','b.id','=','bill.box_id')
            ->leftJoinSub($box_managements, 'bm', function ($join) {
                $join->on('bm.renter_id', '=', 'bill.renter_id');
                $join->on('bm.box_id', '=', 'bill.box_id');
            })
            ->whereMonth('bill.created_at','=',$month)
            ->first();
        
        return $totalCollections->collection;
    }

    public function salesByMonth(){
        $startDate = Carbon::now();
        $year = Carbon::parse( $startDate)->format('Y');

        $totalSales = DB::table('sales as s')
            ->select('s.created_at')
            ->whereYear('s.created_at', '>=', $year)
            ->groupBy('s.created_at')
            ->get();

        return $totalSales ;
    }

    public function topSellingItems(){
        $top_selling_items = DB::table('sale_products as sp')
            ->select(DB::raw('count(sp.product_id) as total_product'),'p.product_name')
            ->join('products as p','p.id','=','sp.product_id')
            ->groupBy('p.id')
            ->orderBy('total_product','desc')
            ->paginate(9);

        return $top_selling_items;
    }

    public function topRenters(){
        $month = $this->todaysMonth();

        $renters = DB::table('sale_products as ss')
        ->select('p.product_name' , 'r.fullname', DB::raw("SUM(ss.quantity) as quantity") ,'bx.box_number' ,'bs.date_of_contract', 'b.name' )
        ->join('sales as s' , 's.id' , 'ss.sale_id')
        ->join('products as p' , 'p.id' , 'ss.product_id')
        ->join('box_managements as bs' , 'bs.id' , 'p.renter_id')
        ->join('renters as r' , 'r.id' , 'bs.renter_id')
        ->join('boxes as bx' , 'bx.id' , 'bs.box_id')
        ->join('branches as b' , 'b.id' , 'bs.branch')
        ->whereMonth( 's.created_at', $month )
        ->groupBy('ss.product_id')
        ->orderBy('quantity' , 'desc')
        ->paginate(10);
        return $renters;
    }

    public function duesCollectibles(){

        $dateToday = Carbon::now();
        $today = $dateToday->format('Y-m-d');

        $year = Carbon::parse($dateToday)->format('Y');
        $month = Carbon::parse($dateToday)->format('m');

        $rents = DB::table('rents as r')
        ->select('r.id','r.due_date','b.box_number','rnt.fullname','bm.rental_cost','r.status','bm.id as bm_box_id', 'brnch.name as branch')
        ->join('box_managements as bm','bm.box_id','=','r.box_id')
        ->join('boxes as b','b.id','=','bm.box_id')
        ->join('branches as brnch','brnch.id','=','bm.branch')
        ->join('renters as rnt','rnt.id','=','r.renter_id')
        ->orderBy('r.due_date','desc')
        ->whereNotIn('r.box_id', function($query) {
            $query->select('box_id')
                  ->from('billings');
        })
        ->where('r.status','=','Unpaid')
        ->whereYear('r.due_date','<=',$year)
        ->whereMonth('r.due_date','<=',$month);

        $rents = $rents->paginate(10);

        return $rents;
    }

    public function dashboardCollection(){
        $dashboard["totalproducts"] = $this->totalProducts();
        $dashboard['totalsales'] = $this->totalSales();
        $dashboard['totalrenters'] = $this->totalRenters();
        $dashboard['totalcollections'] = $this->totalCollections();
        $dashboard['salesbymonth'] = $this->salesByMonth();
        $dashboard['topsellingItems'] = $this->topSellingItems();
        $dashboard['toprenters'] = $this->topRenters();
        $dashboard['duescollectibles'] = $this->duesCollectibles();

        return $dashboard;
    }
}