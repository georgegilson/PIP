<script src="assets/js/bootstrap-touchspin.js"></script>
<script>
    $(document).ready(function() {
        $("input[name^='spnPlano']").TouchSpin().change(
                function() {
                    $("#txtTotal").val(Total());
                });
    })

    function Total() {
        var soma = 0.0;
        $("input[name='txtPreco[]']").each(function() {
            var plano = 'spn' + $(this).attr('id');
            soma += parseFloat($(this).val()) * parseFloat($("input[name='" + plano + "']").val());
        })
        return soma;
    }

</script>
<div class="container">
    <div class="page-header">
        <h1>Meu PIP!</h1>
    </div>
    <!-- Alertas -->
    <div class="alert"></div>
    <!-- Primeira Linha -->        
    <div class="row">
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Meus Planos</div>		
                <?php
                $item = $this->getItem();
                if ($item) {
                    ?>
                    <table class="table table-bordered table-condensed table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Descrição Completa</th>
                                <th>Compra</th>
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
                } else {
                    echo "Você ainda não tem planos";
                }
                ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading">Comprar</div>
                <!-- form -->
                <table class="table table-bordered table-condensed table-hover table-responsive">
                    <colgroup>
                        <col class="col-xs-7">
                        <col class="col-xs-2">
                        <col class="col-xs-2">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Quantidade</th>
                            <th>Preço (R$)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                            <td><input readonly class="form-control" id="txtTotal" name="txtTotal" /></td>
                        </tr>
                    </tfoot>                    
                    <tbody>                        
                    <form id="form" class="form-horizontal">
                        <?php
                        if ($item) {
                            foreach ($item["plano"] as $plano) {
                                echo "<tr>";
                                echo "<td>" . $plano->getTitulo() . "</td>";
                                echo "<td><input id='spnPlano[" . $plano->getId() . "]' type='text' value='0' name='spnPlano[" . $plano->getId() . "]'></td>";
                                echo "<td><input readonly class='form-control' id='Plano[" . $plano->getId() . "]' type='text' value='" . $plano->getPreco() . "' name='txtPreco[]'></td>";
                                echo "</tr>";
                            }
                        }
                        ?>  

                        </tbody>
                </table>                    

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-6">
                                <button type="submit" class="btn btn-primary">Comprar!</button>
                            </div>
                        </div>                
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>