<?php

include_once 'modelo/Imovel.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Anuncio.php';
include_once 'DAO/GenericoDAO.php';

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
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $endereco = new Endereco();
        $entidadeEndereco = $endereco->cadastrar($parametros); 
        $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
        
        $imovel = new Imovel();
        $entidadeImovel = $imovel->cadastrar($parametros, $idEndereco);
        $resultado = $genericoDAO->cadastrar($entidadeImovel);
        
        //visao
        if ($resultado && $idEndereco){
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        }
        else{
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

    function listar() {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $listarImovel = $genericoDAO->consultar($imovel, true);
        //visao
        $visao = new Template();
        $visao->setItem($listarImovel);
        $visao->exibir('ImovelVisaoListagem.php');
    }

    function selecionar($parametro) {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->consultar($imovel, true, $parametro['id'], "id");
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('ImovelVisaoEdicao.php');
    }
    
    function publicar($parametro) {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->selecionar($imovel, true ,$parametro['id'], "id");
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('AnuncioVisaoPublicar.php');
    }

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
    

}
