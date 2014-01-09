<?php

class Anuncio {

    private $id;
    private $idimovel;
    private $valor;
    private $tituloanuncio;
    private $descricaoanuncio;
    private $status;
    //private $destaque;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $valorvisivel;
    private $publicarmapa;
    private $idusuarioplano;
    protected $imovel;
    protected $imagem;

    public function getImovel() {
        return $this->imovel;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getId() {
        return $this->id;
    }

    public function getPublicarmapa() {
        return $this->publicarmapa;
    }

    public function getDestaque() {
        return $this->destaque;
    }

    public function getValorvisivel() {
        return $this->valorvisivel;
    }

    public function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDestaque($destaque) {
        $this->destaque = $destaque;
    }

    public function setValorvisivel($valorvisivel) {
        $this->valorvisivel = $valorvisivel;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getTituloAnuncio() {
        return $this->tituloanuncio;
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

    public function setTituloAnuncio($tituloanuncio) {
        $this->tituloanuncio = $tituloanuncio;
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

    public function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    function cadastrar($parametros) {

        $anuncio = new Anuncio();

        $anuncio->setTituloAnuncio($parametros['txtTitulo']);
        $anuncio->setDescricaoAnuncio($parametros['txtDescricao']);
        $anuncio->setValor($parametros['txtValor']);
        $anuncio->setValorVisivel((isset($parametros['sltCamposVisiveis']) ? json_encode($parametros['sltCamposVisiveis']) : ""));
        $anuncio->setDatahoracadastro(date('d/m/Y H:i:s'));
        $anuncio->setDatahoraalteracao("");
        $anuncio->setStatus('cadastrado');
        $anuncio->setPublicarmapa($parametros['rdbMapa']);
        $anuncio->setIdImovel($parametros['hdnIdImovel']);
        $anuncio->setIdusuarioplano($parametros['sltPlano']);

        return $anuncio;
    }

}
