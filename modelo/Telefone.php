<?php

class Telefone {

    private $id;
    private $telefonefixo;
    private $telefonecomercial;
    private $ramal;
    private $claro;
    private $oi;
    private $tim;
    private $vivo;
    
    public function getId() {
        return $this->id;
    }

    public function getTelefonefixo() {
        return $this->telefonefixo;
    }

    public function getTelefonecomercial() {
        return $this->telefonecomercial;
    }

    public function getRamal() {
        return $this->ramal;
    }

    public function getClaro() {
        return $this->claro;
    }

    public function getOi() {
        return $this->oi;
    }

    public function getTim() {
        return $this->tim;
    }

    public function getVivo() {
        return $this->vivo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTelefonefixo($telefonefixo) {
        $this->telefonefixo = $telefonefixo;
    }

    public function setTelefonecomercial($telefonecomercial) {
        $this->telefonecomercial = $telefonecomercial;
    }

    public function setRamal($ramal) {
        $this->ramal = $ramal;
    }

    public function setClaro($claro) {
        $this->claro = $claro;
    }

    public function setOi($oi) {
        $this->oi = $oi;
    }

    public function setTim($tim) {
        $this->tim = $tim;
    }

    public function setVivo($vivo) {
        $this->vivo = $vivo;
    }
}
