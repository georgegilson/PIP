<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Meus Anúncios</h1>
    </div>
    <!-- Example row of columns -->
    <form>   
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Imóvel Referência</th>
                    <th>Titulo</th>
                    <th>Descrição</th> 
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Data da Publicação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $item = $this->getItem();
                if ($item) {
                    foreach ($item as $anuncio) {
                        ?>
                        <tr>
                            <td><span class="label label-info"><?php echo $anuncio->getImovel()->Referencia() ?></span></td>
                            <td><?php echo $anuncio->getTituloAnuncio(); ?></td>
                            <td><?php echo $anuncio->getDescricaoAnuncio(); ?></td>
                            <td><?php echo "R$ " . $anuncio->getValor(); ?></td>
                            <td><?php echo $anuncio->getStatus(); ?></td>
                            <td><?php echo $anuncio->getDatahoracadastro(); ?></td>
                            <td><button type="button" id="btnAnuncioModal<?php echo $anuncio->getId(); ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-eye-open"></span> Visualizar 
                                </button>
                            </td>    
                            <?php if ($anuncio->getStatus() == "cadastrado") { ?>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <span class="glyphicon glyphicon-bullhorn"></span> 
                                        <span class="glyphicon glyphicon-check"></span> Encerrar 
                                    </button>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="divAnuncioModal" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!--            <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title" id="lblAnuncioModal"></h2>
                                </div>-->
                    <div id="modal-body" class="modal-body text-center">
                    </div>
        <!--            <div class="modal-footer text-right"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                    </div>-->
                </div>
            </div>
        </div><!-- /.modal -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('[id^=btnAnuncioModal]').click(function() {
                    $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
                    $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
                    $("#modal-body").load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'modal', hdnToken: '<?php //Sessao::gerarToken(); echo $_SESSION["token"];      ?>', hdnModal: $(this).attr('data-modal')});
                })
            });
        </script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="assets/js/gmaps.js"></script>
    </form>
</div>