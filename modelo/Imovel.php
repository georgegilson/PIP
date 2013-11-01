<?php

class Imovel {

    private $id;
    private $finalidade;
    private $quarto;
    private $tipo;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $idusuario;
    private $idendereco;

 /*   private $suite;
      private $area;
      private $garagem;
      private $banheiro;
      private $endereco;
      private $piscina;
      private $academia;
      private $quadra;
      private $condominio; 
      private $areaServico;
      private $dependenciaEmpregada;
      private $elevador;
      private $andar;
      private $cobertura;
      private $sacada;        */

    public function getId() {
        return $this->id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function getQuarto() {
        return $this->quarto;
    }

/*

      public function getSuite() {
      return $this->suite;
      }

      public function getArea() {
      return $this->area;
      }

      public function getGaragem() {
      return $this->garagem;
      }

      public function getBanheiro() {
      return $this->banheiro;
      }

      public function getTopicoImovel() {
      return $this->topicoImovel;
      }

      public function getDescricaoImovel() {
      return $this->descricaoImovel;
      }

      public function getEndereco() {
      return $this->endereco;
      }

      public function getBuscaAvancada() {
      return $this->buscaAvancada;
      }

      public function getImagem() {
      return $this->imagem;
      }
     */

    public function setId($id) {
        $this->id = $id;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    public function setQuarto($quarto) {
        $this->quarto = $quarto;
    }

    /*
      public function setSuite($suite) {
      $this->suite = $suite;
      }

      public function setArea($area) {
      $this->area = $area;
      }

      public function setGaragem($garagem) {
      $this->garagem = $garagem;
      }

      public function setBanheiro($banheiro) {
      $this->banheiro = $banheiro;
      }

      public function setTopicoImovel($topicoImovel) {
      $this->topicoImovel = $topicoImovel;
      }

      public function setDescricaoImovel($descricaoImovel) {
      $this->descricaoImovel = $descricaoImovel;
      }

      public function setEndereco($endereco) {
      $this->endereco = $endereco;
      }

      public function setBuscaAvancada($buscaAvancada) {
      $this->buscaAvancada = $buscaAvancada;
      }

      public function setImagem($imagem) {
      $this->imagem = $imagem;
      } */

    function cadastrar($parametros) {

        $imovel = new Imovel();

        $imovel->setValor($parametros['txtValor']);
        $imovel->setFinalidade($parametros['sltFinalidade']);
        $imovel->setQuarto($parametros['sltQuarto']);

        return $imovel;
    }
    
        function editar($parametros) {

        $imovel = new Imovel();

        $imovel->setId($parametros['hdnId']);
        $imovel->setValor($parametros['txtValor']);
        $imovel->setFinalidade($parametros['sltFinalidade']);
        $imovel->setQuarto($parametros['sltQuarto']);

        return $imovel;
    }
}


