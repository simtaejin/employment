<?php

namespace App\Controller\Pages;

use App\Controller\Admin\Alert;
use App\Controller\Pages\Page;
use App\Model\Entity\Member;
use App\Session\Login as SessionLogin;
use App\Utils\Common;
use App\Utils\View;

class Login extends Page {

    public static function getLogin($request, $errorMessage = null) {

        $content = View::render('pages/login',[
            'status' => !is_null($errorMessage) ? Alert::getError($errorMessage) : ''
        ]);

        return parent::getPage('Lgin > WDEV', $content);
    }

    public static function setLogin($request) {
        $postVars = $request->getPostVars();
        $member_id    = $postVars['member_id'] ?? '';
        $member_password    = $postVars['member_password'] ?? '';

        $obMember = Member::getMemberById($member_id);

        if (!$obMember instanceof Member) {
            return self::getLogin($request, 'id Error');
        }

        if (!password_verify($member_password, $obMember->member_password)) {
            return  self::getLogin($request, 'password Error');
        }

        SessionLogin::login($obMember);

        $request->getRouter()->redirect('/page/guin');

    }

    public static function setLogout($request) {
        SessionLogin::logout();

        $request->getRouter()->redirect('/login');
    }
}
