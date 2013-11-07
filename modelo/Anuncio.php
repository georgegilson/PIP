<?php

class Anuncio {
     
    private $valor;
    private $topicoanuncio; 
    private $descricaoanuncio; 
    private $idimovel;
    private $status;
    private $destaque;
    private $valorvisivel;
    private $vigencia;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $idusuario;
    private $publicarmapa;
    
    public function getPublicarmapa() {
        return $this->publicarmapa;
    }

        public function getDestaque() {
        return $this->destaque;
    }

    public function getValorvisivel() {
        return $this->valorvisivel;
    }

    public function getVigencia() {
        return $this->vigencia;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setDestaque($destaque) {
        $this->destaque = $destaque;
    }

    public function setValorvisivel($valorvisivel) {
        $this->valorvisivel = $valorvisivel;
    }

    public function setVigencia($vigencia) {
        $this->vigencia = $vigencia;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

        public function getValor() {
        return $this->valor;
    }

    public function getTopicoAnuncio() {
        return $this->topicoanuncio;
    }

    public function getDescricaoAnuncio() {
        return $this->descricaoanuncio;
    }

    public function getIdImovel() {
        return $this->idimovel;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setTopicoAnuncio($topicoanuncio) {
        $this->topicoanuncio = $topicoanuncio;
    }

    public function setDescricaoAnuncio($descricaoanuncio) {
        $this->descricaoanuncio = $descricaoanuncio;
    }

    public function setIdImovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }
    
    public function setPublicarmapa($publicarmapa) {
        $this->publicarmapa = $publicarmapa;
    }

    function cadastrar($parametros) {

        $anuncio = new Anuncio();
        
        $anuncio->setValor($parametros['txtValor']);
        $anuncio->setTopicoAnuncio($parametros['txtTopico']);
        $anuncio->setDescricaoAnuncio($parametros['txtDescricao']);
        $anuncio->setDatahoracadastro($parametros['hdnDataCadastro']);
        $anuncio->setDatahoraalteracao($parametros['hdnDataAtualizacao']);
        $anuncio->setStatus('cadastrado');
        $anuncio->setIdImovel($parametros['hdnId']);
            
        return $anuncio;
    }

   
}
