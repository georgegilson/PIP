<div class="container">    
    <div class="page-header">
        <h1>Mensagens</h1>
    </div>
    <button type="submit" class="btn btn-default btn-sm" id="arquivar">Arquivar</button>
    <br><br>
    <!--<form>-->   
<!--        <table class="table table-hover">
            <thead>
                <tr>  
                    <th>Nome</th>
                    <th>Assunto</th>
                    <th>Data</th> 
                </tr>
            </thead>
            <tbody>-->
    <div class="panel-group col-lg-11" id="accordion">
        <?php
        $params = array(
            'mode' => 'Sliding',
            'perPage' => 5,
            'dela' => 2,
            'itemData' => $this->getItem());

        $pager = & Pager::factory($params);
        $data = $pager->getPageData();
        Sessao::gerarToken();

        foreach ($data as $mensagem) {
            ?>
                <!--        <tr>-->
            <div class="panel panel-default">
                
                <?php
                    if ($mensagem->getStatus() == nova){
                ?>
                        <div class="panel-heading">
                <?php
                    }else{
                ?>
                       <div class="panel-body">     
                <?php            
                    }
                ?>
<!--                    <div class="panel-title">   -->
                        <input type="checkbox" id="selecoes_<?php echo $mensagem->getId(); ?>" name="selecoes[]" value=<?php echo $mensagem->getId(); ?>> 
                        <strong>
                        <?php
                        echo "<a data-toggle=collapse data-parent=#accordion href=#collapse" . $mensagem->getId() . ">";
                        echo $mensagem->getAnuncio()->getTituloAnuncio();
                        ?>          
                        </a>
                        </strong>
<!--                        <div class="text-right">-->
<span class="text-right" >
    <strong>
                        <?php
                            echo $mensagem->getDatahora();
                        ?>
<!--                        </div>-->
                        </strong>
</span>
<!--                    </div>-->
<!--                    <h4 class="panel-title text-right">
                        <strong>
                        <?php
                            echo $mensagem->getDatahora();
                        ?>
                        </strong>
                    </h4>    -->
                </div>  
                <?php echo "<div id=collapse" . $mensagem->getId() . " class='panel-collapse collapse'>"; ?>
                <div class="panel-body">
                    <?php echo $mensagem->getMensagem(); ?>
                    <br><br>
                    <address>
                        <strong><?php echo $mensagem->getNome(); ?></strong><br>
                        <abbr title="Telefone">Tel:</abbr> <?php echo $mensagem->getTelefone(); ?><br>
                        <a href="mailto:#"><?php echo $mensagem->getEmail(); ?></a>
                    </address>                  
                    <?php
                    $listRespostas = $mensagem->getRespostamensagem();
                    foreach ($listRespostas as $resposta) { ?>
                        <hr style="border-top: 1px solid #A31616">                         
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><abbr title="Resposta">RES:</abbr></strong>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $resposta->getResposta(); ?><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enviado em:<?php echo $resposta->getDatahora(); ?>
                        <br>
                        <?php
                    }
                    ?>                        
                    <br>               
                    <button type="button" value=" <?php echo $mensagem->getId(); ?>" id="btnResponder<?php echo $mensagem->getAnuncio()->getImovel()->Referencia(); ?>" class="btn btn-default btn-sm">
                        Responder
                    </button>  
                    <button type="button" id="btnAnuncioModal<?php echo $mensagem->getAnuncio()->getImovel()->Referencia(); ?>" class="btn btn-default btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $mensagem->getAnuncio()->getId(); ?>" data-title="<?php echo $mensagem->getAnuncio()->getTituloAnuncio(); ?>">
                        Visualizar Anúncio
                    </button>   
                </div>
            </div>
        </div>
        <?php
    }
    ?>             
    <!--        </tr>         
                </tbody>
            </table>
            &nbsp;-->
</div>
<?php
$links = $pager->getLinks();
echo ($links['all'] != "" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: " . $links['all'] : "");
?>

<!-- Divs ocultas que serao exibidas dentro do popover. -->

<!--</form>-->
<!--</div>-->

</div>

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

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('[id^=txtMensagem]').hide();
        $('[id^=btnEnviar]').hide();

        $('[id^=btnAnuncioModal]').click(function() {
            $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
            $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
            $("#modal-body").load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'modal', hdnToken: '<?php //Sessao::gerarToken(); echo $_SESSION["token"];    ?>', hdnModal: $(this).attr('data-modal')});
        })
        $('[id^=btnResponder]').click(function() {
            $("<textarea maxlength=200 id=txtMensagem name=txtMensagem class=form-control rows=7></textarea>").insertBefore($(this));
            $("<button id=btnEnviar class=btn btn-primary value=" + $(this).attr("value") + ">Enviar</button>").insertBefore($(this)); //this
            $('[id^=btnResponder]').attr("disabled", "disabled");
            $('[id^=btnEnviar]').click(function() {
                responderMensagem($(this));
            })
        });
           
        $('.collapse').on('hidden.bs.collapse', function() {
            $('[id^=txtMensagem]').remove();
            $('[id^=btnEnviar]').remove();
            $('[id^=btnResponder]').removeAttr("disabled");
        })
        
        $("input[id^='selecoes_']").click(function() {
            $('[id^=arquivar]').insertBefore("<input type=hidden id=itens[] name=itens[] value=" + $(this).val() + ">");
        });
        $('#arquivar').click(function() {
                //arquivarMensagem();
        });
    
        function arquivarMensagem()
        {
            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: {
                    msg: $('[id^=selecoes_]').val(),
                    hdnEntidade: "Usuario",
                    hdnAcao: "arquivarMensagem"
                },
                beforeSend: function() {

                },
                success: function(resposta) {
                    $("#msgContato").remove();
                    var msgContato = $("<div>", {id: "msgContato"});
                    if (resposta.resultado == 0) {
                        msgContato.attr('class', 'alert alert-danger').html("Falha ao enviar mensagem!").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    } else {
                        $("<p>" + $("[id^=txtMensagem]").val() + "</p>").insertBefore(elemento);
                        $('[id^=txtMensagem]').remove();
                        $('[id^=btnEnviar]').remove();
                        $('[id^=btnResponder]').removeAttr("disabled");
                        msgContato.attr('class', 'alert alert-success').html("Mensagem enviada com sucesso!").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    }
                    $("#alertCEP").append(msgContato);
                }
            })
        }
    
        function responderMensagem(elemento)
        {
            $.ajax({
                url: "index.php",
                dataType: "json",
                type: "POST",
                data: {
                    id: $(elemento).attr("value"),
                    msg: $('[id^=txtMensagem]').val(),
                    hdnEntidade: "Usuario",
                    hdnAcao: "responderMensagem"
                },
                beforeSend: function() {

                },
                success: function(resposta) {
                    $("#msgContato").remove();
                    var msgContato = $("<div>", {id: "msgContato"});
                    if (resposta.resultado == 0) {
                        msgContato.attr('class', 'alert alert-danger').html("Falha ao enviar mensagem!").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    } else {
                        $("<p>" + $("[id^=txtMensagem]").val() + "</p>").insertBefore(elemento);
                        $('[id^=txtMensagem]').remove();
                        $('[id^=btnEnviar]').remove();
                        $('[id^=btnResponder]').removeAttr("disabled");
                        msgContato.attr('class', 'alert alert-success').html("Mensagem enviada com sucesso!").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    }
                    $("#alertCEP").append(msgContato);
                }
            })
        }
    });
</script>

