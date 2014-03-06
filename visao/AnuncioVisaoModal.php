<!-- INICIO DO MAPA --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/jquery.maskedinput.min.js"></script>

<!-- FIM DO MAPA --> 
<?php
$item = $this->getItem();
$anuncio = $item["anuncio"][0];
$imovel = $item["imovel"][0];
$endereco = $item["endereco"][0];
$usuario = $item["usuario"][0];
//echo "<pre>";print_r($item);die();
?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#detalhes" data-toggle="tab">Detalhes</a></li>
    <li><a href="#vernomapa" data-toggle="tab">Ver no Mapa</a></li>
    <li><a href="#contato" data-toggle="tab">Contato</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="detalhes">
        <script src="assets/js/gridforms.js"></script>
        <div class="row">
            <div class="col-xs-8">
                foto
            </div>
            <div class="col-xs-4">
                <form class="grid-form">
                    <div data-row-span="1">
                        <div data-field-span="1">
                            <label>Descrição</label>
                            <?php echo $anuncio->getDescricaoanuncio(); ?>
                        </div>
                    </div>

                    <?php
                    //valor do anuncio
                    if ($anuncio->getValor() != "") {
                        ?>
                        <div data-row-span="1">
                            <div data-field-span="1">
                                <label>Valor</label>
                                R$ <?php echo $anuncio->getValor(); ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    //valores visiveis
                    $valoresVisiveis = $anuncio->getValorvisivel();
                    if ($valoresVisiveis != "") {
                        $valoresVisiveis = (json_decode($valoresVisiveis));
                        foreach ($valoresVisiveis as $campo) {
                            if ($campo != "multiselect-all") {
                                ?>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label><?php echo $campo; ?></label>
                                        <?php
                                        $get = "get" . ucfirst($campo);
                                        echo $imovel->$get();
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Localização</div>

                    <?php if ($anuncio->getPublicarmapa() == "SIM") { ?>
                        <div class="popin">
                            <div id="map"></div>
                        </div>
                    <?php } else { ?>
                        so endereço
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="vernomapa">

        <div class="row">
            <div class="col-xs-10">
                <div id="divalert">
                    <div class="col-sx-2">
                        <div class="text-right" id="divimg">
                        </div>
                    </div>
                    <div class="col-sx-8" id="divmsg">
                    </div>
                </div>
                <div class="alert"></div>
        <div class="row">
            <div class="col-xs-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Localização</div>

                    <?php if ($anuncio->getPublicarmapa() == "SIM") { ?>
                        <div class="popin">
                            <div id="map"></div>
                        </div>
                    <?php } else { ?>
                        so endereço
                    <?php } ?>
                </div>
            </div>
        </div>
           
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="contato">

        <div class="row">
            <div class="col-xs-10">
                <div id="divalert">
                    <div class="col-sx-2">
                        <div class="text-right" id="divimg">
                        </div>
                    </div>
                    <div class="col-sx-8" id="divmsg">
                    </div>
                </div>
                <div class="alert"></div>

                <form id="form2" class="form-horizontal">
            <!--        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarContato" />
                    <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />-->

                    <br>
                    <div class="form-group">
                        <label class="col-xs-3 control-label" for="txtNome">Nome</label>
                        <div class="col-xs-9">
                            <input id="txtNome" name="txtNome" class="form-control" placeholder="Informe a nova senha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtEmail">Email</label>
                        <div class="col-lg-9">
                            <input id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe a nova senha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtTelefone">Telefone</label>
                        <div class="col-lg-9">
                            <input id="txtTelefone" name="txtTelefone" class="form-control" placeholder="Informe a nova senha">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtMensagem">Mensagem</label>
                        <div class="col-lg-9">
                            <textarea maxlength="100" id="txtMensagem" name="txtMensagem" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea><br />            </div>
                    </div>

                    <div class="row" id="divlinha3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="button" id="btnAnuncioModal" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>                
                        </div>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.alert').hide();
        $('#divalert').hide();
        $('#txtMensagem').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });
        $("#txtTelefone").mask("(99)9999-9999");
        $("#btnAnuncioModal").click(function() {
            //alert("teste");
            $("#contato").load("index.php", {hdnEntidade: 'Anuncio', hdnAcao: 'enviarContato', hdnToken: '<?php //Sessao::gerarToken(); echo $_SESSION["token"];  ?>', hdnModal: $("#form2")});
        })
    })
</script>


<script>
    $(document).ready(function() {
        var endereco = "<?php echo $endereco->enderecoMapa(); ?>";
        //######### INICIO DO CEP ########
        map = new GMaps({
            div: '#map',
            lat: 0,
            lng: 0
        });
        GMaps.geocode({
            address: endereco.trim(),
            callback: function(results, status) {
                console.log(map);
                if (status == 'OK') {
                    var latlng = results[0].geometry.location;
                    map.setCenter(latlng.lat(), latlng.lng());
                    map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });
                }
            }
        });
    });

</script>