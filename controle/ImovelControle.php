<?php

include_once 'modelo/ImovelModelo.php';
include_once 'DAO/ImovelDAO.php';

class ImovelControle {

    function form() {
        //modelo
        # definir regras de negocio tal como permissao de acesso
        //visao
        $visao = new Template();
        $visao->exibir('ImovelVisaoCadastro.php');
    }

    function cadastrar($parametros) {
        //modelo
        $imovelModelo = new ImovelModelo();
        $entidadeImovel = $imovelModelo->cadastrar($parametros);
        $imovelDAO = new ImovelDAO();
        $resultado = $imovelDAO->cadastrar($entidadeImovel);

        //visao
        if ($resultado)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }

    function listar() {
        //modelo
        //$imovelModelo = new ImovelModelo();
        //$entidadeImovel = $imovelModelo->listar();    
        $imovelDAO = new ImovelDAO();
        $listarImovel = $imovelDAO->listar();
        //visao
        $visao = new Template();
        $visao->setItem($listarImovel);
        $visao->exibir('ImovelVisaoListagem.php');
    }

    function selecionar($parametro) {
        //modelo
        $imovelDAO = new ImovelDAO();
        $selecionarImovel = $imovelDAO->selecionar($parametro['id']);
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('ImovelVisaoEdicao.php');
    }

    function editar($parametros) {
        //modelo
        $imovelModelo = new ImovelModelo();
        $entidadeImovel = $imovelModelo->editar($parametros);
        $imovelDAO = new ImovelDAO();
        $resultado = $imovelDAO->editar($entidadeImovel);
        //visao
        if ($resultado)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }

}
