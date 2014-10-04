<script>
    $(document).ready(function() {
<?php
$item = $this->getItem();
switch ($item) {
    case "errobanco":
    case "errotrocasenha":
    case "errolink":
    case "errotoken":
        ?>
                $('#diverro').attr('class', 'row text-danger');
                var img = $("<h1>", {class: "glyphicon glyphicon-exclamation-sign"}, "</h1>");
                $('#divimg').append(img);
        <?php
        break;
    case "sucessoalterarsenha":
    case "sucessocadastrousuario":
    case "sucessocadastroimovel":
    case "sucessoedicaousuario":
        ?>
                $('#diverro').attr('class', 'row text-success');
                var img = $("<h1>", {class: "glyphicon glyphicon-ok"}, "</h1>");
                $('#divimg').append(img);
        <?php
        break;
    case "sucessoedicaoimovel":
        ?>
                alert("Imóvel Atualizado com Sucesso");
                location.href = "index.php?entidade=Imovel&acao=listarEditar";
        <?php
        break;
    
}
?>
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div id="diverro">
        <div class="col-lg-2">
            <div class="text-right" id="divimg">

            </div>
        </div>
        <div class="col-lg-8" id="divmsg">
            <?php
            $item = $this->getItem();
            switch ($item) {
                case "errobanco":
                    ?>
                    <h2 class=text-center>Desculpe, não foi possível realizar a operação!</h2>\n\
                    <h4 class=text-center>Tente novamente em alguns minutos.</h4>
                    <?php
                    break;
                case "errotrocasenha":
                    ?>
                    <h2 class=text-center>Desculpe, não foi possível realizar a operação!</h2>\n\
                    <h4 class=text-center>A Senha atual está incorreta.</h4>
                    <?php
                    break;
                case "errolink":
                    ?>
                    <h2 class=text-center>Esse link é inválido ou já foi utilizado para troca de senha.</h2>
                    <?php
                    break;
                case "errotoken":
                    ?>
                    <h2 class=text-center>Ops! Não podemos processar sua requisição. <br>Tente novamente.</h2>
                    <?php
                    break;
                case "sucessocadastrousuario":
                    ?>
                    <h2 class=text-center>A sua conta de usuário foi criada com sucesso!</h2>
                    <p class=text-center>Em breve você receberá um e-mail para confirmação do cadastro. </p>
                    <p class=text-center>Caso não tenha recebido a confirmação de cadastro, verifique também a sua caixa de SPAM. </p>
                    <p class=text-center>Lembramos que a ativação de sua conta se dá mediante sua confirmação. </p>
                    <?php
                    break;
                case "sucessoalterarsenha":
                    ?>
                    <h2 class=text-center>A sua senha foi alterada com sucesso!</h2>
                    <?php
                    break;
                case "sucessoedicaousuario":
                    ?>
                    <h2 class=text-center>O cadastro foi atualizado com sucesso!</h2>
                    <?php
                    break;
                case "sucessocadastroimovel":
                    ?>
                    <h2 class="text-center">O imóvel foi cadastrado com sucesso!</h2>
                    <p class="text-center">O que deseja fazer? </p> 
                    <p class="text-center">
                        <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                            <button type="button" class="btn btn-info">
                                <span class="glyphicon glyphicon-bullhorn"></span> 
                                <span class="glyphicon glyphicon-plus"></span> Cadastrar Anúncios
                            </button>
                        </a> 

                        <a href="index.php?entidade=Imovel&acao=form">
                            <button type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-home"></span>
                                <span class="glyphicon glyphicon-plus"></span> Cadastrar Outro Imóvel
                            </button></a>                    
                    </p>

                    <?php
                    break;
            }
            ?>
        </div>
    </div>
</div>

