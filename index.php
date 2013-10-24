<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="controle/Controle.php">
    
    Valor: <input type="text" name="valor" size ="30"> <br />
    Finalidade: <input type="text" name="finalidade" size ="30"> <br />
    Quarto: <input type="text" name="quarto" size ="30"> <br />
    <input type="hidden" name="hdnEntidade" value="Imovel" />
    <input type="hidden" name="hdnAcao" value="cadastrar" />
    <input type="submit" value="Cadastrar"> <br />
    
        </form>
    </body>
</html>
