<?php

class Endereco {
    
    private $id;
    private $cep;
    private $estado;
    private $cidade;
    private $bairro;
    private $logradouro;
    private $numero;
    private $complemento;

    public function getId() {
        return $this->id;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCep($cep) {
        $this->cep = str_replace("-", "", str_replace(".", "", $cep));
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function cadastrar($parametros){
        
        $endereco = new Endereco();
        $endereco->setCep($parametros['txtCEP']);
        $endereco->setEstado($parametros['txtEstado']);
        $endereco->setCidade($parametros['txtCidade']);
        $endereco->setBairro($parametros['txtBairro']);
        $endereco->setLogradouro($parametros['txtLogradouro']);
        $endereco->setNumero($parametros['txtNumero']);
        $endereco->setComplemento($parametros['txtComplemento']);
        return $endereco;
    }
    
}
