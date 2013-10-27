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
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "ImovelModelo");
        return $resultado;
        //
    }

    private function populaImovel($linha) {
        $pojo = new ImovelModelo;
        $pojo->setId($linha['id']);
        $pojo->setValor($linha['valor']);
        $pojo->setFinalidade($linha['finalidade']);
        $pojo->setQuarto($linha['quarto']);
        return $pojo;
    }

}
