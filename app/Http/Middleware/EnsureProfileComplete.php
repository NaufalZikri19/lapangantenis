<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isBiodataIncomplete()) {
            //redirect ke halaman edit/isi biodata
            return redirect()->route('profile.edit')
                ->with('warning', 'Silakan lengkapi biodata Anda sebelum melanjutkan');
        }

        return $next($request);
    }
}
