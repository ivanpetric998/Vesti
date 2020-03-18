<?php

namespace App\Http\Middleware;

use Closure;

class IsLoggedIn
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

        if($request->session()->has("korisnik"))
        {
            return $next($request);
        }
        else
        {
            $accept=$request->header('Accept');

            if($accept==='application/json'){

                return response(["greska"=>'Morate biti ulogovani'],403);

            }
            else{

                return redirect()->back()->with('poruka','Morate da budete ulogovani!');

            }
        }

    }
}
