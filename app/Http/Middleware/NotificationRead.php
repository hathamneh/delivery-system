<?php

namespace App\Http\Middleware;

use Closure;

class NotificationRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('noty')) {
            $noty = $request->user()->unreadNotifications()->where('id', $request->get('noty'))->first();
            if (!is_null($noty)) {
                $noty->markAsRead();
            }
        }

        return $next($request);
    }
}
