<?php
namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
            if (!$request->secure() && env('FORCE_HTTPS', false)) {//default val false
                return redirect()->secure($request->getRequestUri(), 301);
            }

            return $next($request); 
    }
}
?>