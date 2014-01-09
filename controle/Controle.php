<?php

class Controle {

    public function __construct($parametros) {
        //vem do menu
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $entidade = (isset($parametros['entidade']))?$parametros['entidade']:"";
            $acao = (isset($parametros['acao']))?$parametros['acao']:"";
            if ($entidade == "" && $acao == "") {
                self::index();
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

    public static function index() {
        //modelo
        include_once 'DAO/GenericoDAO.php';
        include_once 'modelo/Anuncio.php';
        include_once 'modelo/Imovel.php';
        include_once 'modelo/Imagem.php';
        $genericoDAO = new GenericoDAO();
        $anuncios = $genericoDAO->consultar(new Anuncio(),true,array("status"=>"cadastrado"));
        $item['anuncios'] = $anuncios;

        //visao
        $visao = new Template();
        $visao->setItem($item);
        $visao->exibir('index', 1);
    }

}
