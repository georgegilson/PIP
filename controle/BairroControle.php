<?php

include_once 'modelo/Bairro.php';
include_once 'modelo/Cidade.php';
include_once 'DAO/GenericoDAO.php';

class BairroControle {
   
    function selecionarBairro($parametros){
        
       $bairro = new Bairro();
        
       $genericoDAO = new GenericoDAO();
        
       $listarBairros = $genericoDAO->consultar($bairro, true, array("idcidade" => $parametros["idcidade"]));
       echo "<option value=''>Selecione o Bairro</option>\n ";
       foreach ($listarBairros as $valor){
            echo "<option value='".$valor->getId()."'>".$valor->getNome()."</option>\n ";
       }
        
    }
}
