<?php

namespace AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use AwemaPL\AllegroClient\Facades\AllegroClient;

class Installation
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (AllegroClient::canInstallation()){
            $route = Route::getRoutes()->match($request);
            $name = $route->getName();
            if (!in_array($name, config('allegro-client.routes.admin.installation.expect'))){
                return redirect()->route('allegro_client.admin.installation.index');
            }
        }
        if (AllegroClient::canInstallationDefaultSettings()){
            $route = Route::getRoutes()->match($request);
            $name = $route->getName();
            if (!in_array($name, config('allegro-client.routes.admin.installation.expect'))){
                return redirect()->route('allegro_client.admin.installation.index_default_setting');
            }
        }
        return $next($request);
    }
}
