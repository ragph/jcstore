<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\VoucherCoupon;
use App\VoucherProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
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
        $this->vouchervalidation($request);
        $voucher = VoucherCoupon::create([
            'voucher_name' => $request->voucher_name,
            'type' => $request->type,
            'percentage' => $request->percentage,
            'status' => $request->status,
            'price_type' => $request->price_type,
            'fix_price' => $request->fix_price,
            'created_by' => 1,
        ]);

            if($request->type == "product"){
                foreach($request->location_id as $item){
                    // return $request->value;
                    $data = new VoucherProduct;
                    $data->voucher_id = $voucher->id ;
                    $data->location_id = $item['id'];
                    $data->save();
                }
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VoucherCoupon  $voucherCoupon
     * @return \Illuminate\Http\Response
     */
    public function show(VoucherCoupon $voucherCoupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VoucherCoupon  $voucherCoupon
     * @return \Illuminate\Http\Response
     */
    public function edit(VoucherCoupon $voucherCoupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VoucherCoupon  $voucherCoupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->vouchervalidation($request);

        $voucher = VoucherCoupon::findOrFail($id);
        $voucher->voucher_name = $request->voucher_name;
        $voucher->type = $request->type;
        $voucher->status = $request->status;
        $voucher->percentage = $request->percentage;
        $voucher->price_type = $request->price_type;
        $voucher->fix_price = $request->fix_price;
        $voucher->created_by = 1;
        $voucher->save();


        if($request->type == "product"){
        DB::table('voucher_products')->where('voucher_id', $id)->delete();
            foreach($request->value as $item){
                // return $request->value;
                $data = new VoucherProduct;
                $data->voucher_id = $voucher->id ;
                $data->location_id = $item['id'];
                $data->save();
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VoucherCoupon  $voucherCoupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = VoucherCoupon::findOrFail($id);
        DB::table('voucher_coupons')->where('id', $voucher->id)->delete();
        DB::table('voucher_products')->where('voucher_id',  $voucher->id)->delete();
    }

    public function vouchervalidation($request){
        return $this->validate($request,[
            'voucher_name'       => 'required',
            'type'           => 'required',

        ],
        [
            'voucher_name'      => 'Voucher name field is required',
            'type'              => 'Type field is required',

         ]
    );
    }


    public function searchVoucher(Request $request){
        $voucher = DB::table('voucher_coupons as vc')
        ->select('vc.id','vc.voucher_name' , 'vc.type' , 'vc.status' , 'vc.percentage','vc.price_type' , 'vc.fix_price')
        ->where('vc.voucher_name','LIKE','%'.$request->searchForm.'%')
        ->orderBy('vc.id' , $request->sort)
        ->paginate(50);


        foreach($voucher as $item){
            $vproduct = DB::table('voucher_products as vp')
            ->select('vp.id as pid','r.fullname' , 'b.name' , 'bx.box_number')
            ->join('box_managements as bs' , 'bs.id' , '=' , 'vp.location_id')
            ->join('renters as r' , 'r.id' , '=' , 'bs.renter_id')
            ->join('branches as b' , 'b.id' , '=' , 'bs.branch')
            ->join('boxes as bx' , 'bx.id' , '=' , 'bs.box_id')
            ->where('vp.voucher_id', $item->id)
            ->get();
            $status = DB::table('voucher_coupons as vc')
            ->select('vc.status')
            ->where('vc.id' , $item->id)
            ->value('vc.status');

            if($status == 1) {
                $item->stat = "Enable";
            }else{
                $item->stat = "Disable";
            }

            $item->location_id = $vproduct;
        }
        return $voucher;
}

}
