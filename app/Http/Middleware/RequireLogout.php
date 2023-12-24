<?php

namespace App\Http\Middleware;

use App\Session\Login as SessionAdminLogin;

class RequireLogout {

    public function handle($request, $next) {
        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/');
        }

        return $next($request);
    }
}