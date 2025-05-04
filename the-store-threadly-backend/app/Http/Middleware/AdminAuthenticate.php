<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(
            !auth()->check() ||
            auth()->user()?->role !== "admin"
        ){
            auth()->logout();
            if ($request->ajax() || $request->wantsJson())
                return response()->json(["message"=>"You must be logged in as an admin to access this page!","redirect"=>route("admin.signin.view")],500);

            return redirect()->route("admin.signin.view")->with("error","You must be logged in as an admin to access this page!");
        }

        return $next($request);
    }
}
