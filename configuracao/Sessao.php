<?php

class Sessao {

    public static function criarSessaoUsuario() {
        session_start();
    }

    public static function encerrarSessaoUsuario() {
        if (isset($_SESSION["idusuario"])) {
            $_SESSION = array();
            session_destroy();
            return true;
        } else {
            return false;
        }
    }

    public static function verificarSessaoUsuario() {
        if (isset($_SESSION['idusuario']))
            return true;
        else
            return false;
    }

    public static function desconfigurarVariavelSessao($variavel) {
        
    }

    public static function gerarToken() {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
    }

    public static function verificarToken($parametros) {
        if (isset($_SESSION['token']) &&
                $parametros['hdnToken'] == $_SESSION['token']) {

            $token_age = time() - $_SESSION['token_time'];

            if ($token_age <= 1200) {//20 minutos de sessão
                return true;
            } else {
                
            }
        } else {
            
        }
    }

    public static function configurarSessaoUsuario($usuario) {
        $_SESSION["idusuario"] = $usuario[0]->getId();
        $_SESSION["idendereco"] = $usuario[0]->getIdendereco();
        $_SESSION["nome"] = $usuario[0]->getNome();
        $_SESSION["tipopessoa"] = $usuario[0]->getTipousuario();
        $_SESSION["senha"] = $usuario[0]->getSenha();
    }

    public static function configurarSessaoUsuarioPlanoConfirmacao($confirmacao) {
        $_SESSION["usuarioPlano"]["planos"] = $confirmacao["planos"];
        //$_SESSION["usuarioPlano"]["precos"] = $confirmacao["precos"];
        $_SESSION["usuarioPlano"]["total"] = $confirmacao["total"];
        $_SESSION["usuarioPlano"]["tokenPlano"] = $confirmacao["tokenPlano"];
    }

    public static function configurarSessaoAnuncio($anuncio) {
        $_SESSION["anuncio"]["idimovel"] = $anuncio["idimovel"];
        $_SESSION["imagem"] = NULL;
    }

    public static function configurarSessaoImagem($acao,$nome,$dados=NULL) {
        if($acao=="inserir"){
            $_SESSION["imagem"][$nome] = $dados;
        }
        
        if($acao=="excluir"){
            unset($_SESSION["imagem"][$nome]);
        }
    }

}
