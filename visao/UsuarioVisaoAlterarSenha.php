<script src="assets/js/util.validate.js"></script>
<script src="assets/js/pwstrength.js"></script>
<?php
Sessao::gerarToken();
?>
<script>

    $(document).ready(function() {
        $('#divalert').hide();
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
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#form').serialize(),
                    success: function(resposta) {
                        if (resposta.resultado == 0) {
                            $("#form").hide();
                            $('.page-header').hide();
                            $('#divalert').attr('class', 'row text-success');
                            var img = $("<h1>", {class: "glyphicon glyphicon-ok"}, "</h1>");
                            $('#divimg').append(img);
                            $("#divmsg").html("<h2 class=text-center>Sua senha foi alterada com sucesso!</h2>");                               
                            $("#divalert").fadeIn();
                        }else if (resposta.resultado == 1) {
                            $("#form").hide();
                            $('.page-header').hide();
                            $('#divalert').attr('class', 'row text-danger');
                            var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                            $('#divimg').append(img);
                            $("#divmsg").html("<h2 class=text-center>Desculpe, não foi possível realizar a operação!</h2>\n\
                                                    <h4 class=text-center>Tente novamente em alguns minutos.</h4>");
                            $("#divalert").fadeIn();
                        }else if (resposta.resultado == 2) {
                            $("#form").hide();
                            $('.page-header').hide();
                            $('#divalert').attr('class', 'row text-danger');
                            var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                            $('#divimg').append(img);
                            $("#divmsg").html("<h2 class=text-center>Ops! Não podemos processar sua requisição. <br>Tente novamente.</h2>");
                            $("#divalert").fadeIn();
                        }
                    }
                })
            }
        });
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Alterar Senha</h1>
    </div>
    <div id="divalert">
        <div class="col-lg-2">
            <div class="text-right" id="divimg">
            </div>
        </div>
        <div class="col-lg-8" id="divmsg">
        </div>
    </div>
    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterarsenha" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

        <div class="form-group" id="divlinha1">
            <label class="col-lg-3 control-label" for="txtSenha">Nova Senha</label>
            <div class="col-lg-9">
                <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe a nova senha">
            </div>
        </div>

        <div class="form-group" id="divlinha2">
            <label class="col-lg-3 control-label" for="txtSenhaConfirmacao">Repita a Nova Senha</label>
            <div class="col-lg-9">
                <input type="password" id="txtSenha" name="txtSenhaConfirmacao" class="form-control" placeholder="Informe a nova senha">
            </div>
        </div>

        <div class="row" id="divlinha3">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                        <button type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>


    </form>
</div>



