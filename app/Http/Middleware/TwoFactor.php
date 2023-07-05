<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        $dateNow = date("Y-m-d h:i:s");
        $user = auth()->user();

        if(auth()->check() && $user->two_factor_code)
        {
            if($user->two_factor_expires_at < $dateNow)
            {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->withMessage('The two factor code has expired. Please login again.');
            }

            if(!$request->is('verify*'))
            {
                return redirect('/verify');
            }
        }

        return $next($request);
    }
}
