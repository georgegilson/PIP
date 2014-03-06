<div class="container">
    <div class="page-header">
        <h1>Meu PIP!</h1>
    </div>
    <div class="row">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Dados</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=Usuario&acao=selecionar">
                    <button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        <span class="glyphicon glyphicon-pencil"></span> Atualizar Cadastro
                    </button></a>
                <a href="index.php?entidade=Usuario&acao=form&tipo=trocarsenha"> 
                    <button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        <span class="glyphicon glyphicon-lock"></span> Alterar Senha 
                    </button></a>    
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Imóveis</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=Imovel&acao=form">
                    <button type="button" class="btn btn-success">
                        <span class="glyphicon glyphicon-home"></span>
                        <span class="glyphicon glyphicon-plus"></span> Cadastrar Imóvel
                    </button></a>
                <a href="index.php?entidade=Imovel&acao=listarEditar">
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-home"></span>
                    <span class="glyphicon glyphicon-pencil"></span> Editar Imóvel
                </button></a>
                <a href="index.php?entidade=Imovel&acao=listar">
                    <button type="button" class="btn btn-success">
                        <span class="glyphicon glyphicon-home"></span> 
                        <span class="glyphicon glyphicon-list-alt"></span> Visualizar Meus Imóveis
                    </button></a>
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-home"></span> 
                    <span class="glyphicon glyphicon-star-empty"></span> Imóveis Favoritos
                </button>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Anúncios</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=Anuncio&acao=listarCadastrar">
                    <button type="button" class="btn btn-info">
                        <span class="glyphicon glyphicon-bullhorn"></span> 
                        <span class="glyphicon glyphicon-plus"></span> Cadastrar Anúncio
                    </button></a>
<!--                <button type="button" class="btn btn-info">
                    <span class="glyphicon glyphicon-bullhorn"></span> 
                    <span class="glyphicon glyphicon-pencil"></span> Editar Anúncio
                </button>-->
                <a href="index.php?entidade=Anuncio&acao=listar">
                    <button type="button" class="btn btn-info">
                        <span class="glyphicon glyphicon-bullhorn"></span> 
                        <span class="glyphicon glyphicon-list-alt"></span> Visualizar Meus Anúncios
                    </button></a>
                <a href="index.php?entidade=Anuncio&acao=listarMensagem">
                    <button type="button" class="btn btn-info">
                        <span class="glyphicon glyphicon-bullhorn"></span> 
                        <span class="glyphicon glyphicon-envelope"></span> Visualizar Mensagens
                    </button></a>
            </div>
        </div>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Meus Planos</h3>
            </div>
            <div class="panel-body">
                <a href="index.php?entidade=UsuarioPlano&acao=listar">
                    <button type="button" class="btn btn-warning">
                        <span class="glyphicon glyphicon-shopping-cart"></span> Comprar
                    </button></a>
            </div>
            <?php
            $item = $this->getItem();
            if ($item) {
                if (!$item["usuarioPlano"]) {
                    ?>
                    <span class="text-danger"><strong>Poxa, infelizmente você ainda não tem plano. Não perca tempo e Compre Agora! </strong> 
                        <br/> <img src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" width="100%"/> 
                    </span>
                    <?php
                } else {
                    ?>
                    <table class="table table-bordered table-condensed table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Descrição</th>
                                <th>Data de Compra</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                echo "<tr>";
                                echo "<td>" . $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias)</td>";
                                echo "<td>" . $usuarioPlano->getPlano()->getDescricao() . "</td>";
                                echo "<td>" . $usuarioPlano->getDataCompra() . "</td>";
                                echo "<td>" . $usuarioPlano->getStatus() . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>


        </div>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Precisa de ajuda?</h3>
            </div>
            <div class="panel-body">
                <button type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-envelope"></span> Fale Conosco
                </button>
                <button type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> Dúvidas Mais Frequentes
                </button>
            </div>
        </div>

    </div>

</div>