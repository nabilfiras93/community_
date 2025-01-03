<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class MyMiddleware {

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next) {

        if (empty(session('my_username'))) {
                return redirect('/auth');
        } else {
            if(!$request->ajax()){
                // echo "<script>alert('Access Not Allowed'); window.location.href = '".url('home')."'; </script>";die;
            }
            $response = $next($request);
            $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma','no-cache');
            $response->headers->set('Expires','Sun, 02 Jan 1990 00:00:00 GMT');
            return $response;
        }
    }

}
