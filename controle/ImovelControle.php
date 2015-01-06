<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Anuncio.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'assets/pager/Pager.php';
include_once 'DAO/GenericoDAO.php';

class ImovelControle {

    function form() {
        //modelo
        # definir regras de negocio tal como permissao de acesso
        if (Sessao::verificarSessaoUsuario()) {
            //visao
            $visao = new Template();
            $visao->exibir('ImovelVisaoCadastro.php');
        }
    }

    function cadastrar($parametros) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            $visao = new Template();
            if (Sessao::verificarToken($parametros)) {
                $genericoDAO = new GenericoDAO();
                $genericoDAO->iniciarTransacao();
                //consultar existencia de estado, se não existir gravar no banco
                $estado = new Estado();
                $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
                if (!count($selecionarEstado) > 0) {
                    $entidadeEstado = $estado->cadastrar($parametros);
                    $idEstado = $genericoDAO->cadastrar($entidadeEstado);
                } else {
                    $idEstado = $selecionarEstado[0]->getId();
                }
                //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
                $cidade = new Cidade();
                $genericoDAO = new GenericoDAO();
                $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
                if (!count($selecionarCidade) > 0) {
                    $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                    $idCidade = $genericoDAO->cadastrar($entidadeCidade);
                } else {
                    $idCidade = $selecionarCidade[0]->getId();
                }
                //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
                $bairro = new Bairro();
                $genericoDAO = new GenericoDAO();
                $selecionarBairro = $genericoDAO->consultar($bairro, false, array("nome" => $parametros['txtBairro'], "idcidade" => $idCidade));
                if (!count($selecionarBairro) > 0) {
                    $entidadeBairro = $bairro->cadastrar($parametros, $idCidade);
                    $idBairro = $genericoDAO->cadastrar($entidadeBairro);
                } else {
                    $idBairro = $selecionarBairro[0]->getId();
                }

                //gravar endereço e utilizar idestado, idcdidade e idbairro
                $endereco = new Endereco();
                $entidadeEndereco = $endereco->cadastrar($parametros, $idEstado, $idCidade, $idBairro);

                $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
                $imovel = new Imovel();
                $entidadeImovel = $imovel->cadastrar($parametros, $idEndereco);
                $resultado = $genericoDAO->cadastrar($entidadeImovel);

                //visao
                if ($resultado && $idEndereco) {
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                    $visao->setItem("sucessocadastroimovel");
                    $visao->exibir('VisaoErrosGenerico.php');
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    $visao->setItem("errobanco");
                    $visao->exibir('VisaoErrosGenerico.php');
                }
            } else {
                $visao->setItem("errotoken");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        }
    }

    function listar() {
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario']));

            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);
                $listarImovel[] = $selecionarImovel;
            }

            //visao
            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('ImovelVisaoListagem.php');
        }
    }

    function listarEditar() {
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario']));
            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);
                $listarImovel[] = $selecionarImovel;
            }

            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('ImovelVisaoListagemEditar.php');
        }
    }

    function selecionar($parametro) {
        
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken(array("hdnToken" => $parametro["token"]))) {
            $imovel = new Imovel();

            $parametros["id"] = $parametro["id"];
            $parametros["idUsuario"] = $_SESSION['idusuario'];

            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, $parametros);

            if ($selecionarImovel) {

                #verificar a melhor forma de tratar o blindado recursivo
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
                $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);

                $sessao["id"] = $selecionarImovel[0]->getId();
                $sessao["idendereco"] = $selecionarImovel[0]->getIdEndereco();
                Sessao::configurarSessaoImovel($sessao);
                $item = $selecionarImovel;
                $pagina = 'ImovelVisaoEdicao.php';
            } else {
                $item = "errotoken";
                $pagina = 'VisaoErrosGenerico.php';
            }
        } else {
            $item = "errotoken";
            $pagina = 'VisaoErrosGenerico.php';
        }
        $visao = new Template();
        $visao->setItem($item);
        $visao->exibir($pagina);
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
    
    function excluir($parametro) {
        
        var_dump($parametro['hdnImovel']); die();
        
        $imovel = new Imovel();
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $selecionarImovel = $genericoDAO->consultar($imovel, false, array ("id" => $parametro['hdnImovel']));
        
        var_dump($selecionarImovel); die();
        
        $excluirImovel = $genericoDAO->excluir($imovel, $selecionarImovel[0]->getId());
        
        if($excluirImovel){
             $genericoDAO->commit();
             $genericoDAO->fecharConexao();
             echo json_encode(array("resultado" => 1));
             
        }else {
             $genericoDAO->rollback();
             $genericoDAO->fecharConexao();
             echo json_encode(array("resultado" => 0));
        }
    }

    function editar($parametros) {
        $visao = new Template();
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {
            //modelo
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();

            //consultar existencia de estado, se não existir gravar no banco
            $estado = new Estado();
            $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
            if (!count($selecionarEstado) > 0) {
                $entidadeEstado = $estado->cadastrar($parametros);
                $idEstado = $genericoDAO->cadastrar($entidadeEstado);
            } else {
                $idEstado = $selecionarEstado[0]->getId();
            }
            //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
            $cidade = new Cidade();
            $genericoDAO = new GenericoDAO();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }
            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            $genericoDAO = new GenericoDAO();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("nome" => $parametros['txtBairro'], "idcidade" => $idCidade));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($parametros, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }

            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->editar($parametros, $_SESSION["imovel"]["idendereco"], $idEstado, $idCidade, $idBairro);
            $editarEndereco = $genericoDAO->editar($entidadeEndereco);

            $imovel = new Imovel();
            $entidadeImovel = $imovel->editar($parametros);
            $editarImovel = $genericoDAO->editar($entidadeImovel);

            if ($editarImovel & $editarEndereco) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                Sessao::desconfigurarVariavelSessao("imovel");
                $visao->setItem("sucessoedicaoimovel");
                $visao->exibir('VisaoErrosGenerico.php');
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

}
