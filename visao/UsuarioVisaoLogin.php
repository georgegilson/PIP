
<script>
    $(document).ready(function() {
        $("#btnAcessar").click(function() {
            autenticarUsuario();
        });
        function autenticarUsuario() {
            alert('oi!');
//            $.ajax({
//                url: "index.php",
//                dataType: "json",
//                type: "POST",
//                data: {
//                    login: $('#txtlogin').val(),
//                    senha: $('#txtsenha').val(),
//                    hdnEntidade: "Usuario",
//                    hdnAcao: "autenticar"
//                },
//                beforeSend: function() {
//                },
//                success: function(resposta) {
//                    if (resposta.resultado == 1) {
//
//                    } else {
//
//                    }
//                }
//            })
        }
    });
</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Identificação de Usuário</h1>
    </div>
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->
    <form class="form-horizontal" id="form">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value=""  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="" />
        <div class="form-group">
            <label for="lblUsuario" class="col-sm-2 control-label">Login</label>
            <div class="col-sm-3">
                <input type="text" id="txtlogin" class="form-control" placeholder="Informe o login">
            </div>
        </div>
        <div class="form-group">
            <label for="lblSenha" class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="txtsenha" placeholder="Informe a sua senha">
            </div>
        </div>
        <!--            <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>-->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" id="btnAcessar">Entrar</button>
            </div>
        </div>
    </form>
</div>

