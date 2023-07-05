<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BoxManagement;
use App\Rent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class BoxesController extends Controller
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


        $this->boxesValidation($request);

        $boxes = BoxManagement::create([
            'renter_id' => $request->renter_id,
            'branch' => $request->branch,
            'box_id' => $request->box_id,
            'rental_cost' => $request->rental_cost,
            'date_of_contract' => $request->date_of_contract,
            'end_of_contract' => $request->end_of_contract,
            'due_date' => $request->due_date,
            'description' => $request->description
        ]);

        $request->merge(['activity' => 'Add assign cube']);
        $request->merge(['activity_id' => $boxes->id]);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));
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

        $this->boxesValidation($request);

        $boxes = BoxManagement::findOrFail($id);

        $boxes->renter_id = $request->renter_id;
        $boxes->branch = $request->branch;
        $boxes->box_id = $request->box_id;
        $boxes->rental_cost = $request->rental_cost;
        $boxes->date_of_contract = $request->date_of_contract;
        $boxes->end_of_contract = $request->end_of_contract;
        $boxes->due_date = $request->due_date;
        $boxes->description = $request->description;


        $dateToday = Carbon::now();
        $endOfday = $dateToday->lastOfMonth()->format('d');

        $days = Carbon::parse($request->due_date)->format('d');

        $day = $days > $endOfday ? $endOfday : $days;

        $rents = DB::table('rents')
            ->where('renter_id', $request->renter_id)
            ->update(array('due_date' => DB::raw('DATE_FORMAT(due_date, "%Y-%m-'.$day.'")')));

        $request->merge(['activity' => 'Edit assign cube']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));

        $boxes->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $boxes = BoxManagement::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete assign cube']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));
        
        DB::table('box_managements')->where('id', $id)->delete();
    }

    public function searchBox(Request $request){

        $boxes = DB::table('box_managements as b')
            ->select('b.id','r.fullname','b.renter_id','b.branch','br.id as branch_id','br.name','b.description','b.rental_cost','b.due_date','bx.box_number','bx.id as box_id','b.date_of_contract','b.end_of_contract')
            ->join('branches as br','br.id','=','b.branch')
            ->join('renters as r','r.id','=','b.renter_id')
            ->join('boxes as bx','bx.id','=','b.box_id')
            ->where(function($query) use ($request) {
                $query->where('r.fullname','LIKE','%'.$request->box_number.'%')
                ->orWhere('br.name','LIKE','%'.$request->box_number.'%')
                ->orWhere('bx.box_number','LIKE','%'.$request->box_number.'%')
                ->orWhere('b.rental_cost','LIKE','%'.$request->box_number.'%');
            });

            if($request->dateFrom && $request->dateTo){
              $boxes->whereDate('b.due_date', '>=', $request->dateFrom);
              $boxes->whereDate('b.due_date', '<=', $request->dateTo);
            }

            if($request->sort){
              $boxes->orderBy($request->sort, 'asc');
            }else{
                $boxes->orderBy('id','desc');
            }

            // ->where('bx.box_number','LIKE','%'.$request->box_number.'%')
            // ->orWhere('r.fullname','LIKE','%'.$request->box_number.'%');
            // ->orWhere('b.branch','LIKE','%'.$request->box_number.'%')

          if(Auth::user()->role != "admin"){
              if(Auth::user()->branch_id){
                  $boxes->where('br.id', '=', Auth::user()->branch_id);
              }
          }

          $totalVal = self::getTotalVal($boxes);

          $boxes = $boxes->paginate(50);

          $return = collect($boxes)->merge(['totalAmount' => 'PHP ' . number_format($totalVal, 2)]);

        return $return;
    }

    public function getTotalVal($request){
      $request = $request->get();
      $totalAmount = 0;
      foreach ($request as $item) {
        $totalAmount += $item->rental_cost;
      }
      return $totalAmount;
    }

    public function boxList(){
        $boxList = DB::table('box_managements as b')
            ->select('b.id','b.box_number')
            ->get();

        return $boxList;
    }

    public function boxListLocation(){
        
        $boxLocation = DB::table('box_managements as b')
            ->select('b.id','b.branch','bx.box_number','b.box_id as boxid','r.fullname','b.renter_id')
            ->join('renters as r','r.id','=','b.renter_id')
            ->join('boxes as bx','bx.id','=','b.box_id');
            if(Auth::user()->role != "admin"){
                if(Auth::user()->branch_id){
                    $boxLocation->where('b.branch', '=', Auth::user()->branch_id);
                }
            }
        return $boxLocation->get();
    }

    public function boxesValidation($request){

        return $this->validate($request,[
            'renter_id' => 'required',
            'branch' => 'required',
            'box_id' => 'required',
            'rental_cost' => 'numeric|min:0',
            'due_date' => 'required',
            'date_of_contract' => 'required'
        ],
        [
            'renter_id.required' => 'Renter field is required',
            'branch.required'    => 'Branch field is required.',
            'box_id.required'    => 'Box number field is required.',
            'rental_cost.required'    => 'Rental cost field is required.',
            'due_date.required' => 'Due date field is required',
            'date_of_contract.required' => 'Date of contract field is required'
         ]
    );
    }

    public function phpInfo(){
        phpinfo();
    }
}
