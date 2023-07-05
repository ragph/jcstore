<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use File;

use App\Events\SystemLog\SystemLogEvent;

class ProductController extends Controller
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
        $this->productValidation($request);

        $product = Product::create([
            'sku' => $request->sku,
            'product_name' => $request->product_name,
            'cost_price' => $request->cost_price,
            'sell_price' => $request->sell_price,
            'wholesale_price' => $request->wholesale_price,
            'wholesale_quantity' => $request->wholesale_quantity,
            'stock_level' => $request->stock_level,
            'renter_id' => $request->renter_id,
            'brand' => $request->brand,
            'tags' => $request->tags,
            'created_by' => Auth::id(),
            'description' => $request->description,
        ]);

        $request->merge(['activity' => 'Add product']);
        $request->merge(['activity_id' => $product->id]);
        $request->merge(['details' => $product]);

        event(new SystemLogEvent($request));

        foreach($request->value as $item){
            // return $request->value;
            $data = new ProductCategory;
            $data->product_id = $product->id ;
            $data->category_id = $item['id'];
            $data->save();
        }

        foreach($request->gallery as $gallery){
            if(!empty($gallery)){
                $data = \Image::make($gallery['path'])->save(public_path('images/products/').$gallery['name']);
                $galleryImage = new ProductPicture;
                $galleryImage->product_id = $product->id;
                $galleryImage->picture = $gallery['name'];
                $galleryImage->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->productValidation($request);

        $product = Product::findOrFail($id);
        $product->sku = $request->sku;
        $product->product_name = $request->product_name;
        $product->cost_price = $request->cost_price;
        $product->sell_price = $request->sell_price;
        $product->wholesale_price = $request->wholesale_price;
        $product->wholesale_quantity = $request->wholesale_quantity;
        $product->stock_level = $request->stock_level;
        $product->renter_id = $request->renter_id;
        $product->brand = $request->brand;
        $product->tags = $request->tags;
        $product->description = $request->description;
        // $product->branch_id = $request->branch_id;
        $product->created_by = Auth::id();

        $request->merge(['activity' => 'Edit product']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $product]);

        event(new SystemLogEvent($request));

        $product->save();

        DB::table('product_categories')->where('product_id', $id)->delete();
        DB::table('product_pictures')->where('product_id', $id)->delete();
        foreach($request->value as $item){
            // return $request->value;
            $data = new ProductCategory;
            $data->product_id = $product->id ;
            $data->category_id = $item['id'];
            $data->save();
        }

        foreach($request->gallery as $gallery){
            if(!empty($gallery)){
                $data = \Image::make($gallery['path'])->save(public_path('images/products/').$gallery['name']);
                $galleryImage = new ProductPicture;
                $galleryImage->product_id = $product->id;
                $galleryImage->picture = $gallery['name'];
                $galleryImage->save();
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::findOrFail($id);


        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete product']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $product]);

        event(new SystemLogEvent($request));

        $product = DB::table('inventories')
        ->select('product_id')
        ->where('product_id',$id)
        ->get();

        if(count($product) > 0){
            return back()->withErrors('your error message');
        }else{
            DB::table('products')->where('id', $id)->delete();
            DB::table('product_categories')->where('product_id', $id)->delete();
            DB::table('product_pictures')->where('product_id', $id)->delete();
        }

    }
    public function filerbycategory( $sort, $sortby, $category){
        $product = DB::table('products as p')
        ->select('p.id','p.sku','p.product_name', 'p.cost_price' , 'p.sell_price' , 'p.stock_level' , 'p.renter_id' , 'p.brand' , 'p.tags' , 'p.description','pc.category_id')
        ->join('product_categories as pc' , 'pc.product_id' , '=' , 'p.id')
        ->join('categories as c' , 'c.id', '=' , 'pc.category_id')
        ->join('box_managements as bm','bm.id','=','p.renter_id')
        ->where('pc.category_id',$category);

        if($sort){
            $product->orderBy($sort, 'asc');
        }else{
            $product->orderBy('p.id','desc');
        }
        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $product->where('bm.branch', Auth::user()->branch_id);
            }
        }

        $product = $product->paginate(50);

        return $product;
    }
    public function searchProduct(Request $request){
        if($request->searchcategory){
            $product = $this->filerbycategory($request->sort, $request->sortby, $request->searchcategory);
        }else{
        $product = DB::table('products as p')
            ->select('p.id','p.sku','p.product_name', 'p.cost_price' , 'p.sell_price','p.wholesale_price','p.wholesale_quantity', 'p.stock_level' , 'p.renter_id' , 'p.brand' , 'p.tags' , 'p.description','bm.end_of_contract')
            ->join('box_managements as bm','bm.id','=','p.renter_id')
            ->where(function($query) use ($request) {
                $query->where('p.product_name','LIKE','%'.$request->searchForm.'%')
                ->orWhere('p.sku','LIKE','%'.$request->searchForm.'%');
            });

            if($request->sort){
              $product->orderBy($request->sort, 'asc');
            }else{
              $product->orderBy('p.id','desc');
            }

          if(Auth::user()->role != "admin"){
              if(Auth::user()->branch_id){
                  $product->where('bm.branch', Auth::user()->branch_id);
              }
          }

            $product = $product->paginate(50);

        }
            foreach($product as $item){
                $inventory =  DB::table('inventories as i')
                ->select(DB::raw("SUM(i.quantity) as quantity"))
                ->where('i.product_id' , $item->id)
                ->groupBy('i.location_id' , 'i.product_id')
                ->value('quantity');


                $sales = DB::table('sale_products as sp')
                ->select(DB::raw("SUM(sp.quantity) as salequantity"))
                ->where('sp.product_id' , $item->id)
                ->groupBy('sp.location_id' , 'sp.product_id' )
                ->value('salequantity');

                $return =  DB::table('return_products as r')
                ->select(DB::raw("SUM(r.quantity) as quantity"))
                ->where('r.product_id' , $item->id)
                ->groupBy('r.location_id' , 'r.product_id')
                ->value('quantity');


                $item->trqty = $inventory - $return;

                if( $item->trqty != 0){
                    $item->qty = $item->trqty - $sales;
                }else{
                    $item->qty = 0;
                }

                if($item->qty == 0){
                    $item->stock_level = "outstock";
                }else{
                    $item->stock_level = "instock";
                }
            }

            foreach($product as $item){
                $category = DB::table('product_categories as pc')
                ->select('c.category_name as name' , 'c.id')
                ->join('categories as c', 'c.id' , '=', 'pc.category_id')
                ->where('pc.product_id', $item->id)
                ->get();
                $item->category = $category;


            }

            foreach($product as $item){
                $picture = DB::table('product_pictures as p')
                ->select('p.picture as photo')
                ->join('products as ps', 'ps.id' , '=', 'p.product_id')
                ->where('p.product_id', $item->id)
                ->get();

                $galleryData = array();
                $count = 1;
                foreach($picture as $gallery){
                    if($count == 1){
                        $images  = (object)[
                            'path' => './images/products/'.$gallery->photo,
                            'default' => 1,
                            'highlight'=> 1,
                            'name' => $gallery->photo,
                            'caption' => 'caption to display. receive', // Optional
                      ];
                    }else{
                        $images  = (object)[
                            'path' => './images/products/'.$gallery->photo,
                            'default' => 0,
                            'highlight'=> 0,
                            'name' => $gallery->photo,
                            'caption' => 'caption to display. receive', // Optional
                      ];
                    }
                    array_push($galleryData, $images);
                    $count++;
                }

                $item->gallery = $galleryData;

            }

        return $product;
    }

    public function productList(){
        $product = DB::table('products as p')
        ->select('p.id','p.product_name' , 'p.sku')
        ->join('box_managements as bm','bm.id','=','p.renter_id')
        ->orderby('id', 'desc');
    if(Auth::user()->role != "admin"){
        if(Auth::user()->branch_id){
            $product->where('bm.branch', Auth::user()->branch_id);
        }
    }


        return $product->get();;
    }

    public function rentersList(){
        $renter = DB::table('renters as r')
        ->select('r.id','r.fullname')
        ->orderby('id', 'desc')
        ->get();

        return $renter;
    }

    public function selectPrdctDelte(Request $request){

        $ids = implode(', ', $request->productID);


        $product = DB::table('products')->whereIn('id', $request->productID)->get();
        DB::table('products')->whereIn('id', $request->productID)->delete();

        $ids = implode(', ', $request->productID);
        
        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete product from list']);
        $request->merge(['activity_id' => $ids]);
        $request->merge(['details' => $product]);

        event(new SystemLogEvent($request));

        
    }

    public function productValidation($request){
        return $this->validate($request,[
            'sku'                 => 'required',
            'product_name'        => 'required',
            'cost_price'          => 'numeric|min:0',
            'sell_price'          => 'numeric|min:0',
            'wholesale_price'     => 'numeric|min:0',
            'wholesale_quantity'  => 'numeric|min:0',

        ],
        [
            'sku'                 => 'SKU field is required',
            'product_name'        => 'Product name field is required',
            'cost_price'          => 'Cost price field is required',
            'sell_price'          => 'Sell price is field required',

         ]
    );
    }

    public function countallProducts(){
        $products = DB::table('products as p')
        ->select(DB::raw("COUNT(p.product_name) as total"))
        ->get();

        return $products;
    }
    public function Listofproducts(){
        $products = DB::table('products as p')
        ->select('p.product_name' , 'p.id')
        ->get();

        return $products;
    }
}