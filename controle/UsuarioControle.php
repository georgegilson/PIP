<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
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
    }
    
    function selecionar($parametro) {
    //modelo
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $selecionarUsuario = $genericoDAO->consultar($usuario, $parametro['id'], 'id', true);
        //visao
        $visao = new Template();
        $visao->setItem($selecionarUsuario);
        $visao->exibir('UsuarioVisaoEdicao.php');
    }
    
    function buscarLogin($parametros){
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $selecionarUsuario = $genericoDAO->consultar($usuario, false, $parametros['login'], "login");
                        
        if (count($selecionarUsuario) > 0)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }

}
