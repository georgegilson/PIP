<?php

include_once 'configuracao/Conexao.php';

class GenericoDAO {

    public $conexao = null;

    public function __construct() {
        $this->conexao = Conexao::getInstance();
    }

    function iniciarTransacao() {
        $this->conexao->beginTransaction();
    }

    function commit() {
        $this->conexao->commit();
    }

    function rollback() {
        $this->conexao->rollBack();
    }

    function fecharConexao() {
        if ($this->conexao != null)
            $this->conexao = null;
    }

    function cadastrar($entidade) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $atributos = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        $sql = "INSERT INTO " . strtolower($classe) . " (";
        foreach ($atributos as $chave => $valor) {
            $sql = $sql . strtolower($valor->getName());
            if ($chave != (count($atributos) - 1))
                $sql = $sql . ", ";
        }
        $sql = $sql . ") VALUES (";
        foreach ($atributos as $chave => $valor) {
            $sql = $sql . ":" . strtolower($valor->getName());
            if ($chave != (count($atributos) - 1))
                $sql = $sql . ", ";
        }
        $sql = $sql . ")";
        $statement = $this->conexao->prepare($sql);
        foreach ($atributos as $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());
            $statement->bindValue($parametro, $resultado);
        }
        if ($statement->execute()) {
            if ($this->conexao->lastInsertId())
                return $this->conexao->lastInsertId();
            else
                return true;
        } else {
            return false;
        }
    }

    function listar($entidade) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe);
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        $blindado = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        if ($blindado) {
            $privados = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
            foreach ($privados as $listaPrivados) {
                $atributos[] = $listaPrivados->name;
            }
            foreach ($resultado as $objeto) {
                foreach ($blindado as $atributoBlindado) {
//                    echo "<pre>";
//                    print_r($atributos);
//                    die();
                    if (in_array("id" . $atributoBlindado->getName(), $atributos)) {
                        $entidadeBlindada = $atributoBlindado->getName();
                        $chaveEstrangeira = "id";
                        $acao = "getId" . $atributoBlindado->getName();
                        $idChaveEstrangeira = $objeto->$acao();
                    } else {
                        $entidadeBlindada = $atributoBlindado->getName();
                        $chaveEstrangeira = "id" . $classe;
                        $idChaveEstrangeira = $objeto->getId();
                    }
                    $acao = "set" . ucfirst($atributoBlindado->getName());
                    $objeto->$acao($this->selecionarBlindado($entidadeBlindada, $chaveEstrangeira, $idChaveEstrangeira));
                }
                $resultadoBlindado[] = $objeto;
//                echo "<pre>";
//                print_r($resultadoBlindado);
//                die();
            }
            return $resultadoBlindado;
        } else {
            return $resultado;
        }
    }

    function selecionarBlindado($entidadeBlindada, $chaveEstrangeira, $idChaveEstrangeira) {
//        var_dump($idChaveEstrangeira);

        $sql = "SELECT * FROM " . strtolower($entidadeBlindada) . " WHERE " . $chaveEstrangeira . " =:idChaveEstrangeira";
        $statement = $this->conexao->prepare($sql);
//        echo "<pre>";
//        print_r($sql);
//        die();
        $statement->bindParam(':idChaveEstrangeira', $idChaveEstrangeira);
        $statement->execute();
        $statement->rowCount();

        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $entidadeBlindada);

        if ($statement->rowCount() == 1) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }
    
    function selecionar2($entidade, $parametro){
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
         $sql = "SELECT * FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        $blindado = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        if ($blindado) {
            $privados = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
            foreach ($privados as $listaPrivados) {
                $atributos[] = $listaPrivados->name;
            }
            foreach ($resultado as $objeto) {
                foreach ($blindado as $atributoBlindado) {
//                    echo "<pre>";
//                    print_r($atributos);
//                    die();
                    if (in_array("id" . $atributoBlindado->getName(), $atributos)) {
                        $entidadeBlindada = $atributoBlindado->getName();
                        $chaveEstrangeira = "id";
                        $acao = "getId" . $atributoBlindado->getName();
                        $idChaveEstrangeira = $objeto->$acao();
                    } else {
                        $entidadeBlindada = $atributoBlindado->getName();
                        $chaveEstrangeira = "id" . $classe;
                        $idChaveEstrangeira = $objeto->getId();
                    }
                    $acao = "set" . ucfirst($atributoBlindado->getName());
                    $objeto->$acao($this->selecionarBlindado($entidadeBlindada, $chaveEstrangeira, $idChaveEstrangeira));
                }
                $resultadoBlindado[] = $objeto;
//                echo "<pre>";
//                print_r($resultadoBlindado);
//                die();
            }
            return $resultadoBlindado;
        } else {
            return $resultado;
        }
    }

    function selecionar($entidade, $parametro) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        return $resultado;
    }
    
    function selecionar3($entidade, $parametro) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe) . " WHERE login=:login";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':login', $parametro);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        return $resultado;
    }

    function editar($entidade) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $atributos = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        $sql = "UPDATE " . strtolower($classe) . " SET ";
        foreach ($atributos as $chave => $valor) {
            $sql = $sql . strtolower($valor->getName()) . " = :" . strtolower($valor->getName());
            if ($chave != (count($atributos) - 1))
                $sql = $sql . ", ";
        }
        $sql = $sql . " WHERE id = :id";

        $statement = $this->conexao->prepare($sql);
        foreach ($atributos as $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());
            $statement->bindValue($parametro, $resultado);
        }

        if ($statement->execute()) {
            return true;
        } else
            return false;
    }

    function excluir($entidade, $parametro) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "DELETE FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        if ($statement->execute()) {
            return true;
        } else
            return false;
    }

}
