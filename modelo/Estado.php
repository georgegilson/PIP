<?php

class Estado {

    private $id;
    private $uf;
    private $nome;

    public function getId() {
        return $this->id;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

}
