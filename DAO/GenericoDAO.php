<?php

include_once 'configuracao/Conexao.php';

class GenericoDAO {

    function cadastrar($entidade) {

        $conexao = Conexao::getInstance();

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
        $statement = $conexao->prepare($sql);
        foreach ($atributos as $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());
            $statement->bindValue($parametro, $resultado);
        }
        if ($statement->execute()) {
            if ($conexao->lastInsertId())
                return $conexao->lastInsertId();
            else
                return true;
        } else {
            return false;
        }
    }

    function listar($entidade) {
        $conexao = Conexao::getInstance();
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe);
        $statement = $conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        $blindado = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        if ($blindado) {
            foreach ($resultado as $objeto) {
                foreach ($blindado as $atributoBlindado) {
                    $acao = "set" . ucfirst($atributoBlindado->getName());
                    $objeto->$acao($this->selecionarBlindado($objeto->getId(), $classe, ucfirst($atributoBlindado->getName())));
                }
                $resultadoBlindado[] = $objeto;
            }
            return $resultadoBlindado;
        } else {
            return $resultado;
        }
    }

    function selecionarBlindado($idChaveEstrangeira, $entidadeEstrangeira, $entidadeBlindada) {
        $conexao = Conexao::getInstance();
        $sql = "SELECT * FROM " . strtolower($entidadeBlindada) . " WHERE id" . ucfirst($entidadeEstrangeira) . " =:idChaveEstrangeira";
        $statement = $conexao->prepare($sql);
        $statement->bindParam(':idChaveEstrangeira', $idChaveEstrangeira);
        $statement->execute();
        $statement->rowCount();
        
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $entidadeBlindada);
        
        if($statement->rowCount() == 1){
            $resultado = $resultado[0];
        } 
        return $resultado;
    }

    function selecionar($entidade, $parametro) {
        $conexao = Conexao::getInstance();
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        return $resultado;
    }

    function editar($entidade) {
        $conexao = Conexao::getInstance();

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

        $statement = $conexao->prepare($sql);
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
        $conexao = Conexao::getInstance();
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "DELETE FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        if ($statement->execute()) {
            return true;
        } else
            return false;
    }

}
