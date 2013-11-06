<?php

class Usuario {
    
    private $id;
    private $tipousuario;
    private $nome;
    private $cpfcnpj;
    private $login;
    private $senha;
    private $idtelefone;
    private $idendereco;
    private $ativo;
    private $datahoracadastro;
    private $datahoraalteracao;
    
    public function getId() {
        return $this->id;
    }

    public function getTipousuario() {
        return $this->tipousuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpfcnpj() {
        return $this->cpfcnpj;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getIdtelefone() {
        return $this->idtelefone;
    }

    public function getIdendereco() {
        return $this->idendereco;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipousuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCpfcnpj($cpfcnpj) {
        $this->cpfcnpj = $cpfcnpj;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setIdtelefone($idtelefone) {
        $this->idtelefone = $idtelefone;
    }

    public function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }


}
