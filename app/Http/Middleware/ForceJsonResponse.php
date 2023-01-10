<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse|JsonResponse|StreamedResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse|StreamedResponse
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
