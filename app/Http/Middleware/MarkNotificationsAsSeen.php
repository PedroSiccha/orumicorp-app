<?php

namespace App\Http\Middleware;

use App\Models\NotificationOnUpdateModel;
use Closure;
use Illuminate\Http\Request;

class MarkNotificationsAsSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $module)
    {
        if (auth()->check()) {
            NotificationOnUpdateModel::where('user_id', auth()->id())
                ->where('module', $module)
                ->where('is_seen', false)
                ->update(['is_seen' => true]);
        }

        return $next($request);
    }
}
