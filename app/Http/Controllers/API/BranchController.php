<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Branch;
use Auth;
use Illuminate\Support\Facades\DB;

use App\Events\SystemLog\SystemLogEvent;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Hello World";
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

        $this->branchValidation($request);

        $branch = Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number
        ]);

        $request->merge(['activity' => 'Add branch']);
        $request->merge(['activity_id' => $branch->id]);
        $request->merge(['details' => $branch]);

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
        $this->branchValidation($request);

        $branch = Branch::findOrFail($id);

        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->contact_person = $request->contact_person;
        $branch->contact_number = $request->contact_number;

        $request->merge(['activity' => 'Edit branch']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $branch]);

        event(new SystemLogEvent($request));

        $branch->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete branch']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $branch]);

        event(new SystemLogEvent($request));

        DB::table('branches')->where('id', $id)->delete();
    }

    public function searchBranch(Request $request){
        $branch = DB::table('branches as b')
            ->select('b.id','b.name','b.address','b.contact_person','b.contact_number')
            // ->where('b.name','LIKE','%'.$request->branch.'%')
            ->where(function ($query) use ($request){
              $query
              ->where("b.contact_person", "LIKE", '%'. $request->branch .'%')
              ->orWhere("b.name", "LIKE", '%'. $request->branch .'%')
              ->orWhere("b.address", "LIKE", '%'. $request->branch .'%')
              ->orWhere("b.contact_number", "LIKE", '%'. $request->branch .'%');
            });

            if(Auth::user()->role != "admin"){
              if(Auth::user()->branch_id){
                  $branch->where('b.id', Auth::user()->branch_id);
              }
            }

            if($request->sort){
              $branch->orderBy($request->sort, 'asc');
            }else{
              $branch->orderBy('b.id','desc');
            }
            
            $branch = $branch->paginate(50);

            return $branch;
    }

    public function branchList(){
        $branchList = DB::table('branches as b')
            ->select('b.id','b.name','b.address','b.contact_person','b.contact_number');
        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $branchList->where('b.id', Auth::user()->branch_id);
            }
        }


        return $branchList->get();
    }
    public function branchValidation($request){
        return $this->validate($request,[
            'name' => 'required|string',
            'address' => 'required|string',
            'contact_person' => 'required|string',
            'contact_number' => 'required'
        ],
        [
            'name.required'    => 'Name field is required.',
            'address.required'    => 'Address field is required.',
            'contact_person.required'    => 'Contact person field is required.',
            'contact_number.required' => 'Contact number is required'
         ]
    );
    }
}
