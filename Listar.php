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
        
        
        <form method="post" action="controle/Controle.php">
        
        <input type="hidden" name="hdnEntidade" value="Imovel" />
        <input type="hidden" name="hdnAcao" value="listar" />
            
        <input type="submit" value="Listar Imóveis"> <br />
            
        </form>
        

    </body>
</html>
