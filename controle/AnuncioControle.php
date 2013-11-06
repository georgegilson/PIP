<?php

include_once 'modelo/Anuncio.php';
include_once 'DAO/GenericoDAO.php';

class AnuncioControle {

    function form() {
        //modelo
        # definir regras de negocio tal como permissao de acesso
        //visao
        $visao = new Template();
        $visao->exibir('AnuncioVisaoCadastro.php');
    }

    function cadastrar($parametros) {
        //modelo
        $anuncio = new Anuncio();
        $entidadeAnuncio = $anuncio->cadastrar($parametros);
        $genericoDAO = new GenericoDAO();
        $resultado = $genericoDAO->cadastrar($entidadeAnuncio);        
        //visao
        if ($resultado)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }
/*
    function listar() {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $listarImovel = $genericoDAO->listar($imovel);
        //visao
        $visao = new Template();
        $visao->setItem($listarImovel);
        $visao->exibir('ImovelVisaoListagem.php');
    }*/

    function selecionar($parametro) {
        //modelo
        $anuncio = new Anuncio();
        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->selecionar($anuncio, $parametro['id']);
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('AnuncioVisaoPublicar.php');
    }
    
/*

    function editar($parametros) {
        //modelo
        $imovel = new Imovel();
        $entidadeImovel = $imovel->editar($parametros);
        $genericoDAO = new GenericoDAO();
        $resultado = $genericoDAO->editar($entidadeImovel);
        //visao
        if ($resultado)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }
    
*/
}
