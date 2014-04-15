<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
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
        <!-- Grid Form -->
        <link href="assets/css/gridforms.css" rel="stylesheet" type="text/css" />
        <!-- Switch Button -->
        <link href="assets/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- JQUERY --> 
        <script src="assets/js/jquery-2.0.2.min.js"></script> 
        <!-- TWITTER BOOTSTRAP JS --> 
        <script src="assets/js/bootstrap.min.js"></script> 
        <!-- JQUERY VALIDATE JS --> 
        <script src="assets/js/jquery.validate.min.js"></script> 
        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-ui-noscript.css"></noscript>
    </head>
    <body>
        <div class="container cabecalho">
            <div class="row">
                <div class="col-lg-2"><a href="index.php"> <img src="assets/imagens/logo.png" width="120px" /> </a> </div>
                <div class="col-lg-6">
                    <h4> Temos a Ferramenta Tecnológica de busca do seu imóvel desejado <br /> Procure aqui!</h4>
                </div>
                <div class="col-lg-4">
                    <div id="divForm">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="3"><h4 id="divTitulo"> Acesse o Meu PIP! </h4></td>
                                </tr>
                                <tr>
                                    <td width="151"><input name="txtLoginIndex" type="text" class="form-control" id="txtLoginIndex" style="width:145px" placeholder="Informe o Usuário"></td>
                                    <td width="75"><input name="txtSenhaIndex" type="password" class="form-control" id="txtSenhaIndex" style="width:70px" placeholder="Senha"></td>
                                    <td><button type="button" id="btnAcessar" class="btn btn-sm btn-primary">Acessar</button></td>
                                </tr>
                                <tr>
                                    <td height="30" colspan="3">
                                        <a href="index.php?entidade=Usuario&acao=form&tipo=cadastro" class="text text-success">Ainda não é cadastrado?</a>
                                        <a href="index.php?entidade=Usuario&acao=form&tipo=esquecisenha" class="text text-danger">Não lembra a senha?</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="divUsuario" class="hide">
                        <form class="navbar-form navbar-right">
                            <div id="divNome"></div>
                            <div id="divBotoes">  
                                <a href="index.php?entidade=Usuario&acao=meuPIP" class="btn btn-primary"><span class="glyphicon glyphicon-th-large"></span> Meu Pip</a>
                                <a id="btnLogout" href="#" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
                            </div>
                        </form>            
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
<?php
if (Sessao::verificarSessaoUsuario()) {
    ?>
                    $("#divForm").hide();
                    $("#divUsuario").show();
                    $("#divUsuario").attr('class', 'text');
                    $("#divNome").html("<h4>Seja bem vindo <?php echo $_SESSION['nome']; ?>  <h4>");
    <?php
} else {
    Sessao::gerarToken();
};
?>
                $("#btnAcessar").click(function() {
                    autenticarUsuario();
                });
                $("#btnLogout").click(function() {
                    logoutUsuario();
                });
                function autenticarUsuario() {
                    if ($('#txtLoginIndex').val().length < 2 | $('#txtSenhaIndex').val().length < 8) {
                        alert('Atenção: Você deve informar o usuário e a senha');
                    } else {

                        $.ajax({
                            url: "index.php",
                            dataType: "json",
                            type: "POST",
                            data: {
                                txtLogin: $('#txtLoginIndex').val(),
                                txtSenha: $('#txtSenhaIndex').val(),
                                hdnEntidade: "Usuario",
                                hdnAcao: "autenticar"
                            },
                            success: function(resposta) {
                                if (resposta.resultado == 1) {
                                    var nome = resposta.nome;
                                    $('#divForm').hide();
                                    $("#divUsuario").fadeIn('slow');
                                    $("#divUsuario").attr('class', 'text');
                                    $("#divNome").html("<h4>Seja bem vindo " + resposta.nome + "  <h4>");
                                    location.href = resposta.redirecionamento;
                                }
                                if (resposta.resultado == 2) {
                                    $("#divTitulo").attr('class', 'text text-danger').html("Usuário e/ou Senha Inválidos");
                                }
                                if (resposta.resultado == 3) {
                                    $("#divTitulo").attr('class', 'text text-danger').html("Ops... lamentamos o ocorrido..").fadeIn('slow');
                                }
                            }
                        })
                    }
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
                        success: function(resposta) {
                            if (resposta.resultado == 1) {
                                $("#divUsuario").hide();
                                $('#divForm').show();
                                location.href = 'index.php'
                            }
                        }
                    })
                }
            });
        </script>
