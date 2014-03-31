<?php
####CONFIGURACOES DO PHP######################
ini_set("display_errors",1);
error_reporting(1);
date_default_timezone_set("America/Belem");

####CONSTANTES################################
define(PIPROOT, dirname (__FILE__));
define(PIPURL, "http://" . $_SERVER['HTTP_HOST']. dirname( $_SERVER["SCRIPT_NAME"]) );
define(TEMPOTOKEN, 600); // 10 minutos

####INCLUDES##################################
include_once 'configuracao/Template.php';
include_once 'controle/Controle.php';
include_once 'configuracao/Sessao.php';
include_once 'assets/mailer/class.phpmailer.php';
include_once 'assets/mailer/class.smtp.php';
include_once 'configuracao/Email.php';

####INDEX#####################################
Sessao::criarSessaoUsuario();
$parametros = $_REQUEST;
$controle = new Controle($parametros);

?>