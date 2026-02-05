<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Yetkisiz erişim.'], 403);
            }
            return redirect()->route('admin.login')->with('error', 'Bu alana erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
