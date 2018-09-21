<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            if (Auth::check() && $view->getName() != 'auth.login') {
                $username = auth()->user()->username;
                $unread = Auth::user()->unreadNotifications;
                $notys = Auth::user()->notifications()->latest()->get();
                $view->with([
                    'username'           => $username,
                    'notificationsCount' => $unread->count() > 0 ? $unread->count() : "",
                    'notifications'      => $notys
                ]);
            }
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
