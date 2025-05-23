<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{

    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'content' => $content
        ]);
    }

    public static function getBlankPage($title, $content)
    {
        return View::render('pages/blankpage', [
            'title' => $title,
            'content' => $content
        ]);
    }

    private static $menus = [
        [
            'label' => 'guin',
            'title' => '구인관리',
//            'link'  => URL."/page/guin",
            'submenu' => [
                ['label' => 'table_inquiry', 'title' => '구인관리', 'link' => URL."/page/guin"],
                ['label' => 'chart_inquiry', 'title' => '구인회비관리', 'link' => URL."/page/guin_dues"],
            ],

        ],
        [
            'label' => 'gujig',
            'title' => '구직관리',
//            'link'  => URL."/page/gujig"
            'submenu' => [
                ['label' => 'table_inquiry', 'title' => '구직관리', 'link' => URL."/page/gujig"],
                ['label' => 'chart_inquiry', 'title' => '구직회비관리', 'link' => URL."/page/gujig_dues"],
            ],
        ],
        [
            'label' => 'employment',
            'title' => '취업관리',
            'link' => URL."/page/employment"
        ],
        [
            'label' => 'agreement',
            'title' => '소개요금약정서관리',
            'link' => URL."/page/agreement"
        ],
        [
            'label' => 'oldpage',
            'title' => '이전데이터',
            'submenu' => [
                ['label' => 'table_inquiry', 'title' => '이전구직데이터관리', 'link' => URL."/page/oldgujig"],
                ['label' => 'chart_inquiry', 'title' => '이전구인데이터관리', 'link' => URL."/page/oldguin"],
            ],
        ],
    ];


    public static function getDepth_1($currentModule)
    {

        $menus = '';

        foreach (self::$menus as $k => $v) {
            if (!array_key_exists('submenu', $v)) {
                $menus .= View::render('pages/menu/li', [
                    'depth_1' => $v['title'],
                    'active' => $v['label'] == $currentModule ? 'active' : '',
                    'link' => $v['link'],
                ]);
            } else {
                $menus .= View::render('pages/menu/li_dropdown', [
                    'depth_1' => $v['title'],
                    'active' => $v['label'] == $currentModule ? 'active' : '',
                    'dropdown' => self::getDepth_2($v),
                ]);
            }

        }

        return View::render('pages/menu/navbar', [
            'menus' => $menus
        ]);
    }

    public static function getDepth_2($sub_menu)
    {
        $dropdown = '';


        foreach ($sub_menu['submenu'] as $k => $v) {
            $dropdown .= View::render('pages/menu/dropdown', [
                'depth_2' => $v['title'],
                'link' => $v['link'],
            ]);
        }

        return $dropdown;
    }

    public static function getPanel($title, $content, $currentModule)
    {
        $contentPanel = View::render('pages/panel', [
            'menu' => self::getDepth_1($currentModule),
            'content' => $content
        ]);

        return self::getPage($title, $contentPanel);
    }

    public static function getBlankPanel($title, $content, $currentModule)
    {
        $contentPanel = View::render('pages/blankpanel', [
            'content' => $content
        ]);

        return self::getBlankPage($title, $contentPanel);
    }

    public static function getPagination($request, $obPagination)
    {
        $pages = $obPagination->getPages();

        if (count($pages) <= 1) return '';

        $links = '';

        $url = $request->getRouter()->getCurrentUrl();
        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['page'] = $page['page'];

            $link = $url.'?'.http_build_query($queryParams);

            $links .= View::render('pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('pagination/box', [
            'links' => $links
        ]);
    }

}
