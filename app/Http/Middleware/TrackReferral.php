<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class TrackReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //  If ref param exists in URL store in cookie for 30 days
        if ($request->has('ref') && !empty($request->ref)) {
            $response->withCookie(
                cookie('referral_code', $request->ref, 60 * 24 * 30) // 30 days
            );
        }

        return $response;
    }
}
