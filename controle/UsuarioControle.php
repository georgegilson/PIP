<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'controle/UsuarioPlanoControle.php';
include_once 'DAO/GenericoDAO.php';

class UsuarioControle {

    function form() {
        //modelo
        # definir regras de negocio tal como permissao de acesso
        //visao
        $visao = new Template();
        $visao->exibir('UsuarioVisaoCadastro.php');
    }

    function cadastrar($parametros) {
        //Endereço
        $sessao = new Sessao();
        if ($sessao->verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->cadastrar($parametros);
            $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
            //Usuário
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->cadastrar($parametros, $idEndereco);
            $idUsuario = $genericoDAO->cadastrar($entidadeUsuario);
            //Empresa
            $idEmpresa = false;
            if ($entidadeUsuario->getTipousuario() == "juridica") {
                $empresa = new Empresa();
                $entidadeEmpresa = $empresa->cadastrar($parametros, $idUsuario);
                $idEmpresa = $genericoDAO->cadastrar($entidadeEmpresa);
            } else {
                $idEmpresa = true;
            }
            //Telefone
            $quantidadeTelefone = count($parametros['hdnTipoTelefone']);
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $idUsuario, $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }

            if ($idEndereco && $idUsuario && $idEmpresa && $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
            }
        } else {
            
        }
    }

    function selecionar($parametro) {
        //modelo
        $sessao = new Sessao();
        if ($sessao->verificarSessaoUsuario()) {

            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, true, array("id" => $_SESSION["idusuario"]));
            //visao
            $visao = new Template();
            $visao->setItem($selecionarUsuario);
            $visao->exibir('UsuarioVisaoEdicao.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    function alterar($parametros) {
        $sessao = new Sessao();
        if ($sessao->verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->editar($parametros);
            $idEndereco = $genericoDAO->editar($entidadeEndereco);
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->editar($parametros);
            $genericoDAO = new GenericoDAO();
            $resultado = $genericoDAO->editar($entidadeUsuario);
            //visao
            if ($resultado)
                echo json_encode(array("resultado" => 1));
            else
                echo json_encode(array("resultado" => 0));
        }else {
            /* More than five minutes has passed. */
        }
    }

    function buscarLogin($parametros) {
        $sessao = new Sessao();
        if ($sessao->verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $dados["login"] = $parametros['txtLogin'];
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, $dados);

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            
        }
    }

    function autenticar($parametros) {
        $sessao = new Sessao();
        if ($sessao->verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));

            if (!$selecionarUsuario == 0) {
                if ($selecionarUsuario[0]->getSenha() == md5($parametros['txtSenha'])) {
                    $_SESSION["idusuario"] = $selecionarUsuario[0]->getId();
                    $_SESSION["idendereco"] = $selecionarUsuario[0]->getIdendereco();
                    $_SESSION["nome"] = $selecionarUsuario[0]->getNome();
//                    echo json_encode(array("resultado" => 1, "nome" => $selecionarUsuario[0]->getNome()));
                    $redirecionamento = new UsuarioPlanoControle();
                    $redirecionamento->listar();
                } else {
                    echo json_encode(array("resultado" => 0, "condicao" => "senha"));
                    //login ou senha inválido
                }
            } else {
                echo json_encode(array("resultado" => 0, "condicao" => "cadastro"));
                //login ou senha inválido
            }
        } else {
            echo json_encode(array("resultado" => 0, "condicao" => "token"));
        }
    }

    function logout($parametros) {
        $sessao = new Sessao();
        if ($sessao->encerrarSessaoUsuario()) {
            echo json_encode(array("resultado" => 1));
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }

}
