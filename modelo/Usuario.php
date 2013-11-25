<?php

class Usuario {

    private $id;
    private $tipousuario;
    private $nome;
    private $cpfcnpj;
    private $login;
    private $senha;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $email;
    private $idendereco;

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

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

    public function getStatus() {
        return $this->status;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function getIdendereco() {
        return $this->idendereco;
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

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    function cadastrar($parametros, $idendereco) {
        $usuario = new Usuario();
        $usuario->setTipousuario($parametros['sltTipoUsuario']);
        $usuario->setNome($parametros['txtNome']);
        $usuario->setLogin($parametros['txtLogin']);
        $usuario->setSenha($parametros['txtSenha']);
        if ($usuario->getTipousuario() == "fisica") {
            $usuario->setCpfcnpj($parametros['txtCpf']);
        } else {
            $usuario->setCpfcnpj($parametros['txtCnpj']);
        }
        $usuario->setEmail($parametros['txtEmail']);
        $usuario->setStatus("A");
        $usuario->setDatahoracadastro(date('d/m/Y H:i:s'));
        $usuario->setDatahoraalteracao("");
        $usuario->setIdendereco($idendereco);
        return $usuario;
    }

}
