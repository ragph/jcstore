<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rent;
use App\Renter;
use Carbon\Carbon;
use App\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class RentController extends Controller
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

        if($request->is_cheque){
            $this->billingValidation($request);
        }else{
            $this->billingValidationCash($request);
        }


        $boxLocation = DB::table('box_managements as b')
            ->select('b.id','b.box_id as boxid')
            ->where('b.id','=', $request->box_id)
            ->first();

        $checkBill = $this->checkIfAlreadyPaid($request);

        if($checkBill->isEmpty()){
            $bills = Billing::create([
                'box_id' => $boxLocation->boxid,
                'cheque_number' => $request->cheque_number,
                'bank' => $request->bank,
                'month_covered' => $request->monthcovered,
                'amount' => $request->amount,
                'renter_id' => $request->renter_id,
                'cash' => $request->cash,
                'is_cheque' => $request->is_cheque
            ]);

            $request->merge(['activity' => 'Add billing']);
            $request->merge(['activity_id' => $bills->id]);
            $request->merge(['details' => $bills]);

            event(new SystemLogEvent($request));


            $month = Carbon::parse($request->monthcovered)->format('m');
            $year = Carbon::parse($request->monthcovered)->format('Y');

            $rent = DB::table('rents')
                ->where('box_id', $bills->box_id)
                ->whereYear('due_date','=',$year)
                ->whereMonth('due_date','=',$month)
                ->update(['status' => 'Paid']);

            $info = array("icon" => "success", "message" => "Record has been successfully updated.", 'status' => 'Success');
            return $info;
        }else{
            $info = array("icon" => "info", "message" => "This record has already paid.", 'status' => "Information");
            return $info;
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
        if($request->is_cheque){
            $this->billingValidation($request);
        }else{
            $this->billingValidationCash($request);
        }

    //   $this->billingValidation($request);

       $checkBill = $this->checkIfAlreadyPaid($request);

       $boxLocation = DB::table('box_managements as b')
            ->select('b.id','b.box_id as boxid')
            ->where('b.id','=', $request->box_id)
            ->first();

       if($checkBill->isEmpty()){

        $bills = Billing::findOrFail($id);


        $request->merge(['activity' => 'Update billing']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $bills]);

        event(new SystemLogEvent($request));

        $bills->box_id = $boxLocation->boxid;
        $bills->cheque_number = $request->cheque_number;
        $bills->bank = $request->bank;
        $bills->month_covered = $request->monthcovered;
        $bills->amount = $request->amount;




            $bills->save();
            $info = array("icon" => "success", "message" => "Record has been successfully updated.", 'status' => 'Success');
            return $info;
        }
        else{

            $bills = Billing::findOrFail($id);


            $request->merge(['activity' => 'Update billing']);
            $request->merge(['activity_id' => $id]);
            $request->merge(['details' => $bills]);
    
            event(new SystemLogEvent($request));

            $info = array("icon" => "success", "message" => "Record has been successfully updated.", 'status' => 'Success');
            return $info;
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bills = Billing::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete billing']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $bills]);

        event(new SystemLogEvent($request));

        DB::table('rents')
        ->where('renter_id', $bills->renter_id)
        ->where('box_id', $bills->box_id)
        ->whereDate('due_date', $bills->month_covered)
        ->update(['status' => 'Unpaid']);

        DB::table('billings')->where('id', $id)->delete();
    }

    public function searchDueDate(Request $request)
    {

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
            // ->orderBy('r.due_date','desc')
            ->whereNotIn('r.box_id', function($query) {
                $query->select('box_id')
                      ->from('billings');
            });

          $rents->where(function ($query) use ($request){
              $query
              ->where("rnt.fullname", "LIKE", '%'. $request->searchinpt .'%')
              ->orWhere("brnch.name", "LIKE", '%'. $request->searchinpt .'%')
              ->orWhere("b.box_number", $request->searchinpt)
              ->orWhere("bm.rental_cost", $request->searchinpt);
          });

          if($request->dateFrom && $request->dateTo){
            $rents->whereDate('r.due_date', '>=', $request->dateFrom);
            $rents->whereDate('r.due_date', '<=', $request->dateTo);
          }

          if($request->sort){
            $rents->orderBy($request->sort, 'asc');
          }else{
            $rents->orderBy('r.due_date','desc');
          }

          if(Auth::user()->role != "admin"){
              if(Auth::user()->branch_id){
                  $rents->where('brnch.id', Auth::user()->branch_id);
              }
          }

        // if($request->dateFrom && $request->dateTo){
        //     $rents->whereBetween('r.due_date', [$request->dateFrom, $request->dateTo]);
        //     if($request->sortBy){
        //         $rents->orderBy('r.due_date', $request->sortBy);
        //     }else{
        //         $rents->orderBy('r.due_date', 'desc');
        //     }
        // }else{
        //     $rents->whereYear('r.due_date','<=',$year);
        //     $rents->whereMonth('r.due_date','<=',$month);
        // }


        // if($request->sort){
        //     if($request->sortBy){
        //         $rents->orderBy($request->sort,$request->sortBy);
        //     }else{
        //         $rents->orderBy($request->sort,'desc');
        //     }
        // }

        $totalVal = self::getTotalVal($rents);
        $rents = $rents->paginate(50);

        foreach($rents as $rent){

            $year = Carbon::parse($rent->due_date)->format('Y');
            $month = Carbon::parse($rent->due_date)->format('m');

            $billings = DB::table('billings as b')
                ->select('b.id')
                ->where('b.box_id','=',$rent->bm_box_id)
                ->whereYear('month_covered', $year)
                ->whereMonth('month_covered', $month)
                ->get();

            if($billings->isEmpty()){
                $duedate = Carbon::parse($rent->due_date)->format('Y-m-d');
                if(strtotime($today) > strtotime($duedate)){
                    $rent->status = 'Over due';
                }else{
                    $rent->status = 'Unpaid';
                }

            }
        }
        $return = collect($rents)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);

        return $return;
    }

    public function searchPaidDate(Request $request)
    {
        $dateToday = Carbon::now();
        $today = $dateToday->format('Y-m-d');

        $box_managements = DB::table('box_managements as bm')
            ->select('bm.renter_id','bm.rental_cost','bm.due_date','br.name','bm.box_id')
            ->join('branches as br','br.id','=','bm.branch');


        $billings = DB::table('billings as bill')
                 ->select('bill.id','bill.box_id as box_id','bill.cheque_number as cheque_number','bill.bank as bank','bill.month_covered as monthcovered','bill.amount as amount','bm.renter_id','bm.rental_cost as rental_cost','b.box_number as box_number','rnt.fullname','bm.due_date as month_covered','bm.name as branch' , 'b.id as boxid','bill.created_at','bill.cash','bill.is_cheque')
            ->join('renters as rnt','rnt.id','=','bill.renter_id')
            ->join('boxes as b','b.id','=','bill.box_id')
            ->leftJoinSub($box_managements, 'bm', function ($join) {
                $join->on('bm.renter_id', '=', 'bill.renter_id');
                $join->on('bm.box_id', '=', 'bill.box_id');
            });



    $billings->where(function ($query) use ($request){
        $query
        ->where("rnt.fullname", "LIKE", '%'. $request->searchinpt .'%')
        ->orWhere("bm.name", "LIKE", '%'. $request->searchinpt .'%')
        ->orWhere("b.box_number", $request->searchinpt)
        ->orWhere("bm.rental_cost", $request->searchinpt);
    });

    if($request->dateFrom && $request->dateTo){
      $billings->whereDate('bill.month_covered', '>=', $request->dateFrom);
      $billings->whereDate('bill.month_covered', '<=', $request->dateTo);
    }

    if($request->sort){
      $billings->orderBy($request->sort, 'asc');
    }else{
      $billings->orderBy('bill.id','desc');
    }

    if(Auth::user()->role != "admin"){
        if(Auth::user()->branch_id){
            $billings->where('brnch.id', Auth::user()->branch_id);
        }
    }


        $totalVal = self::getTotalVal($billings);
        $billings = $billings->paginate(50);

        foreach($billings as &$billing){
            $billing->status = 'Paid';
        }
        $return = collect($billings)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);
        return $return;
    }

    public function searchAllRent(Request $request)
    {
        $dateToday = Carbon::now();
        $today = $dateToday->format('Y-m-d');

        $rents = DB::table('rents as r')
            ->select('r.id','r.due_date as due_date','b.box_number as box_number','rnt.fullname as fullname','bm.rental_cost as rental_cost','r.status as status','bm.id as bm_box_id','brnch.name as branch')
            ->join('box_managements as bm','bm.box_id','=','r.box_id')
            ->join('boxes as b','b.id','=','bm.box_id')
            ->join('branches as brnch','brnch.id','=','bm.branch')
            ->join('renters as rnt','rnt.id','=','r.renter_id');

        $rents->where(function ($query) use ($request){
            $query
            ->where('rnt.fullname','LIKE','%'.$request->searchinpt.'%')
            ->orWhere("brnch.name", 'LIKE', '%' . $request->searchinpt . '%')
            ->orWhere("b.box_number", $request->searchinpt)
            ->orWhere("bm.rental_cost", $request->searchinpt);
        });

        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $rents->where('brnch.id', Auth::user()->branch_id);
            }
        }


        if($request->dateFrom && $request->dateTo){
            $rents->whereBetween('r.due_date', [$request->dateFrom, $request->dateTo]);
            if($request->sortBy){
                $rents->orderBy('r.due_date', $request->sortBy);
            }else{
                $rents->orderBy('r.due_date', 'desc');
            }
        }
        if($request->sort){
            if($request->sortBy){
                $rents->orderBy($request->sort,$request->sortBy);
            }else{
                $rents->orderBy($request->sort,'desc');
            }
        }

        $totalVal = self::getTotalVal($rents);
        $rents = $rents->paginate(50);

        foreach($rents as $rent){

            if($rent->status != 'Paid'){
                $year = Carbon::parse($rent->due_date)->format('Y');
                $month = Carbon::parse($rent->due_date)->format('m');

                $billings = DB::table('billings as b')
                    ->select('b.id')
                    ->where('b.box_id','=',$rent->bm_box_id)
                    ->whereYear('month_covered', $year)
                    ->whereMonth('month_covered', $month)
                    ->get();

                if($billings->isEmpty()){
                    $duedate = Carbon::parse($rent->due_date)->format('Y-m-d');
                    if(strtotime($today) > strtotime($duedate)){
                        $rent->status = 'Over due';
                    }else{
                        $rent->status = 'Unpaid';
                    }
                }
            }

        }

        $return = collect($rents)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);
        return $return;
    }

    public function getTotalVal($result){
      $result = $result->get();
      $totalAmount = 0;
      foreach ($result as $item) {
        $totalAmount += $item->rental_cost;
      }

      return $totalAmount;
    }

    public function createDueDate(Request $request){

        // return $request;

        // return $request->date;
        $this->createDuedateValidation($request);
        $startDate = Carbon::now();

        $year = Carbon::parse($request->date)->format('Y');
        $month = Carbon::parse($request->date)->format('m');

        $endOfday = $startDate->lastOfMonth()->format('d');

        $boxes = DB::table('box_managements as b')
            ->select('b.id','b.due_date','b.box_id','b.renter_id')
            ->whereYear('b.end_of_contract', '>=', $year)
            ->whereMonth('b.end_of_contract', '>=', $month)
            ->get();


        foreach($boxes as $box){

            $days = Carbon::parse($box->due_date)->format('d');

            $day = $days > $endOfday ? $endOfday : $days;
            $date = $year.'-'.$month.'-'.$day;

            $billings = DB::table('billings as b')
                ->select('id','box_id','month_covered')
                ->whereYear('month_covered', $year)
                ->whereMonth('month_covered', $month)
                ->where('b.box_id','=', $box->id)
                ->get();

            $rents = DB::table('rents as r')
                ->select('r.id')
                ->whereYear('r.due_date', $year)
                ->whereMonth('r.due_date', $month)
                ->where('r.box_id','=', (int)$box->box_id)
                ->where('r.renter_id','=', $box->renter_id)
                ->get();


            if($rents->isEmpty()){
                if($billings->isEmpty()){
                    $rent = Rent::updateOrCreate([
                        'renter_id' => $box->renter_id,
                        'box_id' => $box->box_id,
                        'due_date' => $date,
                        'status' => 'Unpaid'
                    ]);

                    $request->merge(['activity' => 'Generate billing statement']);
                    $request->merge(['activity_id' => $rent->id]);
                    $request->merge(['details' => $rent]);

                    event(new SystemLogEvent($request));
                }else{
                    $rent = Rent::updateOrCreate([
                        'renter_id' => $box->renter_id,
                        'box_id' => $box->box_id,
                        'due_date' => $date,
                        'status' => 'Paid'
                    ]);

                    $request->merge(['activity' => 'Generate billing statement']);
                    $request->merge(['activity_id' => $rent->id]);
                    $request->merge(['details' => $rent]);

                    event(new SystemLogEvent($request));
                }
            }

            // END CREATE DUES DATA EVERY MONTH
        }
        return $boxes;
    }


    public function createDueDateByUser(Request $request){
        // return $request->date;

        $this->createDuedateValidation($request);

        $startDate = Carbon::now();
        // $year = $startDate->firstOfMonth()->format('Y');
        // $month = $startDate->firstOfMonth()->format('m');

        $year = Carbon::parse($request->date)->format('Y');
        $month = Carbon::parse($request->date)->format('m');

        $endOfday = $startDate->lastOfMonth()->format('d');

        $boxes = DB::table('box_managements as b')
            ->select('b.id','b.due_date','b.box_id','b.renter_id')
            ->whereYear('b.end_of_contract', '>=', $year)
            ->whereMonth('b.end_of_contract', '>=', $month);

        if($request->id){
            $boxes->where('b.renter_id','=',$request->id);
        }

        $boxes = $boxes->get();



        foreach($boxes as $box){

            $days = Carbon::parse($box->due_date)->format('d');

            $day = $days > $endOfday ? $endOfday : $days;
            $date = $year.'-'.$month.'-'.$day;

            $billings = DB::table('billings as b')
                ->select('id','box_id','month_covered')
                ->whereYear('month_covered', $year)
                ->whereMonth('month_covered', $month)
                ->where('b.box_id','=', $box->id)
                ->get();


            if($billings->isEmpty()){
                Rent::updateOrCreate([
                    'renter_id' => $box->renter_id,
                    'box_id' => $box->box_id,
                    'due_date' => $date,
                    'status' => 'Unpaid'
                ]);
            }else{
                Rent::updateOrCreate([
                    'renter_id' => $box->renter_id,
                    'box_id' => $box->box_id,
                    'due_date' => $date,
                    'status' => 'Paid'
                ]);
            }
            // END CREATE DUES DATA EVERY MONTH
        }
        return "Success";
    }

    public function monthCoveredList(Request $request){

        $rents = DB::table('rents')
            ->select('id','box_id','due_date')
            ->where('box_id','=', $request->id)
            ->where('renter_id','=', $request->renter_id)
            ->where('status','!=','Paid');
        return $rents->get();
    }

    public function monthCollectedList(Request $request){

        $rents = DB::table('rents')
            ->select('id','box_id','due_date')
            ->where('box_id','=', $request->boxid)
            ->where('renter_id','=', $request->renter_id);


        return $rents->get();
    }

    public function paymentRentAmount(Request $request){

        $box_managements = DB::table('box_managements as bm')
            ->select('bm.rental_cost')
            ->where('bm.box_id','=',$request->id)
            ->first();

        $amount = sprintf("%.2f", $box_managements->rental_cost);

        return $amount;
    }

    public function billingValidation($request){

        return $this->validate($request,[
                'box_id' => 'required',
                'monthcovered' => 'required',
                'amount' => 'numeric|min:0',
                'bank' => 'required',
                'cheque_number' => 'required'
            ],
            [
                'box_id.required'    => 'Renter/seller field is required.',
                'monthcovered.required'    => 'Month covered field is required.',
                'amount.required' => 'Amount number is required',
                'bank.required' => 'Bank field is required',
                'cheque_number' => 'Cheque field is required'
            ]
        );
    }

    public function billingValidationCash($request){

        return $this->validate($request,[
                'box_id' => 'required',
                'monthcovered' => 'required',
                'cash'  => 'required|integer|min:'.$request->amount,
                'amount' => 'numeric|min:0',
            ],
            [
                'box_id.required'    => 'Renter/seller field is required.',
                'monthcovered.required'    => 'Month covered field is required.',
                'amount.required' => 'Amount number is required',
                'cash.requried' => 'Cash field is required'
            ]
        );
    }

    public function checkIfAlreadyPaid($request){


        $month = Carbon::parse($request->monthcovered)->format('m');
        $year = Carbon::parse($request->monthcovered)->format('Y');

        $checkBills = DB::table('billings as b')
            ->select('b.id')
            ->where('b.box_id', $request->box_id)
            ->whereYear('b.month_covered','=',$year)
            ->whereMonth('b.month_covered','=',$month)
            ->get();

        return $checkBills;
    }

    public function createDuedateValidation($request){
        return $this->validate($request,[
                'date' => 'required'
            ],
            [
                'date.required'    => 'Date field is required.'
            ]
        );
    }
}
