<?php

include_once 'configuracao/Conexao.php';

class ImovelDAO {

    function cadastrar($entidadeImovel) {

        $conexao = Conexao::getInstance();

        $statement = $conexao->prepare('INSERT INTO imovel (valor, finalidade, quarto) VALUES (:valor, :finalidade, :quarto)');

        $valor = $entidadeImovel->getValor();
        $finalidade = $entidadeImovel->getFinalidade();
        $quarto = $entidadeImovel->getQuarto();

        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':finalidade', $finalidade);
        $statement->bindParam(':quarto', $quarto);

        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function listar() {
        $conexao = Conexao::getInstance();
        $statement = $conexao->prepare('SELECT * FROM imovel');
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "Imovel");
        return $resultado;
        //
    }

    function selecionar($entidadeImovel) {
        $conexao = Conexao::getInstance();
        $statement = $conexao->prepare('SELECT * FROM imovel WHERE id=:id');
        $id = $entidadeImovel;
        $statement->bindParam(':id', $id);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "Imovel");
        return $resultado;
    }

    function editar($entidadeImovel) {
        $conexao = Conexao::getInstance();
        $statement = $conexao->prepare('UPDATE imovel SET valor = :valor, finalidade = :finalidade, quarto = :quarto WHERE id = :id');
        $id = $entidadeImovel->getId();
        $valor = $entidadeImovel->getValor();
        $finalidade = $entidadeImovel->getFinalidade();
        $quarto = $entidadeImovel->getQuarto();

        $statement->bindParam(':id', $id);
        $statement->bindParam(':valor', $valor);
        $statement->bindParam(':finalidade', $finalidade);
        $statement->bindParam(':quarto', $quarto);

        if ($statement->execute()) {
            return true;
        }
        else
            return false;
    }

}
