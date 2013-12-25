<?php

include_once 'modelo/Imovel.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Anuncio.php';
include_once 'modelo/pager/Pager.php';
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
        if ($resultado && $idEndereco) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        } else {
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

        session_start();
        
        $imovel = new Imovel();

        $parametros["id"] = $parametro["id"];

        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->consultar($imovel, true, $parametros);
        $_SESSION['id'] = $selecionarImovel[0]->getId();
        $_SESSION['idendereco'] = $selecionarImovel[0]->getIdEndereco();
//        var_dump($_SESSION);
//        die();
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('ImovelVisaoEdicao.php');
    }

    function publicar($parametro) {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->selecionar($imovel, true, $parametro['id'], "id");
        //visao
        $visao = new Template();
        $visao->setItem($selecionarImovel);
        $visao->exibir('AnuncioVisaoPublicar.php');
    }

    function editar($parametro) {
        //modelo
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $imovel = new Imovel();

        session_start();
//        var_dump($_SESSION);
//        die();
        $parametros["id"] = $_SESSION['id'];

        $entidadeImovel = $imovel->editar($parametro);
        $editarImovel = $genericoDAO->editar($entidadeImovel);

        $endereco = new Endereco();
        $parametros["idendereco"] = $_SESSION['idendereco'];
        $entidadeEndereco = $endereco->editar($parametro);
        $editarEndereco = $genericoDAO->editar($entidadeEndereco);

        if ($editarImovel && $editarEndereco) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            session_destroy();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

}
