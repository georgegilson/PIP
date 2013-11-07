<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imagem
 *
 * @author Simon
 */
class Imagem {
   
    private $id;
    private $idanuncio;
    private $diretorio;
    private $legenda;
    
    public function getId() {
        return $this->id;
    }

    public function getIdanuncio() {
        return $this->idanuncio;
    }

    public function getDiretorio() {
        return $this->diretorio;
    }

    public function getLegenda() {
        return $this->legenda;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    public function setDiretorio($diretorio) {
        $this->diretorio = $diretorio;
    }

    public function setLegenda($legenda) {
        $this->legenda = $legenda;
    }


}
