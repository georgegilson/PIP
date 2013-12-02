<?php

class UsuarioPlano {
    
    private $id;
    private $idplano;
    private $status;
    private $datacompra;
    private $idusuario;
 
    public function getId() {
        return $this->id;
    }

    public function getIdplano() {
        return $this->idplano;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDatacompra() {
        return $this->datacompra;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdplano($idplano) {
        $this->idplano = $idplano;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDatacompra($datacompra) {
        $this->datacompra = $datacompra;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

}
