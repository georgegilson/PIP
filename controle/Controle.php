<?php

class Controle {

    public function __construct($parametros) {
        //vem do menu
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $entidade = $parametros['entidade'];
            $acao = $parametros['acao'];
            if ($entidade == "" && $acao == "") {
                $this->index();
            } else {
                include_once ($entidade . "Controle.php");
                $classe = $entidade . "Controle";
                $controle = new $classe;
                $contexto = $controle->$acao($parametros);
            }
        }
        //vem do formulario
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $entidade = $parametros['hdnEntidade'];
            $acao = $parametros['hdnAcao'];
            include_once ($entidade . "Controle.php");
            $classe = $entidade . "Controle";
            $controle = new $classe;
            $controle->$acao($parametros);
        }
    }

    public function index() {
        //modelo
        
        //visao
        $visao = new Template();
        $visao ->exibir('index', 1);
    }

}
