<?php
$item = $this->getItem();
if ($item == null) {
    echo '<h2 class="text-center text-danger">Ops! <br> O link desse anuncio não &eacute; v&aacute;lido. <br> Ou n&atilde;o est&aacute; mais dispon&iacute;vel.<br>Tente novamente.</h2>';
} else {
    ?>
    <!-- fotorama.css & fotorama.js. -->
    <link  href="assets/css/fotorama.css" rel="stylesheet"> 
    <script src="assets/js/fotorama.js"></script> 
    <!-- fotorama.css & fotorama.js. -->
    <script src="assets/js/bootstrap-maxlength.js"></script>
    <script src="assets/js/jquery.maskedinput.min.js"></script>
    <script src="assets/js/util.validate.js"></script>
    <script src="assets/js/jquery.price_format.min.js"></script>
    <?php
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
        <li><a href="#diferenciais" data-toggle="tab">Diferenciais</a></li>
        <?php if ($anuncio->getStatus() == "cadastrado") { ?>
            <li><a href="#contato" data-toggle="tab">Fale com o Vendedor</a></li>
        <?php } ?>    
        <li class="navbar-right">
            <h4><?php echo $anuncio->getTituloAnuncio(); ?> <span class="label label-info"><?php echo $imovel->Referencia() ?></span></h4></li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="detalhes">

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
                                <span class="label label-primary"> <?php echo $anuncio->getFinalidade(); ?> </span>
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
                                <span id="spanValor"><?php echo $anuncio->getValor(); ?></span>
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

        <!--        <div class="tab-pane fade" id="contato">
        
                    <div class="row">
                        <div class="col-xs-10">
        
                            <div id="alert" class="col-xs-10"></div>
        
                            <form id="formContato" class="form-horizontal">
                                <input type="hidden" id="hdnIdAnuncio" name="hdnIdAnuncio" value= "<?php echo $anuncio->getId() ?> "/>
                                <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value= "<?php echo $usuario->getId() ?>" />
                                <div id="forms" class="panel panel-default">
                                    <br>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" for="txtNome">Nome</label>
                                        <div class="col-xs-7">
                                            <input id="txtNome" name="txtNome" class="form-control" placeholder="Informe seu nome" >
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
                                </div>
        
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">
                                                <button type="submit" id="btnEnviarContato" class="btn btn-primary">Enviar</button>
                                            </div>
                                        </div>                
                                    </div>
                                </div>
        
        
                            </form>
                        </div>
        
                    </div>
                </div>-->
        <!--<div class="tab-pane fade" id="contato" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" aria-hidden="true">-->
        <div class="tab-pane fade" id="contato">

            <!--  <div class="modal-dialog">-->
            <!--    <div class="modal-content col-sm-8">-->
            <form role="form" id="formContato">
                <input type="hidden" id="hdnIdAnuncio" name="hdnIdAnuncio" value= "<?php echo $anuncio->getId() ?> "/>
                <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value= "<?php echo $usuario->getId() ?>" />
                <!--      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Enviar Anúncio</h4>
                      </div>-->
                <div class="modal-body text-left col-xs-7">
                    <!--      <div class="modal-body">-->
                    <!--          <div id="alert" role="alert" class="alert alert-warning">
                                          Preencha os dados abaixo para realizar o envio, por e-mail, dos anúncios selecionados. 
                                        </div>-->
                    <!--        <form role="form" id="formEmail">-->
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Nome:</label>            
                        <input type="text" class="form-control" id="txtNome">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">E-mail:</label>
                        <input type="text" class="form-control" id="txtEmail" name="txtEmail">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Telefone:</label>
                        <input type="text" class="form-control" id="txtTelefone" name="txtTelefone">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Mensagem:</label>
                        <textarea maxlength="200" class="form-control" id="txtMensagem"></textarea>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>    
                    <button type="submit" id="btnEnviarEmailAnuncio" class="btn btn-primary">Enviar</button>

                </div>
                <div class="modal-body text-right col-xs-4">
                    <div data-row-span="7">
                        <div data-field-span="3">
                            <label style="text-align: left">Nome:</label>
                            <?php echo "<span class='label label-info'>" . strtoupper($usuario->getNome()) . "</span>"; ?>
                        </div>
                        <div data-field-span="2">
                            <label style="text-align: center">Contatos:</label>
                            <?php
                            if (is_array($usuario->getTelefone())) { //verifica se existe mais de um número de telefone cadastrado para o usuário 
                                foreach ($usuario->getTelefone() as $anuncioTelefone) {
                                    ?> 
                                    <?php
                                    echo "<span class='label label-primary'>" . strtoupper($anuncioTelefone->getOperadora()) . " - " . strtoupper($anuncioTelefone->getNumero()) . "</span>";
                                }
                                ?>
                        <?php } else echo "<span class='label label-primary'>" . strtoupper($usuario->getTelefone()->getOperadora()) . " - " . strtoupper($usuario->getTelefone()->getNumero()) . "</span>"; ?>
                        </div>
                        <?php
                        if ($usuario->getTipousuario() == "pj") {
                            echo '<div class = "col-lg-8" id = "divFotoImagem"> <br>';
//                            echo '<div id = "forms" class = "panel panel-default">';
                            if ($usuario->getFoto() != "") {
                                echo '<img src="'. PIPURL . '/fotos/usuarios/'. $usuario->getFoto() . '"  width="120" height="120" style="margin-left: 100px">';                             
                            } else { 
                                echo '<img src="' .PIPURL . '/assets/imagens/foto_padrao.png"  width="120" height="120" style="margin-left: 100px">';
                        } 

//                       echo '</div>';
                    echo '</div>';
                    }
                    ?>
            </div>
        </div>

        <div class="modal-footer">
            <!--        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnEnviarEmailAnuncio" class="btn btn-primary">Enviar</button>-->
        </div>

        </form>
        <!--    </div>
          </div>-->

        </div>


        <div class="tab-pane fade" id="diferenciais">
            <div class="row">

                <div class="col-xs-5">
                    <table class="table">
        <!--      <thead>
         <tr>
           <th>#</th>
           <th>Column heading</th>
           <th>Column heading</th>
           <th>Column heading</th>
         </tr>
        </thead>-->
                        <br>
                        <tbody>
                            <tr  <?php
                            if ($imovel->getAcademia() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?>>
                                <td>Academia</td>
                                <td><?php
                                    if ($imovel->getAcademia() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>
                            <tr <?php
                            if ($imovel->getAreaServico() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?>>
                                <td>Área de serviço</td>
                                <td><?php
                                    if ($imovel->getAreaServico() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>
                            <tr <?php
                            if ($imovel->getDependenciaEmpregada() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?>>
                                <td>Dependencia de empregada</td>
                                <td><?php
                                    if ($imovel->getDependenciaEmpregada() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>
                            <tr <?php
                            if ($imovel->getElevador() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?>>
                                <td>Elevador</td>
                                <td><?php
                                    if ($imovel->getElevador() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>
                            <tr <?php
                            if ($imovel->getPiscina() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?>>
                                <td>Piscina</td>
                                <td><?php
                                    if ($imovel->getPiscina() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>
                            <tr <?php
                            if ($imovel->getQuadra() == "SIM") {
                                print "class=success";
                            } else {
                                print "class=danger";
                            }
                            ?> >
                                <td>Quadra</td>
                                <td><?php
                                    if ($imovel->getQuadra() == "SIM") {
                                        print '<span class="glyphicon glyphicon-ok"></span>';
                                    } else {
                                        print '<span class="glyphicon glyphicon-remove"></span>';
                                    }
                                    ?></td>
                            </tr>

                        </tbody>
                    </table>
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
                            $("#spanValor").priceFormat({
                    prefix: 'R$ ',
                        centsSeparator: ',',
                            centsLimit: 0,
                    limit: 8,
                            thousandsSeparator: '.'
                })
                        $("#formContato").validate({
                        rules: {
                            txtNome: {
                            required: true
                        },
                    txtEmail: {
                        email: true,
                            required: true
                        },
                    txtMensagem: {
                            required: true
                        }
                    },
                    messages: {
                    txtNome: {
                    required: "Campo obrigatório"
                        },
                    txtEmail: {
                        required: "Campo obrigatório",
                            email: "Informe um email válido"
                        },
                        txtMensagem: {
                            required: "Campo obrigatório"
                        },
                    },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                    },
                        unhighlight: function(element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    },
                        errorElement: 'span',
                            errorClass: 'help-block',
                            errorPlacement: function(error, element) {
                            if (element.parent('.input-group').length) {
                                error.insertAfter(element.parent());
                                } else {
                                error.insertAfter(element);
                        }
                    }
                                });
                                $("#formContato").submit(function(e) {
                    e.preventDefault();
                                if ($("#formContato").valid())
                    {
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
                                            beforeSend: function() {
                                $("#alert").html(" ");
                                    $("#alert").html("...processando...").attr('class', 'alert alert-warning');
                                $('#btnEnviarContato').attr('disabled', 'disabled');
                                },
                                    success: function(resposta) {
                                $('#btnEnviarContato').removeAttr('disabled');
        //                        $("#msg").remove();
        //                        var msg = $("<div>", {id: "msg"});
                                    if (resposta.resultado == 0) {
                                    $("#alert").html(
                                "Email enviado com sucesso!").attr('class', 'alert alert-success');
                                //                            msg.attr('class', 'alert alert-success').html("Mensagem enviada com sucesso").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                                } else {
            //                            msg.attr('class', 'alert alert-danger').html("Falha no envio da mensagem, por favor tente mais tarde").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                                    $('.alert').html("Erro ao enviar e-mail. Tente novamente em alguns minutos.").attr('class', 'alert alert-danger');
                                }
        //                        $("#alert").append(msg);
                                $('#txtNome').val('');
                                $('#txtEmail').val('');
                                $('#txtTelefone').val('');
                                $('#txtMensagem').val('');
                            }
                        });
                    }
                });
            });
        </script>
    <?php } ?>