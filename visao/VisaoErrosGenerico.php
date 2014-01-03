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
    case "erroemail":
        ?>
                    $('#diverro').attr('class', 'row text-danger');
                    var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                    $('#divimg').append(img);
                    $("#divmsg").html("<h2 class=text-left>O E-mail digitado é inválido.</h2>");
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

