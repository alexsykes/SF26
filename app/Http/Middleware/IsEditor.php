<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEditor
{
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check()) {
            $user = Auth::user();
            $isEditor = $user->isEditor;
            if ($isEditor) {
                return $next($request);
            } else {
                return redirect('/');
            }
        }
        return redirect('/');
    }
}
