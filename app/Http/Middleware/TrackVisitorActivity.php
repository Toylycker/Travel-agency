<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackVisitorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $logData = [
            'IP Address' => $request->ip(),
            'sep' => 'sep',
            'URL' => $request->url(),
            'sep' => 'sep',
            'User Agent' => $request->header('User-Agent'),
            'sep' => 'sep',
            'Timestamp' => now()->toDateTimeString() // Optional: Adds a timestamp
        ];

        Log::channel('visitors')->info('Visitor log:', [json_encode($logData)]);

        return $next($request);
    }
}
