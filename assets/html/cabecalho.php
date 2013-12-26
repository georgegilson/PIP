<!--<!DOCTYPE HTML>-->

<!--<html lang="pt-br">-->
<!--    <head>-->
<meta charset="UTF-8">
<title>PIP - Procure Im&oacute;veis Pai D'Egua</title> 
<!-- TWITTER BOOTSTRAP CSS --> 
<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" /> 
<!-- Bootstrap theme -->
<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" /> 
<!-- Template PIP -->
<link href="assets/css/template-pip.css" rel="stylesheet" type="text/css" /> 		
<!-- Carrossel -->
<link href="assets/css/carousel.css" rel="stylesheet" type="text/css" />
<!-- JQUERY --> 
<script src="assets/js/jquery-2.0.2.min.js"></script> 
<!-- TWITTER BOOTSTRAP JS --> 
<script src="assets/js/bootstrap.min.js"></script> 
<!-- JQUERY VALIDATE JS --> 
<script src="assets/js/jquery.validate.min.js"></script> 
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="assets/css/blueimp-gallery.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-ui-noscript.css"></noscript>
<!--    </head> -->
<script>
    $(document).ready(function() {
<?php
//session_start();
if (Sessao::verificarSessaoUsuario()) {
    ?>
            /*$('#divLogin').hide();
            $('#divSenha').hide();
            $('#divAcessar').hide();
            $("#divUsuario").fadeIn('slow');*/
            $("#divUsuario").html("<h4>Seja bem vindo <?php echo $_SESSION['nome']; ?>  <h4>");
            $("#btnLogout").attr('class','btn btn-danger');
    <?php
}
?>
        $("#btnAcessar").click(function() {
            autenticarUsuario();
        });
        $("#btnLogout").click(function() {
            logoutUsuario();
        });
        function autenticarUsuario() {
            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: {
                    login: $('#txtlogin').val(),
                    senha: $('#txtsenha').val(),
                    hdnToken: $('#hdnToken').val(),
                    hdnEntidade: "Usuario",
                    hdnAcao: "autenticar"
                },
                beforeSend: function() {
                },
                success: function(resposta) {
                    if (resposta.resultado == 1) {
                        var nome = resposta.nome;
                        $('#divLogin').hide();
                        $('#divSenha').hide();
                        $('#divAcessar').hide();
                        $("#divUsuario").fadeIn('slow');
                        $("#divUsuario").html("<h4>Seja bem vindo  " + resposta.nome + "<h4>");
                    } else {

                    }
                }
            })
        }

        function logoutUsuario() {
            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: {
                    hdnEntidade: "Usuario",
                    hdnAcao: "logout"
                },
                beforeSend: function() {

                },
                success: function(resposta) {
                    if (resposta.resultado == 1) {
                        $("#divUsuario").hide();
                        $('#divLogin').show();
                        $('#divSenha').show();
                        $('#divAcessar').show(); 
                        $('#btnLogout').hide(); 
                    }
                }
            })
        }
    });
</script>

<body>
    <!-- Fixed navb ar -->
    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value=""  />
    <input type="hidden" id="hdnAcao" name="hdnAcao" value="" />
    
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Procure Im&oacute;veis Pai d'egua</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">In&iacute;cio</a></li>
                    <li><a href="#compare">Compare</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Im&oacute;veis <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?entidade=Imovel&acao=form">Cadastro</a></li>
                            <li><a href="index.php?entidade=Imovel&acao=listar">Listagem</a></li>
                            <li><a href="index.php?entidade=Anuncio&acao=listar">Meus Anúncios</a></li>
                            <!--<li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>-->
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuário <b class="caret"></b></a>
                        <ul class="dropdown-menu">
<!--                            <li><a href="index.php?entidade=Usuario&acao=form">Cadastro</a></li>-->
                            <li><a href="index.php?entidade=Usuario&acao=selecionar">Atualizar Cadastro</a></li>
<!--                            <li><a href="#">Alterar Login/Senha</a></li>-->
                            <!--<li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>-->
                        </ul>
                    </li>
<!--                    <li><a href="#about">Sobre a Empresa</a></li>-->
                    <li><a href="index.php?entidade=Usuario&acao=form&tipo=login">Login</a></li>
                    <li><a href="index.php?entidade=Usuario&acao=form&tipo=cadastro">Cadastre-se</a></li>
                    <li><a href="index.php?entidade=Usuario&acao=form&tipo=esquecisenha">Esqueci Login/Senha</a></li>
                </ul>
                <div class="form-group">
                    <form class="navbar-form navbar-right">
                       <!-- <div class="form-group" id="divLogin">
                            <input id="txtlogin" type="text" placeholder="login" class="form-control">     
                        </div>
                        <div class="form-group" id="divSenha">
                            <input id="txtsenha" type="password" placeholder="senha" class="form-control">
                        </div>
                        <div class="form-group" id="divAcessar">
                            <button id="btnAcessar" type="button" class="btn btn-info">Acessar</button>
                        </div>-->
                        <div class = "form-group" id="divUsuario" hidden="true">
                        </div>
                        <button id="btnLogout" type="button" class="hide">Sair</button>         
                    </form>            
                </div>

            </div><!--/.nav-collapse -->
        </div>
    </div>	    
    <hr />

