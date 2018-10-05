<?php namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetLanguage
{

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en', 'ar'];

    /**
     * Default language.
     *
     * @var string
     */
    protected $default = 'en';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->has("lang")) {
            Session::put('locale', $request->get("lang"));
        } elseif (!Session::has('locale')) {
            Session::put('locale', $this->default);
        }
        Session::save();

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }


}