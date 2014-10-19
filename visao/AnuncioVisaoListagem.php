<script src="assets/js/bootstrap-maxlength.js"></script>
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Meus Anúncios</h1>
    </div>
    <!-- Example row of columns -->
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
                                <button type="button" id="btnNegocioModal<?php echo $anuncio->getId(); ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#divNegocioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Finalizar Negócio 
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
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php
                        Sessao::gerarToken();
                        echo $_SESSION["token"];
                        ?>" />
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
            $('#divNegocioModal').on('hidden.bs.modal', function (e) {
                window.location.reload();
              })
        });
    </script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="assets/js/gmaps.js"></script>
</div>