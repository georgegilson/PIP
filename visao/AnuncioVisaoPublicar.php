<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<script src="assets/js/wizard.js"></script>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/bootstrap-switch.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<!-- UPLOAD -->
<script src="assets/js/upload/jquery.ui.widget.js"></script>
<script src="assets/js/upload/tmpl.min.js"></script>
<script src="assets/js/upload/load-image.min.js"></script>
<script src="assets/js/upload/canvas-to-blob.min.js"></script>
<script src="assets/js/upload/jquery.iframe-transport.js"></script>
<script src="assets/js/upload/jquery.fileupload.js"></script>
<script src="assets/js/upload/jquery.fileupload-process.js"></script>
<script src="assets/js/upload/jquery.fileupload-image.js"></script>
<script src="assets/js/upload/jquery.fileupload-validate.js"></script>
<script src="assets/js/upload/jquery.fileupload-ui.js"></script>

<form id="fileupload" class="form-horizontal" enctype="multipart/form-data">
    <div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) -->
        <?php
        Sessao::gerarToken();
        $item = $this->getItem();
        if ($item) {
            foreach ($item["imovel"] as $objImovel) {
                $referencia = $objImovel->Referencia();
                $idImovel = $objImovel->getId();
                $tipoImovel = $objImovel->getTipo();
                $endereco = $objImovel->getEndereco()->enderecoMapa();
                $imovel = $objImovel;                
            }
        }
        ?>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Imóvel #<?php echo $referencia ?></h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                echo "Finalidade: " . $imovel->getFinalidade() . "<br />";
                                echo "Tipo: " . $imovel->getTipo() . "<br />";
                                echo "Descrição: " . $imovel->getDescricao() . "<br />";
                                echo "Quartos: " . $imovel->getQuarto() . "<br />";
                                echo "Garagen(s): " . $imovel->getGaragem() . "<br />";
                                echo "Banheiro(s): " . $imovel->getBanheiro() . "<br />";
                                echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
                                echo "Suite(s): " . (($imovel->getSuite() != "nenhuma") ? '<span class="text-primary">' . $imovel->getSuite() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Academia: " . (($imovel->getAcademia() == "SIM") ? '<span class="text-primary">' . $imovel->getAcademia() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Área Serviço: " . (($imovel->getAreaServico() == "SIM") ? '<span class="text-primary">' . $imovel->getAreaServico() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Dependencia de Empregada: " . (($imovel->getDependenciaEmpregada() == "SIM") ? '<span class="text-primary">' . $imovel->getDependenciaEmpregada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Elevador: " . (($imovel->getElevador() == "SIM") ? '<span class="text-primary">' . $imovel->getElevador() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Piscina: " . (($imovel->getPiscina() == "SIM") ? '<span class="text-primary">' . $imovel->getPiscina() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                echo "Quadra: " . (($imovel->getQuadra() == "SIM") ? '<span class="text-primary">' . $imovel->getQuadra() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                if ($tipoImovel == "apartamento") {
                                    echo "Sacada: " . (($imovel->getSacada() == "SIM") ? '<span class="text-primary">' . $imovel->getSacada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                    echo "Cobertura: " . (($imovel->getCobertura() == "SIM") ? '<span class="text-primary">' . $imovel->getCobertura() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                                    echo "Condomínio: " . (($imovel->getCondominio() != "") ? '<span class="text-primary">' . $imovel->getCondominio() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                                    echo "Andar: " . (($imovel->getAndar() != "") ? '<span class="text-primary">' . $imovel->getAndar() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                                }
                                ?>

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
        <div class="row">
            <div class="alert alert-warning">Aguarde Processando...</div>
            <div class="well wizard-example">
                <div id="MyWizard" class="wizard">
                    <ul class="steps">
                        <li data-target="#step1" class="active"><span class="badge badge-info">1</span>Início<span class="chevron"></span></li>
                        <li data-target="#step2"><span class="badge">2</span>Seu Anúncio<span class="chevron"></span></li>
                        <li data-target="#step3"><span class="badge">3</span>Fotos<span class="chevron"></span></li>
                        <li data-target="#step4"><span class="badge">4</span>Confirmação<span class="chevron"></span></li>
                        <li data-target="#step5"><span class="badge">5</span>Publicado!<span class="chevron"></span></li>
                    </ul>
                    <div class="actions">
                        <button data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm"> <span class="glyphicon glyphicon-home"> </span> Imóvel #<?php echo $referencia ?></button>
                        <button type="button" class="btn btn-warning btn-xs btn-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Anterior </button>
                        <button type="button" class="btn btn-primary btn-xs btn-next" data-last="Fim"> Próximo <span class="glyphicon glyphicon-chevron-right"></span></button>
                    </div>
                </div>

                <div class="step-content">
                    <div class="step-pane active" id="step1">
                        <div class="row">
                            <div class="col-lg-12">
                                <p> Aqui ficará alguma forma de introdução. Não sou bom com textos acho que o Departamento de Marketing pode dar uma força no sentido de produzir um texto legal. </p>
                                <p> Escolha o plano a ser utilizado no seu anúncio.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="sltPlano">Plano</label>
                                <div class="col-lg-4">
                                    <select class="form-control" id="sltPlano" name="sltPlano">
                                        <?php
                                        if ($item && count($item["usuarioPlano"]) > 0) {
                                            foreach ($item["usuarioPlano"] as $usuarioPlano) {
                                                ?>
                                                <option value="<?php echo $usuarioPlano->getId() ?>"><?php echo $usuarioPlano->getPlano()->getTitulo() . " (" . $usuarioPlano->getPlano()->getValidadepublicacao() . " dias) - Expira em: " . $usuarioPlano->DataExpiracao($usuarioPlano->getPlano()->getValidadeativacao()); ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value>Você ainda não possui planos ativos.</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <a href="index.php?entidade=Plano&acao=listar"> <img src="http://www.prospeccao-de-clientes.com/images/gudrum-pagseguro.gif" width="100%"/> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-pane" id="step2">
                        <input type="hidden" id="hdnId" name="hdnId" value=""/>
                        <input type="hidden" id="hdnIdImovel" name="hdnIdImovel" value="<?php echo $idImovel; ?>" />
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio" />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="Cadastrar" />
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="forms" class="panel panel-default">
                                    <div class="panel-heading">Informações Básicas </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtTitulo">Título</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Informe o Título" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtDescricao"> Descrição </label>
                                        <div class="col-lg-8">
                                            <textarea maxlength="150" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="txtValor">Valor</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="txtValor" name="txtValor" placeholder="Informe o Valor do Imóvel">
                                        </div>
                                        <span class="col-lg-4"> (Não informar os centavos) </span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="chkMapa"> Permitir a exibição do mapa?</label>
                                        <div class="col-lg-5">
                                            <input type="checkbox" name="chkMapa" value="SIM" checked="checked">                                             
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-6 control-label" for="sltCamposVisiveis">Exibir as Informações Cadastradas</label>
                                        <div class="col-lg-5">
                                            <select class="form-control" id="sltCamposVisiveis" name="sltCamposVisiveis[]" multiple=multiple>
                                                <optgroup label="Informações Básicas">...</optgroup>
                                                <option value="quarto">Quarto</option>
                                                <option value="garagem">Garagem</option>
                                                <option value="banheiro">Banheiro</option>
                                                <optgroup label="Informações Adicionais">...</optgroup>
                                                <?php if ($imovel->getAcademia() == "SIM") { ?><option value="academia">Academia</option> <?php } ?>
                                                <?php if ($imovel->getAreaServico() == "SIM") { ?><option value="areaservico">Área de Serviço</option> <?php } ?>
                                                <?php if ($imovel->getDependenciaEmpregada() == "SIM") { ?><option value="dependenciaempregada">Dependência de Empregada</option> <?php } ?>
                                                <?php if ($imovel->getElevador() == "SIM") { ?><option value="elevador">Elevador</option> <?php } ?>
                                                <?php if ($imovel->getPiscina() == "SIM") { ?><option value="piscina">Piscina</option> <?php } ?>
                                                <?php if ($imovel->getQuadra() == "SIM") { ?><option value="quadra">Quadra</option> <?php } ?>
                                                <option value="area">Área m2</option>
                                                <option value="suite">Suíte</option>
                                                <option value="descricao">Descrição</option>
                                                <?php if ($tipoImovel == "apartamento") { ?>
                                                <optgroup label="Informações Adicionais Apt.">...</optgroup>                                                
                                                    <?php if ($imovel->getAndar() != "") { ?><option value="andar">Andar</option> <?php } ?>                                                
                                                    <?php if ($imovel->getCondominio() != "") { ?><option value="condominio">Condominio</option> <?php } ?>                                                                                                    
                                                    <?php if ($imovel->getCobertura() == "SIM") { ?><option value="cobertura">Cobertura</option> <?php } ?>                                                
                                                    <?php if ($imovel->getSacada() == "SIM") { ?><option value="sacada">Sacada</option> <?php } ?> 
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="forms" class="panel panel-default">
                                    <div class="panel-heading">Mapa do Endereço Cadastrado</div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="popin">
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="step-pane" id="step3">
                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                        <noscript><input type="hidden" name="redirect" value="index.php"></noscript>
                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                        <div class="row fileupload-buttonbar">
                            <div class="col-lg-7">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Adicionar fotos...</span>
                                    <input type="file" name="files[]" multiple accept="image/png,image/jpeg,image/gif">
                                </span>
                                <!-- <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                                </button> -->
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancelar o envio de todas</span>
                                </button>
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Excluir fotos selecionadas</span>
                                </button>
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-lg-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <!-- The table listing the files available for upload/download -->
                        <div class="row">
                            <div class="col-lg-9">
                                <table role="presentation" class="table table-striped table-condensed table-responsive">
                                    <tbody class="files"></tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                    <div class="step-pane" id="step4">
                        <div class="row">
                            <h4>Confirme os dados informados:</h4>
                            <table class="table table-bordered table-condensed table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th>Imóvel</th>
                                        <th>Plano</th>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Mapa</th>
                                        <th>Informações Exibidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="colReferencia"><?php echo $referencia; ?></td>
                                        <td id="colPlano"></td>
                                        <td id="colTitulo"></td>
                                        <td id="colDescricao"></td>
                                        <td id="colValor"></td>
                                        <td id="colMapa"></td>
                                        <td id="colCampos"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <textarea class="form-control" rows="5"><?php include_once 'assets/txt/termo.php'; ?></textarea>
                        </div>
                        <div class="row text-center text-danger">
                            <p>   Aceito os termos do contrato e reconheço como verdadeiras as informações constantes nesse anuncio e desde logo,
                                responsabiliza-se integralmente pela veracidade e exatidão das informações aqui fornecidas, sob pena de incorrer nas sanções
                                previstas no art. 299 do Decreto Lei 2848/40 (Código Penal). </p>
                        </div>
                    </div>
                    <div class="step-pane" id="step5"></div>
                </div>
                <button id="btnWizardPrev" type="button" class="btn btn-warning btn-prev"> <span class="glyphicon glyphicon-chevron-left"></span> Voltar </button>
                <button id="btnWizardNext" type="button" class="btn btn-primary btn-next" data-last="Fim" > Avançar <span class="glyphicon glyphicon-chevron-right"></span></button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $('.alert').hide();

        // Associa o evento do popover ao clicar no link.
        $("#popover").popover({
            trigger: 'hover',
            html: true,
            placement: 'auto',
            content: $('#div-popover').html()
        }).click(function(e) {
            e.preventDefault();
            // Exibe o popover.
            $(this).popover('show');
        });


        $('#MyWizard').on('change', function(e, data) {
            if (data.direction === 'next') {
                if (data.step === 1) {
                    if (!$("#sltPlano").valid())
                        return e.preventDefault();
                }
                if (data.step === 2) {
                    if (!($("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
                        return e.preventDefault();
                }
                if (data.step === 3) {
                    if (typeof($("input[name^=txtLegenda]").val()) !== "undefined") {
                        alert("Você ainda não enviou todas as fotos. \n Clique no botão Enviar");
                        return e.preventDefault();
                    }
                    if (typeof($("input[name=delete]").val()) !== "undefined") {

                        if (typeof($("input[name=rdbCapa]:checked").val()) === "undefined") {
                            alert("Informe uma Foto para ser a capa do seu anúncio");
                            return e.preventDefault();
                        }
                    }
                }
                if (data.step === 4) {
                    if (($("#sltPlano").valid() & $("#txtTitulo").valid() & $("#txtDescricao").valid() & $("#txtValor").valid()))
                        $("#fileupload").submit();
                }
            }
        });
        $('#MyWizard').on('changed', function(e, data) {
            var item = $('#MyWizard').wizard('selectedItem');
            if (item.step === 2) {
                var endereco = "<?php echo $endereco; ?>";
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
            }
            if (item.step === 3) {
                $("#colReferencia").click(function() {
                    $('#myModal').modal('show');
                })

                $("#colPlano").html($("#sltPlano :selected").text());
                $("#colTitulo").html($("#txtTitulo").val());
                $("#colDescricao").html($("#txtDescricao").val());
                $("#colValor").html($("#txtValor").val());
                $("#colMapa").html((typeof($("input[name=chkMapa]:checked").val()) === "undefined"?"Não":"Sim"));
                var varCampos = new Array();
                $('#sltCamposVisiveis :selected').each(function() {
                    if ($(this).val() != "multiselect-all")
                        varCampos.push($(this).text());
                })
                if (varCampos.length > 0)
                    $("#colCampos").html("&bullet; " + varCampos.join("<br /> &bullet; "));
                else
                    $("#colCampos").html("Nenhum campo escolhido");

            }
        });
        //$('#MyWizard').on('finished', function(e, data) {
        //    console.log('finished');
        //});
        $('#btnWizardPrev').on('click', function() {
            $('#MyWizard').wizard('previous');
        });
        $('#btnWizardNext').on('click', function() {
            $('#MyWizard').wizard('next');
        });
        //$('#btnWizardStep').on('click', function() {
        //  var item = $('#MyWizard').wizard('selectedItem');
        //console.log(item.step);
        //});
        //$('#MyWizard').on('stepclick', function(e, data) {
        //    console.log('step' + data.step + ' clicked');
        //    if (data.step === 1) {
        //        // return e.preventDefault();
        //    }
        //});
        // optionally navigate back to 2nd step
        //$('#btnStep2').on('click', function(e, data) {
        //    $('[data-target=#step2]').trigger("click");
        //});

        $('#fileupload').validate({
            rules: {
                sltPlano: {
                    required: true
                },
                txtTitulo: {
                    required: true,
                    minlength: 5
                },
                txtDescricao: {
                    //required: true,
                    minlength: 10
                },
                txtValor: {
                    required: true
                },
                chkAceite: {
                    required: true
                }
            },
            messages: {
                chkAceite: {
                    required: "Obrigatório"
                }
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
            },
            submitHandler: function() {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: $('#fileupload').serialize(),
                    beforeSend: function() {
                        $('.alert').show();
                        $('button').attr('disabled', 'disabled');
                    },
                    success: function(resposta) {
                        $(".alert").hide();
                        if (resposta.resultado == 1) {
                            $("#step5").html('<div class="row text-success">\n\
    <h2 class="text-center">Obrigado!</h2>\n\
    <p class="text-center">O cadastro de seu anúncio foi concluído com sucesso. </p>\n\
    <p class="text-center">Em breve você receberá um e-mail confirmando a publicação do mesmo. </p>\n\
    <p class="text-center">Não perca tempo clique aqui e compre mais anúncios! </p>\n\
    <p class="text-center">Divulgue esse anuncio no Facebook </p>\n\
    </div>');
                        } else {
                            $("#step5").html('<div class="row text-danger">\n\
    <h2 class="text-center">Tente novamente mais tarde!</h2>\n\
    <p class="text-center">Houve um erro no processamento de cadastro. </p>\n\
    </div>');
                            $('button').removeAttr('disabled');
                        }
                    }
                })
                return false;
            }
        })

        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 150,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#txtTitulo').maxlength({
            alwaysShow: true,
            threshold: 50,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        $('#sltCamposVisiveis').multiselect({
            buttonClass: 'btn btn-default btn-sm',
            includeSelectAllOption: true
        });

        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            dropZone: null,
            pasteZone: null,
            autoUpload: false,
            url: 'index.php?upload=1',
            maxNumberOfFiles: 5,
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
            imageMaxWidth: 800,
            imageMaxHeight: 800,
            imageCrop: true
        }).on('fileuploadsubmit', function(e, data) {
            //data.formData = data.context.find(':input').serializeArray();
            data.formData = $("#fileupload").serializeArray();
        }).on('fileuploadcompleted', function(e, data) {
            $('input[type="radio"]').bootstrapSwitch('destroy');
            $('input[type="radio"]').bootstrapSwitch();
            $('input[type="radio"]').bootstrapSwitch('setOnLabel', 'Sim');
            $('input[type="radio"]').bootstrapSwitch('setOffLabel', 'Não');
            $('input[type="radio"]').bootstrapSwitch('setOffClass', 'danger');
            $('input[type="radio"]').on('switch-change', function() {
                $('input[type="radio"]').bootstrapSwitch('toggleRadioState');
            });
        })

        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function() {
            $(this).removeClass('fileupload-processing');
        }).done(function(result) {
            $(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
        });

        //SWITCH MAPA
        $('input[name="chkMapa"]').bootstrapSwitch();
        $('input[name="chkMapa"]').bootstrapSwitch('setOnLabel', 'Sim');
        $('input[name="chkMapa"]').bootstrapSwitch('setOffLabel', 'Não');
        $('input[name="chkMapa"]').bootstrapSwitch('setOffClass', 'danger');
        
        //MOEDA
        $('#txtValor').priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        });
    });
</script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <input type="text" id="txtLegenda[{%=file.name%}]" name="txtLegenda[{%=file.name%}]" placeholder="Informe a Legenda" class="form-control" />
        </td>    
        <td>
        <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <span class="glyphicon glyphicon-upload"></span>
                    Enviar
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar envio
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td style="vertical-align: middle;">
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
        <td style="vertical-align: middle;">
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td style="vertical-align: middle;">
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td style="vertical-align: middle;">
            <span class="legenda">{%=file.legenda%}</span>
        </td>
        <td style="vertical-align: middle;">
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td style="vertical-align: middle;">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <span class="glyphicon glyphicon-trash"></span>
                    Excluir
                </button>
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar envio
                </button>
            {% } %}
        </td>
        {% if (file.url) { %}
        <td style="vertical-align: middle;">
            <span class="size"><input type="radio" name="rdbCapa" value="{%=file.name%}" data-text-label="Destaque?" /></span>
        </td>
        {% } %}
    </tr>
{% } %}
</script>