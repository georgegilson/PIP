<?php

class Sessao {
    
//    private $token;
//    
//     public function getToken() {
//        return $this->token;
//    }
//
//    public function setToken($token) {
//        $this->token = $token;
//    }

    public function __construct() {
        
    }

    public function criarSessaoUsuario() {
        session_start();
    }

    public function encerrarSessaoUsuario() {
        if (isset($_SESSION["idusuario"])) {
            $_SESSION = array();
            session_destroy();
            return true;
        } else {
            return false;
        }
    }

    public function verificarSessaoUsuario() {
        if (isset($_SESSION['idusuario']))
            return true;
        else
            return false;
    }

    public function desconfigurarVariavelSessao($variavel){
        
    }

    public function gerarToken() {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
    }

    public function verificarToken($parametros) {
        if (isset($_SESSION['token']) &&
                $parametros['hdnToken'] == $_SESSION['token']) {

            $token_age = time() - $_SESSION['token_time'];

            if ($token_age <= 300) {
                return true;
            } else {
                
            }
        } else {
            
        }
    }

    public function configurarSessaoUsuario($usuario){
        $_SESSION["idusuario"] = $usuario[0]->getId();
        $_SESSION["idendereco"] = $usuario[0]->getIdendereco();
        $_SESSION["nome"] = $usuario[0]->getNome();
    }
}

