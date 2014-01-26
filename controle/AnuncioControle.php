<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'assets/pager/Pager.php';

class AnuncioControle {

    function form($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken(array("hdnToken" => $parametros["token"]))) {
            //modelo
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametros['idImovel']));

            $usuarioPlano = new UsuarioPlano();
            $condicoes["idusuario"] = $_SESSION["idusuario"];
            $condicoes["status"] = 'ativo';
            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $condicoes);

            $sessao["idimovel"] = $parametros['idImovel'];
            Sessao::configurarSessaoAnuncio($sessao);
            $formAnuncio = array();
            $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
            $formAnuncio["imovel"] = $selecionarImovel;

            #verificar se o anuncio ja foi publicado e redirecionar para a tela de consulta
            //visao
            $visao = new Template();
            $visao->setItem($formAnuncio);
            $visao->exibir("AnuncioVisaoPublicar.php");
        }
    }

    function cadastrar($parametros) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            if (isset($parametros['upload']) & $parametros['upload'] === "1") {
                include_once 'controle/ImagemControle.php';
                $imagem = new ImagemControle($parametros);
            } else {
                if (Sessao::verificarToken($parametros)) {

                    $genericoDAO = new GenericoDAO();
                    $genericoDAO->iniciarTransacao();

                    $anuncio = new Anuncio();
                    $entidadeAnuncio = $anuncio->cadastrar($parametros);
                    $idAnuncio = $genericoDAO->cadastrar($entidadeAnuncio);

                    $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                    $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                    if (($entidadeUsuarioPlano->getPlano()->getTitulo() != "infinity" && $_SESSION["tipopessoa"] == "pj") || $_SESSION["tipopessoa"] == "pf") {
                        //se o plano nao eh infinity e nem eh uma empresa, entao atualiza o status do usuarioplano
                        $entidadeUsuarioPlano->setStatus("utilizado");
                        $genericoDAO->editar($entidadeUsuarioPlano);
                    }

                    if (isset($_SESSION["imagem"])) {
                        foreach ($_SESSION["imagem"] as $file) {
                            $imagem = new Imagem();
                            $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, $parametros["rdbCapa"]);
                            $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                        }
                    }

                    //visao
                    if ($idAnuncio) {
                        echo json_encode(array("resultado" => 1));
                        $genericoDAO->commit();
                    } else {
                        echo json_encode(array("resultado" => 0));
                        $genericoDAO->rollback();
                    }
                }
            }
        }
    }

    function listar() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $consultasAdHoc = new ConsultasAdHoc();
            $listarAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario']);
            //visao
            $visao = new Template();
            $visao->setItem($listarAnuncio);
            $visao->exibir('AnuncioVisaoListagem.php');
        }
    }

    function listarCadastrar() {
        if (Sessao::verificarSessaoUsuario()) {
            $consultasAdHoc = new ConsultasAdHoc();
            $listarCadastrarAnuncio = $consultasAdHoc->ConsultarImoveisNaoAnunciadosPorUsuario($_SESSION['idusuario']);
//            var_dump($_SESSION['idusuario']);
            //echo "<pre>";print_r($listarCadastrarAnuncio);
            //visao
            $visao = new Template();
            $visao->setItem($listarCadastrarAnuncio);
            $visao->exibir('AnuncioVisaoListagemCadastrar.php');
        }
    }

    function comparar($parametros) {
        $consultasAdHoc = new ConsultasAdHoc();
        $listarAnuncio = $consultasAdHoc->ConsultarAnunciosPublicos($parametros['selecoes']);
        $visao = new Template();
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoTeste3.php');
//        Tratamento de exceção para nenhum anuncio selecionado.
//        print_r($listarAnuncio[0]->condicao);
//        die();
    }


    function buscar($parametros) {

        //erro ano passar o parametro

        $anuncio = new Anuncio();

        $consultasAdHoc = new ConsultasAdHoc();
        $listarAnuncio = $consultasAdHoc->bucarImovel($parametros);
        $visao = new Template();
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoBusca.php'); 
        //$selecionarAnuncio = $genericoDAO->consultar($anuncio, true, array("",$parametros[]));
        //retorno da busca está errado
//            echo "<pre>";
//             print_r($selecionarAnuncio);
//            echo "</pre>";
//            die();
//            
//        var_dump($_SESSION);
//        die();
        //visao
    }
    
    function modal($parametros) {
        $visao = new Template('ajax');
        $genericoDAO = new GenericoDAO();
        $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("id" => $parametros["hdnModal"]));
        $item["imagem"] = $genericoDAO->consultar(new Imagem(), false, array("idanuncio" => $item["anuncio"][0]->getId()));
        $item["imovel"] = $genericoDAO->consultar(new Imovel(), false, array("id" => $item["anuncio"][0]->getIdimovel()));
        $item["endereco"] = $genericoDAO->consultar(new Endereco(), false, array("id" => $item["imovel"][0]->getIdendereco()));
        $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $item["imovel"][0]->getIdusuario()));
        $visao->setItem($item);
        $visao->exibir('AnuncioVisaoModal.php');
    }

    /*
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
