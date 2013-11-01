<?php

class Empresa {
    
    private $id;
    private $responsavel;
    private $razaosocial;
    private $datahoracadastro;
    private $datahoraalteracao;
    
    public function getId() {
        return $this->id;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function getRazaosocial() {
        return $this->razaosocial;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function setRazaosocial($razaosocial) {
        $this->razaosocial = $razaosocial;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }
    
}
