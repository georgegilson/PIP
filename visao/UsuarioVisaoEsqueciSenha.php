<?php
Sessao::gerarToken();
?>
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Identificação de Usuário</h1>
    </div>
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->
    <form id="form" class="form-horizontal" action="index.php" method="post">
                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="esquecersenha" />
                    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtLogin">Email</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o email cadastrado">
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



