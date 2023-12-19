<?php

namespace App\Controller\Admin;

use \App\Model\Entity\Testimony as EntityTestimony;
use \App\Utils\View;
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
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        return $itens;
    }
    public static function getTestimonies($request) {
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
        ]);

        return parent::getPanel('Depoimentos > WDEV', $content, 'testimonies');
    }

    public static function getNewTestimony($request) {
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar depoimento',
            'nome' => '',
            'mensagem' => '',
            'status' => '',
        ]);

        return parent::getPanel('Cadastrar depoimento > WDEV', $content, 'testimonies');
    }

    public static function setNewTestimony($request) {
        $postVars = $request->getPostVars();

        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=created');
    }

    private static function getStatus($request) {
        $queryParmas = $request->getQueryParams();

        if (!isset($queryParmas['status'])) return '';

        switch ($queryParmas['status']) {
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso!');

            case  'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso!');

            default:
                return '';
        }
        return Alert::getSuccess('Depoimento atualizado com sucesso!');
    }

    public static function getEditTestimony($request, $id) {
        $obTestimony = EntityTestimony::getTestimonyById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Editar depoimento',
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'status' => self::getStatus($request),
        ]);

        return parent::getPanel('Editar depoimento > WDEV', $content, 'testimonies');
    }

    public static function setEditTestimony($request, $id) {
        $obTestimony = EntityTestimony::getTestimonyById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $postVars = $request->getPostVars();

        $obTestimony->nome = $postVars['nome'] ?? $obTestimony->nome;
        $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
        $obTestimony->atualizar();

        $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=updated');
    }



}
