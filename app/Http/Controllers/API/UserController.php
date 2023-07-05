<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Crypt;
use Auth;
use Illuminate\Support\Facades\Hash;

use App\Events\SystemLog\SystemLogEvent;

class UserController extends Controller
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

        $this->uservalidation($request);
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'mobileno' => $request->mobileno,
            'role' => $request->role,
            'renter_id' => $request->renter_id,
            'branch_id' => $request->branch_id,
            'password' => Hash::make($request['password']),
        ]);

        $request->merge(['activity' => 'Add user']);
        $request->merge(['activity_id' => $user->id]);
        $request->merge(['details' => $user]);

        event(new SystemLogEvent($request));

        $user->save();
        if($user->id){
            $role =  UserRole::create([
                'user_id'            => $user->id,
                'branch'             => $request['branch'],
                'renters_profile'    => $request['renters_profile'],
                'cube_management'    => $request['cube_management'],
                'product_management' => $request['product_management'],
                'inventory'          => $request['inventory'],
                'pos'                => $request['pos'],
                'users'              => $request['users'],
                'rent_management'    => $request['rent_management'],
                'report'             => $request['report'],
                'settings'           => $request['settings'],
                'sale_collections'    => $request['sale_collections'],
            ]);
        }
        $role->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'username'       => 'required',
            'name'           => 'required',
            // 'renter_id'      => 'required',
            'role'           => 'required',
        ],
        [
            'username'      => 'Username field is required',
            // 'renter_id'     => 'Renter field is required',
            'name'          => 'Name field is required',
            'role'          => 'Role field is required',
         ]
    );

        $user = User::findOrFail($id);

        $request->merge(['activity' => 'Edit user']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $user]);

        event(new SystemLogEvent($request));

        if(!empty($request['password'])){
            $this->validate($request,[
                'password' => 'required|string|min:6'
            ]);
            $user->password = Hash::make($request['password']);
        }

        $user->username          =    $request->get('username');
        $user->name              =    $request->get('name');
        $user->address           =    $request->get('address');
        $user->email             =    $request->get('email');
        $user->mobileno          =    $request->get('mobileno');
        $user->role              =   $request->get('role');
        $user->renter_id         =   $request->get('renter_id');
        $user->branch_id         =   $request->get('branch_id');
        $user->save();

        DB::table("user_roles")->where("user_id", $id)->delete();
        $role = new UserRole;
        if($user->id){
            $role->user_id            = $user->id;
            $role->branch             = $request->get('branch');
            $role->renters_profile    = $request->get('renters_profile');
            $role->cube_management    = $request->get('cube_management');
            $role->product_management = $request->get('product_management');
            $role->inventory          = $request->get('inventory');
            $role->pos                = $request->get('pos');
            $role->users              = $request->get('users');
            $role->rent_management    = $request->get('rent_management');
            $role->report             = $request->get('report');
            $role->settings           = $request->get('settings');
            $role->sale_collections    = $request->get('sale_collections');
            $role->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Delete user']);
        $request->merge(['activity_id' => $id]);
        $request->merge(['details' => $user]);

        event(new SystemLogEvent($request));

        DB::table('users')->where('id', $user->id)->delete();
        DB::table('user_roles')->where('user_id', $user->id)->delete();
    }

    public function uservalidation($request){
        return $this->validate($request,[
            'username'       => 'required',
            'name'           => 'required',
            // 'renter_id'      => 'required',
            'role'           => 'required',
            'password'       => 'required|string|min:6',

        ],
        [
            'username'      => 'Username field is required',
            // 'renter_id'     => 'Renter field is required',
            'name'          => 'Name field is required',
            'role'          => 'Role field is required',
            'password'      => 'Password field is required.',


         ]
    );
    }
    public function searchUser(Request $request){
        $user = DB::table('users as u')
        ->select('u.id','u.username' , 'u.name as nameuser' , 'u.renter_id' , 'u.email' , 'u.address' , 'u.mobileno' , 'u.role' , 'r.fullname' , 'bs.name' , 'u.branch_id' , 'ur.branch' , 'ur.renters_profile' , 'ur.cube_management' , 'ur.product_management' , 'ur.inventory' , 'ur.pos' ,'ur.users' ,'ur.rent_management' , 'ur.report' ,'ur.settings')
        ->leftJoin('renters as r' , 'r.id' , '=' , 'u.renter_id')
        ->leftJoin('branches as bs' , 'bs.id' , 'u.branch_id')
        ->leftJoin('user_roles as ur' , 'ur.user_id' , 'u.id')
        ->where(function($query) use ($request) {
            $query
            ->where('u.username','LIKE','%'.$request->name.'%')
            ->orWhere('u.name','LIKE','%'.$request->name.'%')
            ->orWhere('u.mobileno','LIKE','%'.$request->name.'%')
            ->orWhere('u.role','LIKE','%'.$request->name.'%')
            ->orWhere('bs.name','LIKE','%'.$request->name.'%')
            ->orWhere('bs.address','LIKE','%'.$request->name.'%');
        });
        // ->orderBy('u.id' , $request->sort);
        if($request->sort){
          $user->orderBy($request->sort, 'asc');
        }

        if(Auth::user()->role != "admin"){
            if(Auth::user()->branch_id){
                $user->where('bs.id', Auth::user()->branch_id);
                $user->where('u.username','!=', 'admin');
            }
        }
        $user = $user->paginate(50);

        return $user;
    }

    public function selectUsersDelte(Request $request){
        // return $request;
            DB::table('users')->whereIn('id', $request->productID)->delete();
    }
}
