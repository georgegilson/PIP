<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'DAO/GenericoDAO.php';

class AnuncioControle {

    function form($parametro) {
        //modelo
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametro['idImovel']));

        $usuarioPlano = new UsuarioPlano();
//        var_dump($usuarioPlano);
//        die();
        $parametros["idusuario"] = 1;
        $parametros["status"] = 'ativo';
        $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $parametros);

        $formAnuncio = array();
        $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
        $formAnuncio["imovel"] = $selecionarImovel;

        #verificar se o anuncio ja foi publicado e redirecionar para a tela de consulta
        //visao
        $visao = new Template();
        $visao->setItem($formAnuncio);
        $visao->exibir('AnuncioVisaoPublicar.php');
    }

    function cadastrar($parametros) {
        //modelo
        if (isset($parametros['upload']) && $parametros['upload'] === "1") {
            include_once 'controle/ImagemControle.php';
            $imagem = new ImagemControle($parametros);
        } else {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();

            $anuncio = new Anuncio();
            $entidadeAnuncio = $anuncio->cadastrar($parametros);
            $idAnuncio = $genericoDAO->cadastrar($entidadeAnuncio);

            $entidadeUsuarioPlano = new UsuarioPlano();
            $entidadeUsuarioPlano->setId($parametros["sltPlano"]);
            $entidadeUsuarioPlano->setStatus("publicado");
            $genericoDAO->editar($entidadeUsuarioPlano);

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
