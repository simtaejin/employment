<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Http\Request;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page {

    public static function getTestimonyItems($request, &$obPagination) {
        $itens = '';

        $quantidatetotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        $queryParams = $request->getQueryParams();
        $paginaaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidatetotal, $paginaaAtual, 1);

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        return $itens;
    }

    public static function getTestimonies($request) {
        $content = View::render('pages/testimonies', [
            'itens'       => self::getTestimonyItems($request, $obPagination),
            'pagination'  => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('DEPOIMENTOS > WDEV', $content);
    }

    public static function insertTestimony($request) {
        $postVars = $request->getPostVars();

        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies($request);

    }
}