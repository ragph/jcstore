<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Box;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

use App\Events\SystemLog\SystemLogEvent;

class BoxManagementController extends Controller
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

        $boxes = Box::create([
            'box_number' => $request->box_number,
            'branch_id' => $request->branch,
            'created_by' => Auth::id(),
        ]);

        $request->merge(['activity' => 'Add cube']);
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

        $boxes = Box::findOrFail($id);

        $boxes->box_number = $request->box_number;
        $boxes->branch_id = $request->branch;
        $boxes->created_by = Auth::id();

        $request->merge(['activity' => 'Edit cube']);
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
        $boxes = Box::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete cube']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $boxes]);

        event(new SystemLogEvent($request));

        DB::table('boxes')->where('id', $id)->delete();
    }

    public function searchBoxManagement(Request $request){
        

        $boxes = DB::table('boxes as b')
            ->select('b.id','b.box_number', 'b.created_by','b.branch_id as branch','br.name')
            ->leftJoin('branches as br','br.id','=','b.branch_id');
            
        
        if($request->sort){
          $boxes->orderBy($request->sort, 'asc');
        }else{
          $boxes->orderBy('b.id', 'desc');
        }
        
        if($request->box_number){
            $boxes
            // ->where('b.box_number','=',$request->box_number);
              ->where(function ($query) use ($request){
                $query
                ->where("b.box_number", '=', $request->box_number)
                ->orWhere("br.name", "LIKE", '%'. $request->box_number .'%');
            });
        }

        

        return $boxes->paginate(50);


    }

    public function loadBoxManagement(){

        $boxes = DB::table('boxes as b')
            ->select('b.id','b.box_number')
            ->whereNotIn('b.id', function($q){

                $dateToday = Carbon::now();
                $today = $dateToday->format('Y-m-d');

                $q->select('box_id')->from('box_managements as bm');
                $q->where('bm.end_of_contract','>=', $today);
            })
            ->get();

        return $boxes;;
    }

    public function loadBoxlist(){
        

        $boxes = DB::table('box_managements as bm')
            ->select('bm.id' , 'r.fullname' , 'bs.name' , 'b.box_number')
            ->join('renters as r' , 'r.id' , '=' , 'bm.renter_id')
            ->join('branches as bs' , 'bs.id' , '=' , 'bm.branch')
            ->join('boxes as b' , 'b.id' , '=' , 'bm.box_id')
            ->orderBy('id','desc');

    if(Auth::user()->role != "admin"){
        if(Auth::user()->branch_id){
            $boxes->where('bs.id', Auth::user()->branch_id);
        }
    }

        return $boxes->get();
    }



    public function boxesValidation($request){
        return $this->validate($request,[
            'box_number' => 'required'
        ],
        [
            'box_number.required'    => 'Box number field is required.'
        ]
    );
    }
}
