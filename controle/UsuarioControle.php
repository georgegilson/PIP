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
        $genericoDAO->iniciarTransação();
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

        if ($idEndereco && $idUsuario && $idEmpresa && $idTelefone) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexão();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexão();
            echo json_encode(array("resultado" => 0));
        }
    }

}
