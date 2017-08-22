<?php

namespace VoyagerRedirects\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;
use VoyagerRedirects\Models\VoyagerRedirect;

class VoyagerRedirectMiddleware
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
        if(Schema::hasTable('voyager_redirects')){
            $path = $request->path();
            $redirect = VoyagerRedirect::where('from', '=', $path)->first();
            if(isset($redirect->id)){
                return redirect($redirect->to, $redirect->type);
            }
        }
        return $next($request);
    }
}
