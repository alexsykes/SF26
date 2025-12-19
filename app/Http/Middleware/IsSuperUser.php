<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Auth::user();
        if ($user == null) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $isSuperUser = $user->isSuperUser;
        if ($isSuperUser) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
