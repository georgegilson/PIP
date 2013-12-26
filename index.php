<?php
####CONFIGURACOES DO PHP######################
ini_set("display_errors",1);
error_reporting(1);
date_default_timezone_set("America/Belem");

####CONSTANTES################################
define(PIPROOT, dirname (__FILE__));

####INCLUDES##################################
include_once 'configuracao/Template.php';
include_once 'controle/Controle.php';
include_once 'configuracao/Sessao.php';

####INDEX#####################################
Sessao::criarSessaoUsuario();
$parametros = $_REQUEST;
$controle = new Controle($parametros);

?>