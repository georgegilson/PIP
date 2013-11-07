<?php

class Imovel {

    private $id;
    private $finalidade;
    private $quarto;
    private $tipo;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $garagem;
    private $banheiro;
    private $piscina;
    private $quadra;
    private $academia;
    private $idusuario;
    private $suite;
    private $area;
 //   private $endereco;
    private $condominio; 
    private $areaservico;
    private $dependenciaempregada;
    private $elevador; 
    private $andar;
    private $cobertura;
    private $sacada;
    private $descricao;
    
    public function getDescricao() {
        return $this->descricao;
    }

        public function getIdusuario() {
        return $this->idusuario;
    }

    public function getCondominio() {
        return $this->condominio;
    }

    public function getAndar() {
        return $this->andar;
    }

    public function getCobertura() {
        return $this->cobertura;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setCondominio($condominio) {
        $this->condominio = $condominio;
    }

    public function setAndar($andar) {
        $this->andar = $andar;
    }

    public function setCobertura($cobertura) {
        $this->cobertura = $cobertura;
    }

        public function getId() {
        return $this->id;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function getQuarto() {
        return $this->quarto;
    }
    
    public function getTipo() {
        return $this->tipo;
    }
    
    public  function getDatahoracadastro() {
      return $this->datahoracadastro;
    }

    public  function getDatahoraalteracao() {
      return $this->datahoraalteracao;
    }
    
    public function getGaragem() {
        return $this->garagem;
    }

    public function getBanheiro() {
        return $this->banheiro;
    }

    public function getPiscina() {
        return $this->piscina;
    }
    
    public function getQuadra() {
        return $this->quadra;
    }
    public function getAcademia() {
        return $this->academia;
    }
    
      public function getSuite() {
      return $this->suite;
      }

      public function getArea() {
      return $this->area;
      }
      
      public function getAreaServico() {
          return $this->areaservico;
      }

      public function getDependenciaEmpregada() {
          return $this->dependenciaempregada;
      }

      public function getElevador() {
          return $this->elevador;
      }

      public function getSacada() {
          return $this->sacada;
      }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    public function setQuarto($quarto) {
        $this->quarto = $quarto;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function setGaragem($garagem) {
        $this->garagem = $garagem;
    }

    public function setBanheiro($banheiro) {
        $this->banheiro = $banheiro;
    }

    public function setPiscina($piscina) {
        $this->piscina = $piscina;
    }

    public function setQuadra($quadra) {
        $this->quadra = $quadra;
    }
    public function setAcademia($academia) {
        $this->academia = $academia;
    }
            
    public function setSuite($suite) {
        $this->suite = $suite;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setAreaServico($areaservico) {
        $this->areaservico = $areaservico;
    }

    public function setDependenciaEmpregada($dependenciaempregada) {
        $this->dependenciaempregada = $dependenciaempregada;
    }

    public function setElevador($elevador) {
        $this->elevador = $elevador;
    }

    public function setSacada($sacada) {
        $this->sacada = $sacada;
    }
    
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    function cadastrar($parametros) {

        $imovel = new Imovel();

        $imovel->setFinalidade($parametros['sltFinalidade']);
        $imovel->setQuarto($parametros['sltQuarto']);
        $imovel->setTipo($parametros['sltTipo']);
        $imovel->setDatahoracadastro($parametros['hdnDataCadastro']);
        $imovel->setDatahoraalteracao($parametros['hdnDataAtualizacao']);
        $imovel->setGaragem($parametros['sltGaragem']);
        $imovel->setBanheiro($parametros['sltBanheiro']);
        
        if(isset($parametros['chkPiscina'])){
        $imovel->setPiscina($parametros['chkPiscina']);}
            else $imovel->setPiscina($parametros['chkPiscina'] = "NAO");
        
        
        if(isset($parametros['chkQuadra'])){
        $imovel->setQuadra($parametros['chkQuadra']);}
            else $imovel->setQuadra($parametros['chkQuadra'] = "NAO");

        if(isset($parametros['chkAcademia'])){
        $imovel->setAcademia($parametros['chkAcademia']);}
            else $imovel->setAcademia($parametros['chkAcademia'] = "NAO");   
        
        if(isset($parametros['chkAreaServico'])){
        $imovel->setAreaServico($parametros['chkAreaServico']);}
            else $imovel->setAreaServico($parametros['chkAreaServico'] = "NAO");   
        
        if(isset($parametros['chkDependenciaEmpregada'])){
        $imovel->setDependenciaEmpregada($parametros['chkDependenciaEmpregada']);}
            else $imovel->setDependenciaEmpregada($parametros['chkDependenciaEmpregada'] = "NAO");              
        
        if(isset($parametros['chkElevador'])){
        $imovel->setElevador($parametros['chkElevador']);}
            else $imovel->setElevador($parametros['chkElevador'] = "NAO");   
            
        if(isset($parametros['chkSacada'])){
        $imovel->setSacada($parametros['chkSacada']);}
            else $imovel->setSacada($parametros['chkSacada'] = "NAO"); 
            
        $imovel->setArea($parametros['txtArea']);
        $imovel->setSuite($parametros['sltSuite']);
            
        return $imovel;
    }
    
        function editar($parametros) {

        $imovel = new Imovel();

        $imovel->setId($parametros['hdnId']);
        $imovel->setFinalidade($parametros['sltFinalidade']);
        $imovel->setQuarto($parametros['sltQuarto']);
        $imovel->setTipo($parametros['sltTipo']);
        $imovel->setDatahoracadastro($parametros['hdnDataCadastro']);
        $imovel->setDatahoraalteracao($parametros['hdnDataAtualizacao']);
        $imovel->setGaragem($parametros['sltGaragem']);
        $imovel->setBanheiro($parametros['sltBanheiro']);
        
        if(isset($parametros['chkPiscina'])){
        $imovel->setPiscina($parametros['chkPiscina']);}
            else $imovel->setPiscina($parametros['chkPiscina'] = "NAO");
        
        
        if(isset($parametros['chkQuadra'])){
        $imovel->setQuadra($parametros['chkQuadra']);}
            else $imovel->setQuadra($parametros['chkQuadra'] = "NAO");

        if(isset($parametros['chkAcademia'])){
        $imovel->setAcademia($parametros['chkAcademia']);}
            else $imovel->setAcademia($parametros['chkAcademia'] = "NAO");   
        
        if(isset($parametros['chkAreaServico'])){
        $imovel->setAreaServico($parametros['chkAreaServico']);}
            else $imovel->setAreaServico($parametros['chkAreaServico'] = "NAO");   
        
        if(isset($parametros['chkDependenciaEmpregada'])){
        $imovel->setDependenciaEmpregada($parametros['chkDependenciaEmpregada']);}
            else $imovel->setDependenciaEmpregada($parametros['chkDependenciaEmpregada'] = "NAO");              
        
        if(isset($parametros['chkElevador'])){
        $imovel->setElevador($parametros['chkElevador']);}
            else $imovel->setElevador($parametros['chkElevador'] = "NAO");   
            
        if(isset($parametros['chkSacada'])){
        $imovel->setSacada($parametros['chkSacada']);}
            else $imovel->setSacada($parametros['chkSacada'] = "NAO"); 
            
        $imovel->setArea($parametros['txtArea']);
        $imovel->setSuite($parametros['sltSuite']);
            
        return $imovel;
        
        return $imovel;
    }
}


