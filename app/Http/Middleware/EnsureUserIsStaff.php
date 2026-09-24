<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the back-office as a whole. Inside it, `admin` still guards everything a supervisor has
 * no business reaching — this only decides who gets through the front door.
 */
class EnsureUserIsStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isStaff()) {
            abort(403, 'Accès réservé à l\'équipe.');
        }

        return $next($request);
    }
}
