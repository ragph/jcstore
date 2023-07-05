<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemLogController extends Controller
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

    public function searchSystemLog(Request $request){

        
        $blotter_records = DB::table('system_logs as s')
        ->select('s.*','u.username')
        ->leftJoin('users as u','u.id','=','s.users_id')
        ->get();

        return DataTables::of($blotter_records)
            ->addColumn('action', function($data){
                
                $datas = json_encode($data, JSON_HEX_APOS);

                $button = "<button data-info='".$datas."' class='action_btn_view btn btn-primary btn-sm btn-shdw'>View</button>";
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
