<?php

namespace App\Http\Middleware;

use App\Session\Login as SessionAdminLogin;

class RequireLogin {

    public function handle($request, $next) {
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/login');
        }

        return $next($request);
    }
}