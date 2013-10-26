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
        
        $resultado = $imovelDAO->listar();
        
        return $resultado;
        
    }
    
}
