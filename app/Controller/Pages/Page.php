<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Page {

    public static function getPage($title, $content) {
        return View::render('pages/page', [
            'title' => $title,
            'content' => $content
        ]);
    }

    private static $menus = [
        [
            'label' => 'menu1',
            'title' => '메뉴1',
            'link'  => URL."/page/page_1"
        ],
        [
            'label' => 'menu2',
            'title' => '메뉴2',
            'link'  => URL."/page/page_2"
        ],
        [
            'label' => 'menu3',
            'title' => '메뉴3',
            'submenu'=>[
                ['label' => 'menu3_1', 'title' => '메뉴3_1', 'link' => URL.'/page/page_3_1'],
                ['label' => 'menu3_2', 'title' => '메뉴3_2', 'link' => URL.'/page/page_3_2'],
            ],
        ],
    ];


    public static function getDepth_1($currentModule) {

        $menus = '';

        foreach (self::$menus as $k => $v) {
            if (!array_key_exists('submenu', $v)) {
                $menus .= View::render('pages/menu/li', [
                    'depth_1' => $v['title'],
                    'active'  => $v['label'] == $currentModule ? 'active' : '',
                    'link'    => $v['link'],
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

    public static function getDepth_2($sub_menu) {
        $dropdown = '';


        foreach ($sub_menu['submenu'] as $k => $v) {
            $dropdown .= View::render('pages/menu/dropdown', [
                'depth_2' => $v['title'],
                'link'    => $v['link'],
            ]);
        }

        return $dropdown;
    }

    public static function getPanel($title, $content, $currentModule) {
        $contentPanel = View::render('pages/panel', [
            'menu' => self::getDepth_1($currentModule),
            'content' => $content
        ]);

        return self::getPage($title, $contentPanel);
    }

    public static function getPagination($request, $obPagination) {
        $pages = $obPagination->getPages();

        if (count($pages) <=1 ) return '';

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