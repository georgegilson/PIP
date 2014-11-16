<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/HistoricoAluguelVenda.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'assets/pager/Pager.php';
include_once 'modelo/Mensagem.php';
include_once 'modelo/AnuncioClique.php';
include_once 'modelo/EmailAnuncio.php';

class AnuncioControle {

    function form($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken(array("hdnToken" => $parametros["token"]))) {
            //modelo
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametros['idImovel'], "idUsuario" => $_SESSION['idusuario']));
            #verificar a melhor forma de tratar o blindado recursivo
            $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
            $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);
            //verifica se existe o imovel selecionado
            if ($selecionarImovel) {
                //verificar se o anuncio ja foi publicado e redirecionar para a tela de consulta
                $anuncios = $selecionarImovel[0]->getAnuncio();
                if (count($anuncios) > 0) {
                    if ($anuncios->getStatus() == "cadastrar") {
                        $redirecionamento = $this;
                        $redirecionamento->listarCadastrar();
                        return;
                    }
                }
                $usuarioPlano = new UsuarioPlano();
                $condicoes["idusuario"] = $_SESSION["idusuario"];
                $condicoes["status"] = 'ativo';
                $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $condicoes);
                $sessao["idimovel"] = $parametros['idImovel'];
                Sessao::configurarSessaoAnuncio($sessao);
                $formAnuncio = array();
                $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
                $formAnuncio["imovel"] = $selecionarImovel;
                $formAnuncio["anuncio"] = ($anuncios != NULL ? $anuncios : new Anuncio());
                $item = $formAnuncio;
                $pagina = "AnuncioVisaoPublicar.php";
            } else {
                $item = "errotoken";
                $pagina = "VisaoErrosGenerico.php";
            }
            //visao
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        } else {
            $item = "errotoken";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
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
                            $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, $parametros["rdbDestaque"]);
                            $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                        }
                    } else {
                        $imagem = new Imagem();
                        $file->url = PIPURL . "/assets/imagens/foto_padrao.png";
                        $file->legenda = "";
                        $file->name = "padrao";
                        $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, "padrao");
                        $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                    }

                    //visao
                    if ($idAnuncio) {
                        $genericoDAO->commit();
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagem");
                        echo json_encode(array("resultado" => 1));
                    } else {
                        $genericoDAO->rollback();
                        echo json_encode(array("resultado" => 0));
                    }
                }
            }
        }
    }

    function listar() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();
            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario']);
            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);
                $historicoAluguelVenda = $genericoDAO->consultar(new HistoricoAluguelVenda(), false, array("idAnuncio" => $anuncio->getId()));
                $anuncio->setHistoricoAluguelVenda($historicoAluguelVenda[0]);
                $listarAnuncio[] = $anuncio;
            }
            //visao
            $visao = new Template();
            $visao->setItem($listarAnuncio);
            $visao->exibir('AnuncioVisaoListagem.php');
        }
    }

    function listarCadastrar() {
        if (Sessao::verificarSessaoUsuario()) {
            $consultasAdHoc = new ConsultasAdHoc();
            $listaImoveis = $consultasAdHoc->ConsultarImoveisNaoAnunciadosPorUsuario($_SESSION['idusuario']);

            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $consultasAdHoc->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);
                $listarImovel[] = $selecionarImovel;
            }

            //visao
            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('AnuncioVisaoListagemCadastrar.php');
        }
    }

    function finalizarNegocio($parametros) {
        if (Sessao::verificarSessaoUsuario()) {
            if (Sessao::verificarToken($parametros)) {
                $genericoDAO = new GenericoDAO();
                $entidadeAnuncio = new Anuncio();
                $selecionarAnuncio = $genericoDAO->consultar($entidadeAnuncio, false, array("id" => $parametros["hdnAnuncio"]));
                $entidadeAnuncio = $selecionarAnuncio[0];
                $entidadeAnuncio->setStatus('finalizado');
                $entidadeAnuncio->setDatahoraalteracao(date('d/m/Y H:i:s'));
                $genericoDAO->editar($entidadeAnuncio);

                $historicoAluguelVenda = new HistoricoAluguelVenda();
                $entidadeHistoricoAluguelVenda = $historicoAluguelVenda->cadastrar($parametros);
                $resultadoFinalizarNegocio = $genericoDAO->cadastrar($entidadeHistoricoAluguelVenda);

                if ($resultadoFinalizarNegocio) {
                    echo json_encode(array("resultado" => 1));
                } else {
                    echo json_encode(array("resultado" => 0));
                }
            }
        }
    }

    function comparar($parametros) {
        $consultasAdHoc = new ConsultasAdHoc();
        $listarAnuncio = $consultasAdHoc->ConsultarAnunciosPublicos($parametros['selecoes']);
        $visao = new Template();
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoComparar.php');
//        Tratamento de exceção para nenhum anuncio selecionado.
//        print_r($listarAnuncio[0]->condicao);
//        die();
    }

    function buscar($parametros) {

        //erro ano passar o parametro

        $anuncio = new Anuncio();

        $consultasAdHoc = new ConsultasAdHoc();
        $listarAnuncio = $consultasAdHoc->buscarImovel($parametros);
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

    function buscarAvancado($parametros) {

        //erro ano passar o parametro

        $anuncio = new Anuncio();

        $consultasAdHoc = new ConsultasAdHoc();
        $listarAnuncio = $consultasAdHoc->buscarAvancado($parametros);
//        var_dump($listarAnuncio);
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
        $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdendereco()));
        $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $item["imovel"][0]->getIdusuario()));

        $genericoDAO->iniciarTransacao();

        $anuncioClique = new AnuncioClique();

        $anuncios = $anuncioClique->Cadastrar($parametros);

        $cliqueAnuncio = $genericoDAO->cadastrar($anuncios);

        $genericoDAO->commit();

        $visao->setItem($item);
        $visao->exibir('AnuncioVisaoModal.php');
    }

    function enviarContato($parametros) {
//      if (Sessao::verificarToken($parametros)) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $mensagem = new Mensagem();
        $entidadeMensagem = $mensagem->cadastrar($parametros);
        $resultadoMensagem = $genericoDAO->cadastrar($entidadeMensagem);
        if ($resultadoMensagem) {
            //Enviar email para o anunciante;
            $selecionarUsuario = $genericoDAO->consultar(new Usuario(), false, array("id" => $parametros['idusuario']));
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $parametros['idanuncio']));
            $dadosEmail['destino'] = $selecionarUsuario[0]->getEmail();
            $dadosEmail['contato'] = $parametros['nome'];
            $dadosEmail['msg'] = "Você recebeu uma mensagem nova! Acesse a sua caixa de mensagens do PIP";
            $dadosEmail['assunto'] = $selecionarAnuncio[0]->getTituloAnuncio();
            if (Email::enviarEmail($dadosEmail)) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            }
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        }
    }

    function enviarEmail($parametros) {
//            var_dump($parametros['email']);
//        print_r($parametros['selecoes']);
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $dadosEmail['destino'] = $parametros['email'];
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = "Fulano de tal selecionou este(s) immóvel(is) para você!";
        $dadosEmail['msg'] .= '<table class="body" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" valign="top" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
    <center style="width: 100%; min-width: 580px;">
    <table class="row header" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; background: #999999; padding: 0px;" bgcolor="#999999"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" valign="top">
    <center style="width: 100%; min-width: 580px;">
    <table class="container" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">
    <table class="twelve columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="six sub-columns" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; min-width: 0px; width: 50%; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 10px 10px 0px;" align="left" valign="top">
    <img src="http://placehold.it/200x50" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;" align="left" /></td>
    <td class="six sub-columns last" style="text-align: right; vertical-align: middle; word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; min-width: 0px; width: 50%; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="right" valign="middle">
    <span class="template-label" style="color: #ffffff; font-weight: bold; font-size: 11px;">BASIC</span>
    </td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    </tr></table></center>
    </td>
    </tr></table>';
        foreach ($parametros['selecoes'] as $idanuncio) {
            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("id" => $idanuncio['value']));
            $item["imagem"] = $genericoDAO->consultar(new Imagem(), false, array("idanuncio" => $item["anuncio"][0]->getId()));
            $item["imovel"] = $genericoDAO->consultar(new Imovel(), false, array("id" => $item["anuncio"][0]->getIdimovel()));
            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdendereco()));
//            $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $item["imovel"][0]->getIdusuario()));
            $anuncio = $item["anuncio"][0];
            $imovel = $item["imovel"][0];
            $endereco = $item["endereco"][0];
//            $usuario = $item["usuario"][0];
            $imagens = $item["imagem"][0];

//            var_dump($imagens);
//            die();
            $emailanuncio = new EmailAnuncio();
            $selecionaremailanuncio = $emailanuncio->cadastrar($idanuncio['value']);
            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);

            $dadosEmail['msg'] .=
                   '
    <table class="container" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">
    <table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">
    <!--<table class="twelve columns">
    <tr>
    <td>
    <h1>Hi, Susan Calvin</h1>
    <p class="lead">Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae.</p>
    <p>Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. consequat vel lacus. Sed iaculis pulvinar ligula, ornare fringilla ante viverra et. In hac habitasse platea dictumst. Donec vel orci mi, eu congue justo. Integer eget odio est, eget malesuada lorem. Aenean sed tellus dui, vitae viverra risus. Nullam massa sapien, pulvinar eleifend fringilla id, convallis eget nisi. Mauris a sagittis dui. Pellentesque non lacinia mi. Fusce sit amet libero sit amet erat venenatis sollicitudin vitae vel eros. Cras nunc sapien, interdum sit amet porttitor ut, congue quis urna.</p>
    </td>
    <td class="expander"></td>
    </tr>
    </table>-->
    <table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 20px 0px 0px;" align="left" valign="top">

          <table class="three columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 130px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                <img height="130" width="130" src=" ' . $imagens->getDiretorio() . '" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;" align="left" /></td>
              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
            </tr></table></td>
        <td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

          <table class="nine columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 430px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                <table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Tipo</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . strtoupper($imovel->getTipo()) . '</span>
    </td>
    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Finalidade</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . strtoupper($anuncio->getFinalidade()) . '</span>
    </td>
    </tr></tbody></table><br /><table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Condição</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . $imovel->getCondicao() . '</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Valor</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>R$' . $anuncio->getValor() . '</span>
    </td>
    </tr></tbody></table><br /><table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Endereço</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>'. $endereco->getLogradouro() . ', Nº ' . $endereco->getNumero() .' , ' . $endereco->getBairro()->getNome() . ' , ' . $endereco->getCidade()->getNome() . '</span>
    </td>
    </tr></tbody></table></td>
              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
            </tr></table></td>
      </tr></table></td>
    </tr></table><table class="row callout" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 20px;" align="left" valign="top">
    <table class="twelve columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="panel" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ECF8FF; margin: 0; padding: 10px; border: 1px solid #b9e5ff;" align="left" bgcolor="#ECF8FF" valign="top">
    <p style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Acesse agora esse imóvel <a href="http://localhost/PIP/index.php?entidade=Anuncio&amp;acao=verficahashemail&amp;id=' . $selecionaremailanuncio->getHash() . '" style="color: #2ba6cb; text-decoration: none;">Clique Aqui! »</a></p>
    </td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    </tr></table> <br>';
//            print_r($dadosEmail);
//            die();
        }
        
        $dadosEmail['msg'] .= '<table class="row footer" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 20px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">
    <table class="six columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="left-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px 10px;" align="left" valign="top">
    <h5 style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Connect With Us:</h5>
    <table class="tiny-button facebook" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #3b5998; margin: 0; padding: 5px 0 4px; border: 1px solid #2d4473;" align="center" bgcolor="#3b5998" valign="top">
    <a href="#" style="color: #ffffff; text-decoration: none; font-weight: normal; font-family: Helvetica,Arial,sans-serif; font-size: 12px;">Facebook</a>
    </td>
    </tr></table><br /><table class="tiny-button twitter" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #00acee; margin: 0; padding: 5px 0 4px; border: 1px solid #0087bb;" align="center" bgcolor="#00acee" valign="top">
    <a href="#" style="color: #ffffff; text-decoration: none; font-weight: normal; font-family: Helvetica,Arial,sans-serif; font-size: 12px;">Twitter</a>
    </td>
    </tr></table><br /><table class="tiny-button google-plus" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #DB4A39; margin: 0; padding: 5px 0 4px; border: 1px solid #cc0000;" align="center" bgcolor="#DB4A39" valign="top">
    <a href="#" style="color: #ffffff; text-decoration: none; font-weight: normal; font-family: Helvetica,Arial,sans-serif; font-size: 12px;">Google +</a>
    </td>
    </tr></table></td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    <td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">
    <table class="six columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="last right-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">
    <h5 style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Contact Info:</h5>
    <p style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Phone: 408.341.0600</p>
    <p style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Email: <a href="/cdn-cgi/l/email-protection#b0d8c3d5dcd4dfdef0c4c2d1dec4dfc29ed3dfdd" style="color: #2ba6cb; text-decoration: none;"><span class="__cf_email__" data-cfemail="670f14020b03080927131506091308154904080a">[email protected]</span></a></p>
    </td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    </tr></table><table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">
    <table class="twelve columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" valign="top">
    <center style="width: 100%; min-width: 580px;">
    <p style="text-align: center; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="center"><a href="#" style="color: #2ba6cb; text-decoration: none;">Terms</a> | <a href="#" style="color: #2ba6cb; text-decoration: none;">Privacy</a> | <a href="#" style="color: #2ba6cb; text-decoration: none;">Unsubscribe</a></p>
    </center>
    </td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    </tr></table></td>
    </tr></table></center>
    </td>
    </tr></table>';
        
        if (Email::enviarEmail($dadosEmail)) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
        //       die();
    }

    function verficahashemail($parametros) {
        $visao = new Template();
        $emailanuncio = new EmailAnuncio();
        $anuncio = new Anuncio();
        $genericoDAO = new GenericoDAO();
        $selecionaremailanuncio = $genericoDAO->consultar($emailanuncio, false, array("hash" => $parametros["id"]));
        //echo "<pre>";var_dump($selecionaremailanuncio); echo "</pre>"; die();
        $anuncio->buscarDestaqueImagem($parametros);
        if ($selecionaremailanuncio) {
            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("id" => $selecionaremailanuncio[0]->getIdanuncio()));
            $item["imagem"] = $genericoDAO->consultar(new Imagem(), false, array("idanuncio" => $item["anuncio"][0]->getId(), "destaque" => "SIM"));
            $item["imovel"] = $genericoDAO->consultar(new Imovel(), false, array("id" => $item["anuncio"][0]->getIdimovel()));
            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdendereco()));
            $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $item["imovel"][0]->getIdusuario()));
            $cadastrado = $anuncio = $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("id" => $selecionaremailanuncio[0]->getIdanuncio()));
            $verificarStatus = $cadastrado[0];
            if ($verificarStatus->getStatus() == "cadastrado") {
                $visao->setItem($item);
                $visao->exibir('AnuncioVisaoEmail.php');
            } else {
                $visao->setItem("erroanuncioinativo");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        } else {
            $visao->setItem("errohashemail");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

}
