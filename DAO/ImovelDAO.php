<?php

include_once '../configuracao/Conexao.php';

class ImovelDAO {
    
    function cadastrar($entidadeImovel){
        
       $conexao = Conexao::getInstance();
        
       $statement = $conexao->prepare('INSERT INTO imovel (valor, finalidade, quarto) VALUES (:valor, :finalidade, :quarto)');
       
       $statement->bindParam(':valor', $entidadeImovel->getValor()); 
       $statement->bindParam(':finalidade', $entidadeImovel->getFinalidade());
       $statement->bindParam(':quarto', $entidadeImovel->getQuarto());
       
       if($statement->execute()){
       
           return true;
       
       }else{ 
           
           return false;
           
      } 
       
    }
    
}
