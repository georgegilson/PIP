<!-- fotorama.css & fotorama.js. -->
<link  href="assets/css/fotorama.css" rel="stylesheet"> 
<script src="assets/js/fotorama.js"></script> 
<!-- fotorama.css & fotorama.js. -->
<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/jquery.maskedinput.min.js"></script>
<?php
$item = $this->getItem();
$anuncio = $item["anuncio"][0];
$imovel = $item["imovel"][0];
$endereco = $item["endereco"][0];
$usuario = $item["usuario"][0];
$imagens = $item["imagem"];
//echo "<pre>";print_r($imagens);die();
?>
<ul id="myTab" class="nav nav-pills ">
    <li class="active"><a href="#detalhes" data-toggle="tab">Detalhes</a></li>
    <?php if ($anuncio->getPublicarmapa() == "SIM") { ?>
        <li><a href="#vernomapa" data-toggle="tab">Ver no Mapa</a></li>
    <?php } ?>
    <li><a href="#contato" data-toggle="tab">Contato</a></li>
    <li><a href="#diferenciais" data-toggle="tab">Diferenciais</a></li>
    <li class="navbar-right">
        <h4><?php echo $anuncio->getTituloAnuncio(); ?> <span class="label label-info"><?php echo $imovel->Referencia() ?></span></h4></li>
</ul>

<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="detalhes">
        <script src="assets/js/gridforms.js"></script>
        <form class="grid-form">
            <div class="row">
                <div class="col-xs-8">
                    <div class="fotorama" data-nav="thumbs" data-fit="cover" data-width="100%" data-height="300px">
                        <?php foreach ($imagens as $imagem) { ?>
                            <a href="<?php echo $imagem->getDiretorio(); ?>" data-caption="<?php echo $imagem->getLegenda(); ?>" data-thumb="<?php echo $imagem->miniatura(); ?>"></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div data-row-span="1">
                        <div data-field-span="1">

                            <?php echo $anuncio->getDescricaoanuncio(); ?>
                        </div>
                    </div>
                    <div data-row-span="2">
                        <div data-field-span="1">
                            <label>Finalidade</label>
                            <span class="label label-primary"> <?php echo $imovel->getFinalidade(); ?> </span>
                        </div>
                        <div data-field-span="1">
                            <label>Tipo</label>
                            <span class="label label-warning"> <?php echo $imovel->getTipo(); ?> </span>
                        </div>
                    </div>
                    <div data-row-span="2">
                        <div data-field-span="1">
                            <label>Condição</label>
                            <?php echo $imovel->getCondicao(); ?>
                        </div>

                        <div data-field-span="1">
                            <label>Valor</label>
                            R$ <?php echo $anuncio->getValor(); ?>
                        </div>
                    </div>                    

                    <div data-row-span="2">
                        <div data-field-span="1">
                            <label>Quartos</label>
                            <?php echo $imovel->getQuarto(); ?>
                        </div>
                        <div data-field-span="1">
                            <label>Banheiros</label>
                            <?php echo $imovel->getBanheiro(); ?>
                        </div>
                    </div> 
                    <div data-row-span="3">
                        <div data-field-span="1">
                            <label>Área</label>
                            <?php echo $imovel->getArea(); ?> m<sup>2</sup>
                        </div>
                        <div data-field-span="1">
                            <label>Suítes</label>
                            <?php echo $imovel->getSuite(); ?>
                        </div>
                        <div data-field-span="1">
                            <label>Garagem</label>
                            <?php echo $imovel->getGaragem(); ?>
                        </div>
                    </div> 
                    <div data-row-span="1">
                        <div data-field-span="1">
                            <label>Localizado em <?php echo $endereco->getCidade()->getNome(); ?>
                                <?php echo "/"; ?>
                                <?php echo $endereco->getEstado()->getUf(); ?></label>
                            <?php echo $endereco->getLogradouro(); ?>
                            <?php echo "nº " . $endereco->getNumero(); ?>
                            <?php echo $endereco->getComplemento(); ?>
                            <?php echo $endereco->getBairro()->getNome(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php if ($anuncio->getPublicarmapa() == "SIM") { ?>
        <div class="tab-pane fade" id="vernomapa">
            <div class="row">
                <div class="col-xs-12">
                    <div class="popin">
                        <div id="mapaModal"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form class="grid-form">
                    <div class="col-xs-12">
                        <div data-row-span="5">
                            <div data-field-span="1">
                                <label>Logradouro</label>
                                <?php echo $endereco->getLogradouro(); ?>
                            </div>
                            <div data-field-span="1">
                                <label>Número</label>
                                <?php echo $endereco->getNumero(); ?>
                            </div>
                            <div data-field-span="1">
                                <label>Bairro</label>
                                <?php echo $endereco->getBairro()->getNome(); ?>
                            </div>
                            <div data-field-span="1">
                                <label>Cidade</label>
                                <?php echo $endereco->getCidade()->getNome(); ?>
                                <?php echo " - "; ?>
                                <?php echo $endereco->getEstado()->getUf(); ?>
                            </div>
                            <div data-field-span="1">
                                <label>Complemento</label>
                                <?php echo $endereco->getComplemento(); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- INICIO DO MAPA --> 
        <script>
            $(document).ready(function() {
                map = new GMaps({
                    div: '#mapaModal',
                    lat: 0,
                    lng: 0,
                    width: '100%',
                    height: '300px'
                });
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    if (e.target.hash == "#vernomapa") {
                        var endereco = "<?php echo $endereco->enderecoMapa(); ?>";
                        GMaps.geocode({
                            address: endereco.trim(),
                            callback: function(results, status) {
                                //                        console.log(results);
                                //                        console.log(status);
                                if (status == 'OK') {
                                    var latlng = results[0].geometry.location;
                                    map = new GMaps({
                                        div: '#mapaModal',
                                        lat: 0,
                                        lng: 0,
                                        width: '100%',
                                        height: '300px'
                                    });
                                    //                            console.log(map);
                                    map.setCenter(latlng.lat(), latlng.lng());
                                    map.addMarker({
                                        lat: latlng.lat(),
                                        lng: latlng.lng()
                                    });
                                }
                            }
                        });
                    }
                })
            });
        </script>    

        <!-- FIM DO MAPA --> 
    <?php } ?>
    <div class="tab-pane fade" id="contato">
        <div class="row">
            <div class="col-xs-10">

                <div id="alert" class="col-xs-10"></div>

                <form id="contato" class="form-horizontal">
                    <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                    <input type="hidden" id="hdnAcao" name="hdnAcao" value="enviarContato" />
                    <input type="hidden" id="hdnIdAnuncio" name="hdnIdAnuncio" value= "<?php echo $anuncio->getId() ?> "/>
                    <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value= "<?php echo $usuario->getId() ?>" />
                    <br>
                    <div class="form-group">
                        <label class="col-xs-3 control-label" for="txtNome">Nome</label>
                        <div class="col-xs-5">
                            <input id="txtNome" name="txtNome" class="form-control" placeholder="Informe seu nome">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtEmail">Email</label>
                        <div class="col-lg-5">
                            <input id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe seu email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtTelefone">Telefone</label>
                        <div class="col-lg-3">
                            <input id="txtTelefone" name="txtTelefone" class="form-control" placeholder="Informe seu telefone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtMensagem">Mensagem</label>
                        <div class="col-lg-5">
                            <textarea maxlength="200" id="txtMensagem" name="txtMensagem" class="form-control" placeholder="Informe a mensagem" rows="7"> </textarea><br />            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" id="btnAnuncioModal" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>                
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="diferenciais">
        <div class="row">
            <div class="col-xs-12">
                <div data-row-span="12">
                    <?php
                    //valores visiveis
                    $valoresVisiveis = $anuncio->getValorvisivel();
                    if ($valoresVisiveis != "") {
                        $valoresVisiveis = (json_decode($valoresVisiveis));
                        foreach ($valoresVisiveis as $campo) {
                            ?>
                            <div data-field-span="1">
                                <label><?php echo $campo; ?></label>
                                <span class="glyphicon glyphicon-compressed"></span>
                                <?php
                                //$get = "get" . ucfirst($campo);
                                //echo $imovel->$get();
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
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
        $("#contato").submit(function(e) {
            e.preventDefault();
            //$form = $(this);
//           $post(document.location.url, $(this).serialize(), function(data){
            $.ajax({
                url: document.location.url,
                dataType: "json",
                type: "POST",
                data: {
                    hdnEntidade: "Anuncio",
                    hdnAcao: "enviarContato",
                    nome: $('#txtNome').val(),
                    email: $('#txtEmail').val(),
                    telefone: $('#txtTelefone').val(),
                    mensagem: $('#txtMensagem').val(),
                    idusuario: $('#hdnIdUsuario').val(),
                    idanuncio: $('#hdnIdAnuncio').val()
                },
                success: function(resposta) {
                    $("#msg").remove();
                    var msg = $("<div>", {id: "msg"});
                    if (resposta.resultado == 0) {
                        msg.attr('class', 'alert alert-success').html("Mensagem enviada com sucesso").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    } else {
                        msg.attr('class', 'alert alert-danger').html("Falha no envio da mensagem, por favor tente mais tarde").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    }
                    $("#alert").append(msg);
                    $('#txtNome').val('');
                    $('#txtEmail').val('');
                    $('#txtTelefone').val('');
                    $('#txtMensagem').val('');
                }
            });

        });
    })
</script>