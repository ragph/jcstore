<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\TwoFactorCode;
use App\Events\SystemLog\SystemLogEvent;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = route('login');
    }

    public function username(){

        $loginType = request()->input('username');
        $this->username = filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$this->username => $loginType]);

        return property_exists($this,'username') ? $this->username : 'email';

    }

    protected function authenticated(Request $request, $user)
    {
        $request->merge(['activity' => 'User login']);
        $request->merge(['activity_id' => auth()->user()->id ]);
        $request->merge(['details' => auth()->user() ]);
        event(new SystemLogEvent($request));

        if(auth()->check() && (env('TWO_FACTOR_AUTH') == 'true')){
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());
        }
    }

    public function logout(Request $request) {

        $request->merge(['activity' => 'User logout']);
        $request->merge(['activity_id' => auth()->user()->id ]);
        $request->merge(['details' => auth()->user() ]);
        event(new SystemLogEvent($request));

        Auth::logout();
        return redirect('/');
    }

    protected function redirectTo(){

    }
}
