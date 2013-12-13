<?php

class Controle {

    public function __construct($parametros) {
        //vem do menu
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $entidade = (isset($parametros['entidade']))?$parametros['entidade']:"";
            $acao = (isset($parametros['acao']))?$parametros['acao']:"";
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
        //vem do upload e somente do upload
        if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
            include_once ("ImagemControle.php");
            $upload = new ImagemControle();
            exit();
        }
    }

    public function index() {
        //modelo
        
        //visao
        $visao = new Template();
        $visao ->exibir('index', 1);
    }

}
