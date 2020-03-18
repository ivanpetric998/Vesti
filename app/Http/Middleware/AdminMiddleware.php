<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        $korisnik = $request->session()->get("korisnik");

        if($korisnik->nazivUloga != "admin"){

            $accept=$request->header('Accept');

            if($accept==='application/json'){

                return response(["greska"=>'Niste admin'],403);

            }
            else{

                return redirect()->back();

            }

        }

        return $next($request);
    }
}
