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
include_once 'modelo/EmailAnuncio';

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
                if (count($selecionarImovel[0]->getAnuncio()) > 0) {
                    $redirecionamento = $this;
                    $redirecionamento->listarCadastrar();
                    return;
                } else {
                    $usuarioPlano = new UsuarioPlano();
                    $condicoes["idusuario"] = $_SESSION["idusuario"];
                    $condicoes["status"] = 'ativo';
                    $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $condicoes);

                    $sessao["idimovel"] = $parametros['idImovel'];
                    Sessao::configurarSessaoAnuncio($sessao);
                    $formAnuncio = array();
                    $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
                    $formAnuncio["imovel"] = $selecionarImovel;
                    $item = $formAnuncio;
                    $pagina = "AnuncioVisaoPublicar.php";
                }
            } else {
                $item = "errotoken";
                $pagina = "VisaoErrosGenerico.php";
            }
            //visao
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
        foreach ($parametros['selecoes'] as $idanuncio) {
            $emailanuncio = new EmailAnuncio();
            $selecionaremailanuncio = $emailanuncio->cadastrar($idanuncio);
            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);
//            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $idanuncio['value']));
            $dadosEmail['msg'] += "Acesse agora esse imóvel <br>
                <a href=http://localhost/PIP/index.php?entidade=Anuncio&acao=verficahashemail&id=" . $selecionaremailanuncio->getHash() . ">http://localhost/PIP/index.php?entidade=Anuncio&acao=verficahashemail&id=" . $selecionaremailanuncio->getHash() . "</a><br>";
        }
        if (Email::enviarEmail($dadosEmail)) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
        }
        //       die();
    }

    function verficahashemail($parametros) {
        $visao = new Template();
        $emailanuncio = new EmailAnuncio();
        $anuncio = new Anuncio();
        $genericoDAO = new GenericoDAO();
        $selecionaremailanuncio = $genericoDAO->consultar($emailanuncio, false, array("hash" => $parametros["id"]));
        if ($selecionaremailanuncio) {
            $selecionaranuncio = $genericoDAO->consultar($anuncio, true, array("id" => $selecionaremailanuncio->getIdanuncio()));
            if ($selecionaranuncio->getStatus() == "cadastrado") {
                $visao->setItem($selecionaranuncio);
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
