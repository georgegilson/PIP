<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <?php
        Sessao::gerarToken();
        $item = $this->getItem();
        switch ($item["tipoListagemAnuncio"]) {
            case 'ativo':
                echo '<li class="active"> Visualizar Anúncios Ativos</li>';
                break;
            case 'finalizado':
                echo '<li class="active"> Visualizar Anúncios Finalizados</li>';
                break;
            case 'reativar':
                echo '<li class="active"> Reativar Anúncios</li>';
                break;
        }
        ?>
    </ol>
    <!-- Example row of columns -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Imóvel</th>
                <th>Finalidade</th>
                <th>Titulo</th>
                <th>Descrição</th> 
                <th>Valor</th>
                <th>Status</th>
                <th>Publicado em:</th>
                <th class="text-center" colspan="2">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($item) {
                foreach ($item["listaAnuncio"] as $anuncio) {
                    ?>
                    <tr>
                        <td><span class="label label-info"><?php echo $anuncio->getImovel()->Referencia() ?></span></td>
                        <td><span class="label label-primary"><?php echo $anuncio->getFinalidade(); ?></span></td>
                        <td><?php echo $anuncio->getTituloAnuncio(); ?></td>
                        <td><?php echo $anuncio->getDescricaoAnuncio(); ?></td>
                        <td id="tdValor<?php echo $anuncio->getId(); ?>"><?php echo $anuncio->getValor(); ?></td>
                        <td> <?php
            if ($anuncio->getStatus() == "cadastrado") {
                echo '<span class="text-success">' . $anuncio->getStatus() . ' </span>';
            } elseif ($anuncio->getStatus() == "finalizado") {
                echo '<span class="text-danger" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Finalizado em: <br> ' . $anuncio->getHistoricoAluguelVenda()->getDatahora() . '">' . $anuncio->getStatus() . ' <span class="label label-danger">?</span></span>';
            }
                    ?>
                        </td>
                        <td><?php echo $anuncio->getDatahoracadastro(); ?></td>
                        <td><button type="button" id="btnAnuncioModal<?php echo $anuncio->getId(); ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>">
                                <span class="glyphicon glyphicon-bullhorn"></span> 
                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar 
                            </button>
                        </td>    
                        <td>
                            <?php if ($anuncio->getStatus() == "cadastrado") { ?>
                                <button type="button" id="btnNegocioModal<?php echo $anuncio->getId(); ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#divNegocioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Finalizar Negócio 
                                </button>
                            <?php } ?>
                            <?php if ($item["tipoListagemAnuncio"] == "reativar" && $anuncio->getStatus() == "finalizado") { ?>
                                <?php if (!in_array($anuncio->getImovel()->getId(), $item["listaImoveisAnunciosPublicados"])) { ?>
                                    <a href="index.php?entidade=Anuncio&acao=form&idImovel=<?php echo $anuncio->getImovel()->getId(); ?>&token=<?php echo $_SESSION['token']; ?>" class="btn btn-success btn-sm">
                                        <span class="glyphicon glyphicon-bullhorn"></span> 
                                        <span class='glyphicon glyphicon-refresh'></span> Reativar Anúncio
                                    </a>    
                                <?php } else { ?>
                            <span class="text-primary"><span class="glyphicon glyphicon-bullhorn"></span> O imóvel já possui um anúncio ativo.</span>
                            <?php } ?>
                            <?php } ?>
                        </td>
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
                <div id="modal-body" class="modal-body text-center">
                </div>
            </div>
        </div>
    </div>
    <form id="form" class="form-horizontal" action="index.php" method="post">
        <div class="modal fade" id="divNegocioModal" tabindex="-1" role="dialog" aria-labelledby="lblNegocioModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="lblNegocioModal"></h2>
                    </div>
                    <div id="modal-body-negociacao" class="modal-body text-center">
                        <div class="alert alert-warning" style="display:none">Aguarde Processando...</div>
                        <strong>Confirmar a negociação do seu imóvel e despublicar o anúncio do site?</strong>
                        <br /><br />
                        Se você quiser conte-nos como foi a sua negociação:
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="finalizarNegocio" />
                        <input type="hidden" id="hdnAnuncio" name="hdnAnuncio"/>
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION["token"]; ?>" />
                        <textarea maxlength="200" id="txtDescricao" name="txtDescricao" rows="3" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea><br />
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" name="btnConfirmar" id="btnConfirmar" class="btn btn-primary">Confirmar!</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /.modal -->

    <script type="text/javascript">
        $(document).ready(function() {
            $("span[data-toggle='tooltip']").tooltip();

            $('[id^=btnAnuncioModal]').click(function() {
                $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
                $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
                $("#modal-body").load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'modal', hdnToken: '', hdnModal: $(this).attr('data-modal')});
            })
            $('[id^=btnNegocioModal]').click(function() {
                $("#lblNegocioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
                $("#hdnAnuncio").val($(this).attr('data-modal'));
            })
            $('#txtNegociacao').maxlength({
                alwaysShow: true,
                threshold: 200,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' de ',
                preText: 'Voc&ecirc; digitou ',
                postText: ' caracteres permitidos.',
                validate: true
            });
            $('#form').validate({
                submitHandler: function() {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#form').serialize(),
                        beforeSend: function() {
                            $('.alert').show();
                            $('#btnConfirmar').attr('disabled', 'disabled');
                        },
                        success: function(resposta) {
                            $(".alert").hide();
                            if (resposta.resultado == 1) {
                                $("#modal-body-negociacao").html('<div class="row text-success">\n\
                                                                <h2 class="text-center">Obrigado!</h2>\n\
                                                                <p class="text-center">Negócio finalizado com sucesso.</p>\n\
                                                                </div>');
                                $('#btnConfirmar').remove();
                            } else {
                                $("#modal-body-negociacao").html('<div class="row text-danger">\n\
                                                                <h2 class="text-center">Tente novamente mais tarde!</h2>\n\
                                                                <p class="text-center">Houve um erro no processamento. </p>\n\
                                                                </div>');
                                $('#btnConfirmar').removeAttr("disable");
                            }
                        }
                    })
                    return false;
                }
            })
            $('#divNegocioModal').on('hidden.bs.modal', function(e) {
                window.location.reload();
            })
            $("td[id^='tdValor']").priceFormat({
                prefix: 'R$ ',
                centsSeparator: ',',
                centsLimit: 0,
                limit: 8,
                thousandsSeparator: '.'
            })
        });
    </script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="assets/js/gmaps.js"></script>
</div>