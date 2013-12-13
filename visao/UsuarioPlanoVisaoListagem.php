<script src="assets/js/bootstrap-touchspin.js"></script>
<script>
    $(document).ready(function() {
        $("input[name^='spnPlano']").TouchSpin();
    })
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
                <form id="form" class="form-horizontal">
                    <?php
                    if ($item) {
                        foreach ($item["plano"] as $plano) {
                            ?>
                            <div class="form-group">    
                                <label class="col-lg-6 control-label"> <?php echo $plano->getTitulo(); ?> </label>
                                <div class="col-lg-3">
                                    <input id="spnPlano[<?php echo $plano->getId(); ?>]" type="text" value="0" name="spnPlano[<?php echo $plano->getId(); ?>]">
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>  
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