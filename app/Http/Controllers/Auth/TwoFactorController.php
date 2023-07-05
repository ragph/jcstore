<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function index() 
    {
        if( (isset(auth()->user()->two_factor_code) ? auth()->user()->two_factor_code: null) != null ) {
            return view('auth.twoFactor');
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $dateNow = date("Y-m-d h:i:s");
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();
        $err = "The two factor code you have entered does not match";

        if($user->two_factor_expires_at < $dateNow){
            $err = "The two factor code you have entered has already expired. Please click resend for new code.";
        }
        
        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();

            // return redirect()->route('admin.home');
            return redirect('/');
        }
        
        
        return redirect()->back()
            ->withErrors(['two_factor_code' => $err]);
    }

    public function cancellogin(){
        $user = auth()->user();
        $user->resetTwoFactorCode();
        auth()->logout();
        return redirect()->route('login');
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}
