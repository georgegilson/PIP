<?php

include_once 'configuracao/Conexao.php';

class GenericoDAO {

    function cadastrar($entidade) {

        $conexao = Conexao::getInstance();

        $reflect = new ReflectionClass($entidade);
	$classe = $reflect->getName();
	$atributos  = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
       
	$sql = "INSERT INTO " . strtolower($classe) . " (";
        foreach( $atributos as $chave => $valor )
        {
	    $sql = $sql . strtolower($valor->getName());
            if($chave != (count($atributos)-1)) $sql = $sql . ", ";	
        }
        $sql = $sql . ") VALUES (";
        foreach( $atributos as $chave => $valor )
        {
            $sql = $sql . ":" . strtolower($valor->getName());
            if($chave != (count($atributos)-1)) $sql = $sql . ", ";
        }
        $sql = $sql . ")";
        $statement = $conexao->prepare($sql);
	foreach( $atributos as $valor )
        {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());	
            $statement->bindValue($parametro, $resultado);
        }

        if ($statement->execute()) {
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
	$atributos  = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
       
	$sql = "UPDATE " . strtolower($classe) . " SET ";
        foreach( $atributos as $chave => $valor )
        {
	    $sql = $sql . strtolower($valor->getName()) . " = :" . strtolower($valor->getName());
            if($chave != (count($atributos)-1)) $sql = $sql . ", ";	
        }
        $sql = $sql . " WHERE id = :id";
        
        $statement = $conexao->prepare($sql);
	foreach( $atributos as $valor )
        {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());	
            $statement->bindValue($parametro, $resultado);
        }
        
       /* $statement = $conexao->prepare('UPDATE imovel SET valor = :valor, finalidade = :finalidade, quarto = :quarto WHERE id = :id');
        $id = $entidadeImovel->getId();
        $valor = $entidadeImovel->getValor();
        $finalidade = $entidadeImovel->getFinalidade();
        $quarto = $entidadeImovel->getQuarto();

        $statement->bindParam(':id', $id);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':finalidade', $sql);
        $statement->bindParam(':quarto', $quarto);*/

        if ($statement->execute()) {
            return true;
        }
        else
            return false;
    }

}


