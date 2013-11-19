<?php

class Empresa {

    private $id;
    private $responsavel;
    private $razaosocial;
    private $idusuario;

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getId() {
        return $this->id;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function getRazaosocial() {
        return $this->razaosocial;
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

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function cadastrar($parametros, $idUsuario) {
        $empresa = new Empresa();
        $empresa->setIdusuario($idUsuario);
        $empresa->setRazaosocial($parametros['txtRazaoSocial']);
        $empresa->setResponsavel($parametros['txtResponsavel']);
        return $empresa;
    }

}
