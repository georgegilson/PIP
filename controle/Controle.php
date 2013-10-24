<?php

$parametros = $_POST;
$entidade = $parametros["hdnEntidade"];
$acao = $parametros["hdnAcao"];

include_once ($entidade."Controle.php");
$classe = $entidade."Controle";
$controle = new $classe;

$controle->$acao($parametros);


