<script src="assets/js/util.validate.js"></script>

<?php
Sessao::gerarToken();
?>
<script>

    $(document).ready(function() {
        $('.alert').hide();
        $("#txtEmail").focusin(function() {
            $('.alert').fadeOut();
        });
        $('#divalert').hide();
        $('#form').validate({
            rules: {
                txtEmail: {
                    email: true,
                    required: true
                }
            },
            messages: {
                txtEmail: {
                    required: "Campo obrigatório"
                },
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
                        $(".alert").fadeIn();
                        $('button[type=submit]').removeAttr('disabled');
                        if (resposta.resultado == 0) {
                            $("#form").hide();
                            $('.page-header').hide();
                            $('#divalert').attr('class', 'row text-success');
                            var img = $("<h1>", {class: "glyphicon glyphicon-ok"}, "</h1>");
                            $('#divimg').append(img);
                            $("#divmsg").html("<h2 class=text-center>Em breve você receberá um e-mail para realizar a alteração de sua senha!</h2>\n\
                                 <p class=text-center>Caso não tenha recebido o e-mail, verifique também a sua caixa de SPAM. </p>");
                            $("#divalert").fadeIn();
                        } else if (resposta.resultado == 1) {
                            $('.alert').html("Falha no envio do email").attr('class', 'alert alert-danger');
                        } else if (resposta.resultado == 2) {
                            $('#mensagem').html("Não há cadastro para o email informado").attr('class', 'text-danger');
                            $('.alert').html("Não há cadastro para o email informado").attr('class', 'alert alert-danger');
                        }
                        else if (resposta.resultado == 3) {
                            $("#form").hide();
                            $('.page-header').hide();
                            $('#divalert').attr('class', 'row text-danger');
                            var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                            $('#divimg').append(img);
                            $("#divmsg").html("<h2 class=text-center>Desculpe, não foi possível realizar a operação!</h2>\n\
                                                    <h4 class=text-center>Tente novamente em alguns minutos.</h4>");
                            $("#divalert").fadeIn();
                        } else if (resposta.resultado == 4) {
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
        <h1>Identificação de Usuário</h1>
    </div>
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->
    <div id="divalert">
        <div class="col-lg-2">
            <div class="text-right" id="divimg">
            </div>
        </div>
        <div class="col-lg-8" id="divmsg">
            <!--            <h2 class=text-center>Em breve você receberá um e-mail para realizar a alteração de sua senha!</h2>
                        <p class=text-center>Caso não tenha recebido o e-mail, verifique também a sua caixa de SPAM. </p>-->
        </div>
    </div>

    <div class="alert"></div>
    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="esquecersenha" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        <div class="form-group">
            <label class="col-lg-3 control-label" for="txtEmail">Email</label>
            <div class="col-lg-3">
                <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o email cadastrado">
                <!--                            <div id="mensagem" class="col-lg-3 control-label"></div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>


    </form>
</div>



