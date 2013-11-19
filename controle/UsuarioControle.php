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
        $endereco = new Endereco();
        $entidadeEndereco = $endereco->cadastrar($parametros);
        $genericoDAO = new GenericoDAO();
        $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
        //Usuário
        $usuario = new Usuario();
        $entidadeUsuario = $usuario->cadastrar($parametros, $idEndereco);
        $genericoDAO = new GenericoDAO();
        $idUsuario = $genericoDAO->cadastrar($entidadeUsuario);
        //Empresa
        if ($entidadeUsuario->getTipousuario() == "juridica") {
            $empresa = new Empresa();
            $entidadeEmpresa = $empresa->cadastrar($parametros, $idUsuario);
            $genericoDAO = new GenericoDAO();
            $resutadoEmpresa = $genericoDAO->cadastrar($entidadeEmpresa);
        }
        //Telefone
        $quantidadeTelefone = count($parametros['hdnTipoTelefone']);
        if ($quantidadeTelefone > 0) {
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $idUsuario, $indiceTelefone);
                $genericoDAO = new GenericoDAO();
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
            }
        }
        //visao
        if ($idUsuario)
            echo json_encode(array("resultado" => 1));
        else
            echo json_encode(array("resultado" => 0));
    }

}
