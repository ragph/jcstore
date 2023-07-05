<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Events\SystemLog\SystemLogEvent;

class CategoryController extends Controller
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

        $this->categoryValidation($request);

        $category = Category::create([
            'category_name' => $request->category_name,
            'subcategory_id' => $request->subcategory_id,
        ]);

        $request->merge(['activity' => 'Add category']);
        $request->merge(['activity_id' => $category->id]);
        $request->merge(['details' => $category]);

        event(new SystemLogEvent($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->categoryValidation($request);


        $category = Category::findOrFail($id);

        $category->category_name = $request->category_name;
        $category->subcategory_id = $request->subcategory_id;

        $request->merge(['activity' => 'Edit category']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $category]);

        event(new SystemLogEvent($request));

        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // return $id;
        
        $product = DB::table('product_categories')
        ->select('id')
        ->where('category_id',$id)
        ->get();

        

        if(count($product) > 0){
            return back()->withErrors('your error message');
        }else{

            $categories = Category::findOrFail($id);

            $request = new \Illuminate\Http\Request();
            $request->merge(['activity' => 'Delete category']);
            $request->merge(['activity_id' => $id]);
            $request->merge(['details' => $categories]);

            event(new SystemLogEvent($request));
            
            DB::table('categories')->where('id', $id)->delete();
        }
    }

    public function searchCategory(Request $request){

        $category = DB::table('categories as c')
            ->select('c.id','c.category_name' , 'cs.category_name as subcategory' , 'cs.id as category_id')
            ->leftJoin('categories as cs' , 'cs.id' , '=' , 'c.subcategory_id');
            // ->where('c.category_name','LIKE','%'.$request->searchForm.'%');
        
        $category->where(function($query) use ($request) {
            $query
            ->where('c.category_name','LIKE','%'.$request->searchForm.'%')
            ->orWhere('cs.category_name','LIKE','%'.$request->searchForm.'%');
        });

        if($request->sort){
          $category->orderBy($request->sort, 'asc');
        }else{
          $category->orderBy('c.id', 'desc');
        }

        $category = $category->paginate(50);

        return $category;
    }

    public function categoryList(){

        $category = DB::table('categories as c')
            ->select('c.category_name as name' , 'c.id')
            ->get();

        return $category;
    }


    public function categoryValidation($request){
        return $this->validate($request,[
            'category_name'          => 'required|string',
        ],
        [
            'category_name'           => 'Categoy field is required.',
         ]
    );
    }
}
