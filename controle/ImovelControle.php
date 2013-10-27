<?php

include_once '../modelo/ImovelModelo.php';
include_once '../DAO/ImovelDAO.php';

class ImovelControle {
    
    function cadastrar($parametros){
    
    $imovelModelo = new ImovelModelo();
        
    $entidadeImovel = $imovelModelo->cadastrar($parametros);    
        
    $imovelDAO = new ImovelDAO();
    
    $resultado = $imovelDAO->cadastrar($entidadeImovel);
    
        if($resultado){
            print "Cadastrado";
        } else "Erro Ao Cadastrar";

        }
        
    function listar(){
        
      //  $imovelModelo = new ImovelModelo();
        
        //$entidadeImovel = $imovelModelo->listar();    
        
        $imovelDAO = new ImovelDAO();
        
        print "Passou 1 <br />";
        
        $resultado = $imovelDAO->listar();
        
        print "Passou 2 <br />";
        
        var_dump($resultado);/*
        
        return $resultado;
        
        print "Teste: ".$resultado;*/
        
    }
    
}
