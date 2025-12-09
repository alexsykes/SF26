<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEditor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Auth::user();
        $isEditor = $user->isEditor;
        if ($isEditor) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
