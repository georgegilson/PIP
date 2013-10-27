<?php

class Template {

    private $item;

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function __construct($scripts) {
        $this->cabecalho($scripts);
    }

    public function exibir($visao, $paginaInicial = 0) {
        $this->corpo($visao, $paginaInicial);
    }

    public function cabecalho($scripts) {
        #tratar a inclusao automatica de scripts
        #verificar a variavel active do menu
        include_once 'cabecalho.html';
    }

    public function corpo($visao, $paginaInicial) {
        if ($paginaInicial === 1) {
            include_once 'index.html';
        } else {
            include_once 'visao/' . $visao;
        }
    }

    public function rodape() {
        include 'rodape.html';
    }

    public function __destruct() {
        $this->rodape();
    }

}
