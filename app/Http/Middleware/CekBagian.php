<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekBagian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting') {
                return $next($request);
            }
        }
        return redirect()->back()->with('warning','Fitur ini hanya dapat di akses oleh Accounting dan Cashier!');
    }
}
