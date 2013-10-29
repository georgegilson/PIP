<?php

include_once 'modelo/ImovelModelo.php';
include_once 'DAO/ImovelDAO.php';

class ImovelControle {

    function form() {
        //modelo
            # definir regras de negocio tal como permissao de acesso
        //visao
        $visao = new Template('');
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
        $visao = new Template('');
        $visao->setItem($listarImovel);
        $visao->exibir('ImovelVisaoListagem.php');
    }
    
        function selecionar($parametro) {
    
        $imovelDAO = new ImovelDAO();
        
        $selecionarImovel = $imovelDAO->selecionar($parametro['id']);

        $visao = new Template('');
        $visao->setItem($selecionarImovel);
        $visao->exibir('ImovelVisaoSelecionar.php');
    }
        
        function editar($parametros) {
            
        $imovelModelo = new ImovelModelo();
        $entidadeImovel = $imovelModelo->cadastrar($parametros);    
            
        $imovelDAO = new ImovelDAO();
        
        $editarImovel = $imovelDAO->editar($parametros);

        $visao = new Template('');
        $visao->setItem($editarImovel);
        $visao->exibir('ImovelVisaoSelecionar.php');
    }
    
}
