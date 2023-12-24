<?php

namespace App\Session;

class Login {

    private static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($obUser) {

        self::init();

        $_SESSION['user']['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];

        return true;
    }

    public static function isLogged() {

        self::init();

        return isset($_SESSION['user']['usuario']['id']);
    }

    public static function logout() {
        self::init();

        unset($_SESSION['user']['usuario']);

        return true;
    }
}
