<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listar Imóveis Cadastrados</title>
    </head>
    <body>
        <?php
        
        include_once './controle/ImovelControle.php';
        
        $imovelControle = new ImovelControle();
        
        $imovelControle->listar();
        
        var_dump($imovelControle);
        
        ?>
    </body>
</html>
