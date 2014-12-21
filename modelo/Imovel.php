<?php

class Imovel {

    private $id;
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
    private $idendereco;
    private $condominio;
    private $areaservico;
    private $dependenciaempregada;
    private $elevador;
    private $andar;
    private $cobertura;
    private $sacada;
    private $descricao;
    private $condicao;
    protected $endereco;
    protected $anuncio;
    protected $usuario;

    public function getIdendereco() {
        return $this->idendereco;
    }

    public function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

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

    public function getQuarto() {
        return $this->quarto;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
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

    public function getEndereco() {
        return $this->endereco;
    }

    public function getAnuncio() {
        return $this->anuncio;
    }
    
    function getUsuario() {
        return $this->usuario;
    }
  
    public function getCondicao() {
        return $this->condicao;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setAnuncio($anuncio) {
        $this->anuncio = $anuncio;
    }
    
    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCondicao($condicao) {
        $this->condicao = $condicao;
    }

    public function Referencia() {
        return substr($this->getDatahoracadastro(), 6, -9) . substr($this->getDatahoracadastro(), 3, -14) . str_pad($this->getId(), 5, "0", STR_PAD_LEFT);
    }

    function cadastrar($parametros, $idendereco) {

        $imovel = new Imovel();

        $imovel->setIdendereco($idendereco);
        $imovel->setCondicao($parametros['sltCondicao']);
        $imovel->setTipo($parametros['sltTipo']);
        $imovel->setQuarto($parametros['sltQuarto']);
        $imovel->setGaragem($parametros['sltGaragem']);
        $imovel->setBanheiro($parametros['sltBanheiro']);
        $imovel->setDatahoracadastro(date('d/m/Y H:i:s'));
        $imovel->setDatahoraalteracao("");
        $imovel->setCondicao("novo");

        if (isset($parametros['sltDiferencial'])) {
            $imovel->setAcademia((in_array("Academia", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setAreaServico((in_array("AreaServico", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setDependenciaEmpregada((in_array("DependenciaEmpregada", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setElevador((in_array("Elevador", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setPiscina((in_array("Piscina", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setQuadra((in_array("Quadra", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
        } else {
            $imovel->setAcademia("NAO");
            $imovel->setAreaServico("NAO");
            $imovel->setDependenciaEmpregada("NAO");
            $imovel->setElevador("NAO");
            $imovel->setPiscina("NAO");
            $imovel->setQuadra("NAO");
        }

        $imovel->setArea($parametros['txtArea']);
        $imovel->setSuite($parametros['sltSuite']);
        $imovel->setDescricao($parametros['txtDescricao']);

        $imovel->setIdusuario($_SESSION["idusuario"]);

        if ($parametros['sltTipo'] != "apartamento") {
            $imovel->setAndar(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setCobertura(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setSacada(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setCondominio(""); //não se aplica, pois é uma casa ou terreno
        } else {
            if (isset($parametros["sltAndar"])) {
                $imovel->setAndar($parametros['sltAndar']);
            } elseif ($parametros['sltAndar'] == "") {
                $imovel->setAndar("NAO"); /* usuário não informou o andar do prédio */
            }

            if (isset($parametros["chkCobertura"])) {
                $imovel->setCobertura($parametros['chkCobertura'] = 'SIM');
            } elseif (!isset($parametros['chkCobertura'])) {
                $imovel->setCobertura("NAO"); /* usuário não informou se é na cobertura */
            }

            if (isset($parametros["chkSacada"])) {
                $imovel->setSacada($parametros['chkSacada'] = 'SIM');
            } elseif (!isset($parametros['chkSacada'])) {
                $imovel->setSacada("NAO"); /* usuário não informou se possui sacada */
            }

            if (isset($parametros["txtCondominio"])) {
                $imovel->setCondominio($this->limpaValorNumerico($parametros['txtCondominio']));
            } elseif ($parametros['txtCondominio'] == "") {
                $imovel->setCondominio("NAO"); /* usuário não informou o valor do condominio */
            }
        }

        return $imovel;
    }

    function editar($parametros) {

        $imovel = new Imovel();
        $imovel->setIdendereco($_SESSION["imovel"]["idendereco"]);
        $imovel->setId($_SESSION["imovel"]["id"]);
        $imovel->setCondicao($parametros['sltCondicao']);
        $imovel->setTipo($parametros['sltTipo']);
        $imovel->setQuarto($parametros['sltQuarto']);
        $imovel->setGaragem($parametros['sltGaragem']);
        $imovel->setBanheiro($parametros['sltBanheiro']);
        $imovel->setDatahoraalteracao(date('d/m/Y H:i:s'));

        if (isset($parametros['sltDiferencial'])) {
            $imovel->setAcademia((in_array("Academia", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setAreaServico((in_array("AreaServico", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setDependenciaEmpregada((in_array("DependenciaEmpregada", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setElevador((in_array("Elevador", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setPiscina((in_array("Piscina", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
            $imovel->setQuadra((in_array("Quadra", $parametros['sltDiferencial']) ? "SIM" : "NAO"));
        } else {
            $imovel->setAcademia("NAO");
            $imovel->setAreaServico("NAO");
            $imovel->setDependenciaEmpregada("NAO");
            $imovel->setElevador("NAO");
            $imovel->setPiscina("NAO");
            $imovel->setQuadra("NAO");
        }

        $imovel->setArea($parametros['txtArea']);
        $imovel->setSuite($parametros['sltSuite']);
        $imovel->setDescricao($parametros['txtDescricao']);

        $imovel->setIdusuario($_SESSION["idusuario"]);

        if ($parametros['sltTipo'] != "apartamento") {
            $imovel->setAndar(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setCobertura(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setSacada(""); //não se aplica, pois é uma casa ou terreno
            $imovel->setCondominio(""); //não se aplica, pois é uma casa ou terreno
        } else {
            if (isset($parametros["sltAndar"])) {
                $imovel->setAndar($parametros['sltAndar']);
            } elseif ($parametros['sltAndar'] == "") {
                $imovel->setAndar("NAO"); /* usuário não informou o andar do prédio */
            }

            if (isset($parametros["chkCobertura"])) {
                $imovel->setCobertura($parametros['chkCobertura'] = 'SIM');
            } elseif (!isset($parametros['chkCobertura'])) {
                $imovel->setCobertura("NAO"); /* usuário não informou se é na cobertura */
            }

            if (isset($parametros["chkSacada"])) {
                $imovel->setSacada($parametros['chkSacada'] = 'SIM');
            } elseif (!isset($parametros['chkSacada'])) {
                $imovel->setSacada("NAO"); /* usuário não informou se possui sacada */
            }

            if (isset($parametros["txtCondominio"])) {
                $imovel->setCondominio($this->limpaValorNumerico($parametros['txtCondominio']));
            } elseif ($parametros['txtCondominio'] == "") {
                $imovel->setCondominio("NAO"); /* usuário não informou o valor do condominio */
            }
        }
        return $imovel;
    }

    function limpaValorNumerico($valor) {
        $valor = str_replace("R$", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = trim($valor);
        return $valor;
    }

}

