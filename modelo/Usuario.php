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
    private $foto;
    protected $endereco;
    protected $telefone;
    protected $empresa;

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

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
    
    public function getFoto() {
        return $this->foto;
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

    public function setFoto($foto) {
        $this->foto = $foto;
    }
   
    function cadastrar($parametros, $idendereco) {
        $usuario = new Usuario();
        $usuario->setTipousuario($parametros['sltTipoUsuario']);
        $usuario->setNome($parametros['txtNome']);
        $usuario->setLogin($parametros['txtLogin']);
        $timeTarget = 0.2;
        $cost = 9;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);
        $options = [
            'cost' => $cost,
        ];
        $usuario->setSenha(password_hash($parametros['txtSenha'], PASSWORD_BCRYPT, $options));

        if ($usuario->getTipousuario() == "pf") {
            $usuario->setCpfcnpj($parametros['txtCpf']);
        } else {
            $usuario->setCpfcnpj($parametros['txtCnpj']);
        }
        $usuario->setEmail($parametros['txtEmail']);
        $usuario->setStatus("ativo");
        $usuario->setDatahoracadastro(date('d/m/Y H:i:s'));
        $usuario->setDatahoraalteracao("");
        $usuario->setIdendereco($idendereco);

        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        //echo "Passo 1 <br>";
        var_dump($arquivo_tmp) . " Passo 1 <br>";
        $nome = $_FILES['arquivo']['name'];
        //echo "Passo 2 <br>";
        var_dump($_FILES);
        $extensao = strrchr($nome, '.');
        //echo "Passo 3 <br>";
        $extensao = strtolower($extensao);
        //echo "Passo 4 <br>";
        $novoNome = md5(microtime()) . $extensao;
        //echo "Passo 5 <br>";
        $destino = PIPROOT . '/modelo/fotos/' . $novoNome;
        //echo "Passo 6 <br>";
        //echo $destino."<br>";
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino . $_FILES['arquivo']['name'])) {
            //echo "Arquivo Criado <br>";} else echo "Erro";
            $usuario->setFoto($novoNome);
            //die();
            return $usuario;
        }
    }

    function editar($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idusuario"]);
        $usuario->setNome($parametros['txtNome']);
        $usuario->setEmail($parametros['txtEmail']);
        $usuario->setDatahoraalteracao(date('d/m/Y H:i:s'));
        return $usuario;
    }

    function alterarSenha($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idRecuperaSenhaUsuario"]);
        $senha = md5($parametros['txtSenha']);
        $usuario->setSenha($senha);
        return $usuario;
    }

    function trocarSenha($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idusuario"]);
        $senha = md5($parametros['txtSenhaNova']);
        $usuario->setSenha($senha);
        return $usuario;
    }

}