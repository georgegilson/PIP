<?php

class Anuncio {

    private $id;
    private $finalidade;
    private $idimovel;
    private $valor;
    private $tituloanuncio;
    private $descricaoanuncio;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $valorvisivel;
    private $publicarmapa;
    private $publicarcontato;
    private $idusuarioplano;
    protected $imovel;
    protected $imagem;
    protected $historicoAluguelVenda;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    public function getIdimovel() {
        return $this->idimovel;
    }

    public function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getTituloanuncio() {
        return $this->tituloanuncio;
    }

    public function setTituloanuncio($tituloanuncio) {
        $this->tituloanuncio = $tituloanuncio;
    }

    public function getDescricaoanuncio() {
        return $this->descricaoanuncio;
    }

    public function setDescricaoanuncio($descricaoanuncio) {
        $this->descricaoanuncio = $descricaoanuncio;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function getValorvisivel() {
        return $this->valorvisivel;
    }

    public function setValorvisivel($valorvisivel) {
        $this->valorvisivel = $valorvisivel;
    }

    public function getPublicarmapa() {
        return $this->publicarmapa;
    }

    public function setPublicarmapa($publicarmapa) {
        $this->publicarmapa = $publicarmapa;
    }

    public function getPublicarcontato() {
        return $this->publicarcontato;
    }

    public function setPublicarcontato($publicarcontato) {
        $this->publicarcontato = $publicarcontato;
    }

    public function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    public function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    public function getImovel() {
        return $this->imovel;
    }

    public function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getHistoricoAluguelVenda() {
        return $this->historicoAluguelVenda;
    }

    public function setHistoricoAluguelVenda($historicoAluguelVenda) {
        $this->historicoAluguelVenda = $historicoAluguelVenda;
    }

    function cadastrar($parametros) {
        $anuncio = new Anuncio();
        $anuncio->setFinalidade($parametros['sltFinalidade']);
        $anuncio->setTituloAnuncio($parametros['txtTitulo']);
        $anuncio->setDescricaoAnuncio($parametros['txtDescricao']);
        $anuncio->setValor($this->limpaValorNumerico($parametros['txtValor']));
        $anuncio->setValorVisivel((isset($parametros['sltCamposVisiveis']) ? json_encode($parametros['sltCamposVisiveis']) : ""));
        $anuncio->setDatahoracadastro(date('d/m/Y H:i:s'));
        $anuncio->setDatahoraalteracao("");
        $anuncio->setStatus('cadastrado');
        $anuncio->setPublicarmapa((isset($parametros['chkMapa']) ? "SIM" : "NAO"));
        $anuncio->setPublicarcontato((isset($parametros['chkContato']) ? "SIM" : "NAO"));
        $anuncio->setIdImovel($_SESSION["anuncio"]["idimovel"]);
        $anuncio->setIdusuarioplano($parametros['sltPlano']);
        return $anuncio;
    }

    function limpaValorNumerico($valor) {
        $valor = str_replace("R$", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = trim($valor);
        return $valor;
    }

    function buscarDestaqueImagemMiniatura() {
        $imagens = $this->getImagem();
        if (is_array($imagens)) {
            foreach ($imagens as $imagem) {
                if($imagem->getDestaque() == "SIM"){
                    $miniatura = $imagem->miniatura();
                }
            }
        } else {
            $miniatura = $imagens->miniatura();
        }
        return $miniatura;
    }

}
