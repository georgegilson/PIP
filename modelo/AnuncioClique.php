<?php

class AnuncioClique {
    
    private $id;
    private $idanuncio;
    private $tipousuario;
    private $data;
    
    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }
    
    function getTipoUsuario() {
        return $this->tipousuario;
    }
    
    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }
    
    function setTipoUsuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    function setData($data) {
        $this->data = $data;
    }
    
    function Cadastrar($parametros){
        
        $anuncioClique = new AnuncioClique();
        
        if(isset($_SESSION)){
            $anuncioClique->setTipoUsuario($_SESSION["idusuario"]);
        } else $anuncioClique->setTipoUsuario("0"); 
        $anuncioClique->setData(date('d/m/Y H:i:s'));
       
        $anuncioClique->setIdanuncio($parametros["hdnModal"]);
        
        return $anuncioClique;
        
    }
    
}
