<script src="assets/js/util.validate.js"></script>
<script src="assets/js/pwstrength.js"></script>
<?php
Sessao::gerarToken();
?>
<script>

    $(document).ready(function() {
//        $('.alert').hide();
//        $("#txtSenhaAtual").focusin(function() {
//            $('.alert').fadeOut();
//        });
//        $('#divalert').hide();
        $("#btnCancelar").click(function() {
            if (confirm("Deseja cancelar a alteração da senha?")) {
                location.href = "index.php?entidade=Usuario&acao=meuPIP";
            }
        });
        "use strict";
        var options = {
            bootstrap3: true,
            minChar: 8,
            errorMessages: {
                password_too_short: "<font color='red'>A senha é muito pequena</font>",
                same_as_username: "<font color='red'>Sua senha não pode ser igual ao seu login</font>"
            },
            verdicts: ["Fraca", "Normal", "Média", "Forte", "Muito Forte"],
            usernameField: "#txtLogin",
            onLoad: function() {
                $('#messages').text('Start typing password');
            },
            onKeyUp: function(evt) {
                $(evt.target).pwstrength("outputErrorList");
            }
        };
        $('#txtSenha').pwstrength(options);
        $("#btnAlterar").click(function() {
            if ($("#form").valid()) {
                if (($("input[name^=txtSenhaAtual]").val()) === ($("input[name^=txtSenhaNova]").val())) {
                       alert("A nova senha não pode ser igual a senha atual.");
                }else{
                $("#form").submit();
            }
            }
        });
        $('#form').validate({
            rules: {
                txtSenha: {
                    required: true,
                    minlength: 4
                },
                txtSenhaConfirmacao: {
                    required: true,
                    equalTo: "#txtSenha"
                }
            },
            messages: {
                txtSenha: {
                    required: "Campo obrigatório",
                    minlength: "Senha deve possuir no mínimo 4 caracteres"
                },
                txtSenhaConfirmacao: {
                    required: "Campo obrigatório",
                    equalTo: "Por Favor digite o mesmo valor novamente"
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                form.submit();
            }
        });
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li class="active">Alterar Senha</li>
</ol>

<!--    <div class="alert">Alterar a Senha</div>-->
        <div class="alert">Preencha os Campos Abaixo</div>

    <form id="form" class="form-horizontal" action="index.php" method="post">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="trocarsenha" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        
        <div class="form-group" id="divlinha1">
            <label class="col-lg-3 control-label" for="txtSenhaAtual">Senha Atual</label>
            <div class="col-lg-3">
                <input type="password" id="txtSenhaAtual" name="txtSenhaAtual" class="form-control" placeholder="Informe a nova senha">
            </div>
        </div>

        <div class="form-group" id="divlinha1">
            <label class="col-lg-3 control-label" for="txtSenha">Nova Senha</label>
            <div class="col-lg-3">
                <input type="password" id="txtSenha" name="txtSenhaNova" class="form-control" placeholder="Informe a nova senha">
            </div>
        </div>

        <div class="form-group" id="divlinha2">
            <label class="col-lg-3 control-label" for="txtSenhaConfirmacao">Repita a Nova Senha</label>
            <div class="col-lg-3">
                <input type="password" id="txtSenha" name="txtSenhaConfirmacao" class="form-control" placeholder="Informe a nova senha">
            </div>
        </div>

        <div class="row" id="divlinha3">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button id="btnAlterar" type="button" class="btn btn-primary">Alterar</button>
                        <button id="btnCancelar" type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>


    </form>
</div>



