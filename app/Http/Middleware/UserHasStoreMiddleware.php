<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
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

        if (auth()->user()->store()->count()){
            flash('voce ja possui uma loja!')->warning(); 
            return redirect()->route('admin.stores.index');
           }
           
        return $next($request);
    }
}
