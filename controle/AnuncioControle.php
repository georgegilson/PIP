<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'DAO/GenericoDAO.php';

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

            $empresa = ($_SESSION["tipopessoa"] == "pj");
            if ($empresa) {
                $pagina = 'AnuncioVisaoEmpresaPublicar.php';
            } else {
                $pagina = 'AnuncioVisaoPublicar.php';
            }
            $sessao["idimovel"] = $parametros['idImovel'];
            Sessao::configurarSessaoAnuncio($sessao);
            $formAnuncio = array();
            $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
            $formAnuncio["imovel"] = $selecionarImovel;

            #verificar se o anuncio ja foi publicado e redirecionar para a tela de consulta
            //visao
            $visao = new Template();
            $visao->setItem($formAnuncio);
            $visao->exibir($pagina);
        }
    }

    function cadastrar($parametros) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            if (isset($parametros['upload']) && $parametros['upload'] === "1") {
                include_once 'controle/ImagemControle.php';
                $imagem = new ImagemControle($parametros);
            } else {
                if (Sessao::verificarToken($parametros)) {
                    $genericoDAO = new GenericoDAO();
                    $genericoDAO->iniciarTransacao();

                    $empresa = ($_SESSION["tipopessoa"] == "pj");
                    if ($empresa) {
                        //$parametros['sltPlano'] = 1; #se for empresa trocar pelo idusuarioplano na sessão
                    }

                    $anuncio = new Anuncio();
                    $entidadeAnuncio = $anuncio->cadastrar($parametros);
                    $idAnuncio = $genericoDAO->cadastrar($entidadeAnuncio);

                    if (!$empresa) { #se não for pessoa fisica atualiza o status do usuarioplano
                        $entidadeUsuarioPlano = new UsuarioPlano();
                        $entidadeUsuarioPlano->setId($parametros["sltPlano"]);
                        $entidadeUsuarioPlano->setStatus("utilizado");
                        $genericoDAO->editar($entidadeUsuarioPlano);
                    }

                    if (isset($parametros["hdnImagem"])) {
                        foreach ($parametros["hdnImagem"] as $idImagem) {
                            $entidadeImagem = new Imagem();
                            $entidadeImagem->setId($idImagem);
                            $entidadeImagem->setIdanuncio($idAnuncio);
                            $genericoDAO->editar($entidadeImagem);
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
       if (Sessao::verificarSessaoUsuario()){
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $listarAnuncio = $genericoDAO->consultar($anuncio, true, array("idusuarioplano" => $_SESSION['idusuario']));
            //visao
            $visao = new Template();
            $visao->setItem($listarAnuncio);
            $visao->exibir('AnuncioVisaoListagem.php');
        } 
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