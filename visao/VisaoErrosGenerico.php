<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 

    <script>

        $(document).ready(function() {
<?php
$item = $this->getItem();
switch ($item) {
    case "errobanco":
        ?>
                    $('#diverro').attr('class', 'row text-danger');
                    var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                    $('#divimg').append(img);
                    $("#divmsg").html("<h2 class=text-center>Desculpe, não foi possível realizar a operação!</h2>\n\
                                                    <h4 class=text-center>Tente novamente em alguns minutos.</h4>");
        <?php
        break;
    case "errolink":
        ?>
                    $('#diverro').attr('class', 'row text-danger');
                    var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                    $('#divimg').append(img);
                    $("#divmsg").html("<h2 class=text-center>Esse link é inválido ou já foi utilizado para troca de senha.</h2>");
        <?php
        break;
    case "errotoken":
        ?>
                    $('#diverro').attr('class', 'row text-danger');
                    var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                    $('#divimg').append(img);
                    $("#divmsg").html("<h2 class=text-center>Ops! Não podemos processar sua requisição. <br>Tente novamente.</h2>");
        <?php
        break;
    case "sucessocadastrousuario":
        ?>
                    $('#diverro').attr('class', 'row text-success');
                    var img = $("<h1>", {class: "glyphicon glyphicon-ok"}, "</h1>");
                    $('#divimg').append(img);
                    $("#divmsg").html("<h2 class=text-center>A sua conta de usuário foi criada com sucesso!</h2>\n\
                                 <p class=text-center>Em breve você receberá um e-mail para confirmação do cadastro. </p>\n\
                                 <p class=text-center>Caso não tenha recebido a confirmação de cadastro, verifique também a sua caixa de SPAM. </p>\n\
                                 <p class=text-center>Lembramos que a ativação de sua conta se dá mediante sua confirmação. </p>");
        <?php
        break;
}
?>
        });
    </script>
    <div id="diverro">
        <div class="col-lg-2">
            <div class="text-right" id="divimg">

            </div>
        </div>
        <div class="col-lg-8" id="divmsg">

        </div>
    </div>
</div>

