<?php
  
    $parametros = $_REQUEST;

    include_once 'configuracao/Template.php';
    include_once 'controle/Controle.php';
    
    $controle = new Controle($parametros);
        
?>