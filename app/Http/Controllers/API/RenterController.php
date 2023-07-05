<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Renter;
use App\RenterBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Events\SystemLog\SystemLogEvent;

class RenterController extends Controller
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
        $this->renterValidation($request);

        $renter = Renter::create([
            'fullname' => $request->fullname,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'date_registered' => $request->date_registered,
        ]);

        $request->merge(['activity' => 'Add renter']);
        $request->merge(['activity_id' => $renter->id]);
        $request->merge(['details' => $renter]);

        event(new SystemLogEvent($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function show(Renter $renter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function edit(Renter $renter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->renterValidation($request);

        $renterdata = Renter::findOrFail($id);

        $renterdata->fullname = $request->fullname;
        $renterdata->address = $request->address;
        $renterdata->contact_number = $request->contact_number ;
        $renterdata->email = $request->email;
        $renterdata->date_registered = $request->date_registered;

        $request->merge(['activity' => 'Edit renter']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $renterdata]);

        event(new SystemLogEvent($request));

        $renterdata->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $renter = Renter::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete renter']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $renter]);

        event(new SystemLogEvent($request));

        DB::table('renters')->where('id', $renter->id)->delete();
    }

    public function searchRenter(Request $request){
        $renter = DB::table('renters as r')
            ->select('r.id','r.fullname','r.address','r.contact_number','r.email', 'r.date_registered')
            // ->where('r.fullname','LIKE','%'.$request->searchForm.'%')
            ->where(function ($query) use ($request){
                $query
                ->where("r.fullname", "LIKE", '%'. $request->name .'%')
                ->orWhere("r.address", "LIKE", '%'. $request->name .'%')
                ->orWhere("r.email", "LIKE", '%'. $request->name .'%')
                ->orWhere("r.contact_number", "LIKE", '%'. $request->name .'%');
            });

            if($request->dateFrom && $request->dateTo){
              $renter->whereDate('r.date_registered', '>=', $request->dateFrom);
              $renter->whereDate('r.date_registered', '<=', $request->dateTo);
            }

            if($request->sort){
              $renter->orderBy($request->sort, 'asc');
            }else{
              $renter->orderBy('r.id','desc');
            }

            $renter = $renter->paginate(50);

        return $renter;
    }

    public function searchRenterForFilter(Request $request){
        $renters = DB::table('renters as r')
            ->select('r.id','r.fullname');

        if($request->name){
            $renters->where('r.fullname','LIKE','%'.$request->name.'%');
        }

        $renters = $renters->get();
        return $renters;
    }

    public function renterList(){

        $renters = DB::table('renters as r')
            ->select('r.fullname','r.id')
            ->get();

        return $renters;
    }

    public function renterValidation($request){
        return $this->validate($request,[
            'fullname'          => 'required|string',

            'date_registered'   => 'required',

        ],
        [
            'fullname'           => 'fullname field is required.',

            'date_registered'    => 'Date register field is required.',

         ]
    );
    }
}
