<?php
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Plano.php';
include_once 'DAO/GenericoDAO.php';

class UsuarioPlanoControle {

    function listar() {
        //modelo
        $usuarioPlano = new UsuarioPlano();
        $plano = new Plano();
        $genericoDAO = new GenericoDAO();
        
        $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => "1"));
        $listarPlano = $genericoDAO->consultar($plano, true, array("status" => "ativo"));
        
        $formUsuarioPlano = array();
        $formUsuarioPlano["usuarioPlano"] = $listarUsuarioPlano;
        $formUsuarioPlano["plano"] = $listarPlano;
        //visao
        $visao = new Template();
        $visao->setItem($formUsuarioPlano);
        $visao->exibir('UsuarioPlanoVisaoListagem.php');
    }

}
