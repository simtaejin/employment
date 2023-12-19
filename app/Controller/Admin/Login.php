<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page {

    public static function getLogin($request, $errorMessage = null) {

        $content = View::render('admin/login',[
            'status' => !is_null($errorMessage) ? Alert::getError($errorMessage) : ''
        ]);

        return parent::getPage('Lgin > WDEV', $content);
    }

    public static function setLogin($request) {
        $postVars = $request->getPostVars();
        $email    = $postVars['email'] ?? '';
        $senha    = $postVars['senha'] ?? '';

        $obUser = User::getUserByEmail($email);

        if (!$obUser instanceof User) {
            return self::getLogin($request, 'E-mail Error');
        }

        if (!password_verify($senha, $obUser->senha)) {
            return  self::getLogin($request, 'password Error');
        }

        SessionAdminLogin::login($obUser);

        $request->getRouter()->redirect('/admin');
    }

    public static function setLogout($request) {
        SessionAdminLogin::logout();

        $request->getRouter()->redirect('/admin/login');
    }
}
