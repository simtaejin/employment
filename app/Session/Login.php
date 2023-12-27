<?php

namespace App\Session;

class Login {

    private static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($obMember) {

        self::init();

        $_SESSION['user'] = [
            'idx' => $obMember->idx,
            'id' => $obMember->member_id,
            'name' => $obMember->member_name,
            'email' => $obMember->member_email,
            'company' => $obMember->member_company,
        ];

        return true;
    }

    public static function isLogged() {

        self::init();

        return isset($_SESSION['user']['id']);
    }

    public static function logout() {
        self::init();

        unset($_SESSION['user']);

        return true;
    }
}
