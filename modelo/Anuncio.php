<?php

class Anuncio {
     
    private $valor;
    private $topicoImovel; 
    private $descricaoImovel; 
    private $imagem; 
    private $idImovel;
    private $status;
    private $destaque;
    private $campos;
    private $vigencia;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $idusuario;
    
    public function getValor() {
        return $this->valor;
    }

    public function getTopicoImovel() {
        return $this->topicoImovel;
    }

    public function getDescricaoImovel() {
        return $this->descricaoImovel;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDestaque() {
        return $this->destaque;
    }

    public function getCampos() {
        return $this->campos;
    }

    public function getVigencia() {
        return $this->vigencia;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setTopicoImovel($topicoImovel) {
        $this->topicoImovel = $topicoImovel;
    }

    public function setDescricaoImovel($descricaoImovel) {
        $this->descricaoImovel = $descricaoImovel;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDestaque($destaque) {
        $this->destaque = $destaque;
    }

    public function setCampos($campos) {
        $this->campos = $campos;
    }

    public function setVigencia($vigencia) {
        $this->vigencia = $vigencia;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }


   
}
