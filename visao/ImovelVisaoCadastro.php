<!-- INICIO DO MAPA --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<!-- FIM DO MAPA --> 
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>
<script>
    $(document).ready(function() {

        $("#divApartamento").hide(); //oculta campos exclusivos do apartamento 
        $("#txtArea").attr("maxlength", 0);
        $("#sltTipo").change(function() {
            $("#txtArea").val("");
            if ($(this).val() == "casa") {
                $("#divApartamento").fadeOut('slow'); //oculta campos exclusivos do apartamento 
                $("#txtArea").attr("maxlength", 4);
            } else if ($(this).val() == "terreno") {
                $("#divApartamento").fadeOut('slow'); //oculta campos exclusivos do apartamento 
                $("#txtArea").attr("maxlength", 5);
            } else {
                $("#divApartamento").fadeIn('slow'); //mostra campos exclusivos do apartamento
                $("#txtArea").attr("maxlength", 3);
                condicaoEmConstrucao();
            }
        })
        $("#sltCondicao").change(function() {
            condicaoEmConstrucao();
        })

        function condicaoEmConstrucao() {
            if ($("#sltCondicao").val() == "construcao") {
                $("#divAndar").fadeOut('slow'); //oculta campo andar
                $("#divCondominio").fadeOut('slow'); //oculta campo condominio
                $("#divCobertura").fadeOut('slow'); //oculta campo cobertura
            } else {
                $("#divAndar").fadeIn('slow'); //mostra campo andar
                $("#divCondominio").fadeIn('slow'); //mostra campo condominio
                $("#divCobertura").fadeIn('slow'); //mostra campo cobertura
            }
        }

        $("#map").hide(); //oculta campos do mapa
        $("#txtCEP").mask("99.999-999"); //mascara
        $("#divCEP").hide(); //oculta campos do DIVCEP
        $("#btnCEP").click(function() {
            buscarCep();
        });
        //MOEDA
        $('#txtCondominio').priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        });

        $("#txtCEP").blur(function() {
            buscarCep()
        });
        $("#btnCadastrar").click(function() {
            $("#form").submit();
        });
        $("#btnCancelar").click(function() {
            if (confirm("Deseja cancelar o cadastro do imóvel?")) {
                location.href = "index.php?entidade=Usuario&acao=meuPIP";
            }
        });
        $("#btnConfirmar").click(function() {
            if ($("#form").valid()) {
                if ($("#hdnCEP").val() != "") {
                    //chama modal de confirmacao    
                    carregaDadosModal($("div[class='modal-body']"));
                    $('#myModal').modal('show');
                } else {
                    $("#msgCEP").remove();
                    var msgCEP = $("<div>", {id: "msgCEP"});
                    msgCEP.attr('class', 'alert alert-danger').html("Primeiro faça a busca do CEP").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    $("#alertCEP").append(msgCEP);
                }
            }
        });

        function carregaDadosModal($div) {
            $div.html("");
            $div.append("Tipo: " + $("#sltTipo").val() + "<br />");
            $div.append("Condição: " + $("#sltCondicao").val() + "<br />");
            $div.append("Descrição: " + $("#txtDescricao").val() + "<br />");
            $div.append("Quartos: " + $("#sltQuarto").val() + "<br />");
            $div.append("Garagen(s): " + $("#sltGaragem").val() + "<br />");
            $div.append("Banheiro(s): " + $("#sltBanheiro").val() + "<br />");
            $div.append("Área: " + $("#txtArea").val() + "m<sup>2</sup><br />");
            $div.append("Suite(s): " + $("#sltSuite").val() + "<br />");

            var varCampos = new Array();
            $('#sltDiferencial :selected').each(function() {
                if ($(this).val() != "multiselect-all")
                    varCampos.push($(this).text());
            })
            if (varCampos.length > 0)
                $div.append("Diferenciais: " + varCampos.join(", ") + "<br />");

            if ($("#sltTipo").val() == "apartamento") {
                $div.append("Sacada: " + (typeof($("#chkSacada:checked").val()) === "undefined" ? "Não" : "Sim") + "<br />");
                $div.append("Cobertura: " + (typeof($("#chkCobertura:checked").val()) === "undefined" ? "Não" : "Sim") + "<br />");
                $div.append("Condomínio: " + $("#txtCondominio").val() + "<br />");
                $div.append("Andar: " + $("#sltAndar").val() + "<br />");
            }
        }

        function buscarCep() {
            var validator = $("#form").validate();
            if (validator.element("#txtCEP")) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        cep: $('#txtCEP').val(),
                        hdnEntidade: "Endereco",
                        hdnAcao: "buscarCEP"
                    },
                    beforeSend: function() {
                        $("#msgCEP").remove();
                        var msgCEP = $("<div>", {id: "msgCEP", class: "alert alert-warning"}).html("...aguarde buscando CEP...");
                        $("#divCEP").fadeOut('slow'); //oculta campos do DIVCEP
                        $("#map").fadeOut('slow'); //oculta campos do mapa
                        $("#alertCEP").append(msgCEP);
                        $('#txtCEP').attr('disabled', 'disabled');
                        $('#btnCEP').attr('disabled', 'disabled');
                        $('#txtEstado').val('');
                        $('#txtCidade').val('');
                        $('#txtBairro').val('');
                        $('#txtLogradouro').val('');
                        $('#hdnCEP').val('');
                    },
                    success: function(resposta) {
                        $("#msgCEP").remove();
                        var msgCEP = $("<div>", {id: "msgCEP"});
                        if (resposta.resultado == 0) {
                            msgCEP.attr('class', 'alert alert-danger').html("N&atilde;o localizamos o CEP informado").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                        } else {
                            msgCEP.attr('class', 'alert alert-success').html("CEP Localizado, o mapa ser&aacute carregado").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                            $("#divCEP").fadeIn('slow'); //mostra campos do DIVCEP
                            $("#map").fadeIn('slow'); //mostra campos do mapa
                            $('#txtEstado').val(resposta.uf);
                            $('#txtCidade').val(resposta.cidade);
                            $('#txtBairro').val(resposta.bairro);
                            $('#txtLogradouro').val(resposta.logradouro);
                            $('#hdnCEP').val($('#txtCEP').val());

                            //var endereco = $('#txtCEP').val() + resposta.logradouro + ', ' + $('#num').val() + ', ' + resposta.bairro + ', ' + resposta.cidade + ', ' + ', ' + resposta.uf;
                            var endereco = 'Brazil, ' + resposta.uf + ', ' + resposta.cidade + ', ' + resposta.bairro + ', ' + resposta.logradouro;
                            //######### INICIO DO CEP ########
                            map = new GMaps({
                                div: '#map',
                                lat: 0,
                                lng: 0
                            });
                            GMaps.geocode({
                                address: endereco.trim(),
                                callback: function(results, status) {
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
                        $("#alertCEP").append(msgCEP); //mostra resultado de busca cep
                        $('#txtCEP').removeAttr('disabled');
                        $('#btnCEP').removeAttr('disabled');
                    }
                })
            }
        }

        //######### FIM DO CEP ########

        //######### CAMPOS DO FORMULARIO ########
        $('#sltDiferencial').multiselect({
            buttonClass: 'btn btn-default btn-sm',
            includeSelectAllOption: true
        });

        $('#txtDescricao').maxlength({
            alwaysShow: true,
            threshold: 100,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: 'Voc&ecirc; digitou ',
            postText: ' caracteres permitidos.',
            validate: true
        });

        //######### VALIDACAO DO FORMULARIO ########
        $('#form').validate({
            rules: {
                txtValor: {
                    minlength: 1,
                    maxlength: 15,
                    required: true
                },
                sltQuarto: {
                    required: true
                },
                sltTipo: {
                    required: true
                },
                sltGaragem: {
                    required: true
                },
                sltBanheiro: {
                    required: true
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
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
            submitHandler: function(form) {
                form.submit();
            }
        });
    })

</script>
<?php
Sessao::gerarToken();
?>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Cadastrar Im&oacute;veis</h1>
    </div>
    <!-- Alertas -->
    <div class="alert">Preencha os campos abaixo</div>
    <!-- form -->
    <form id="form" class="form-horizontal" action="index.php" method="post">
        <input type="hidden" id="hdnId" name="hdnId" />
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
        <input type="hidden" id="hdnCEP" name="hdnCEP" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
        <!-- Primeira Linha -->        
        <div class="row">
            <div class="col-lg-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Informações Básicas </div>
                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltTipo">Tipo de Imóvel</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltTipo" name="sltTipo">
                                <option value="">Informe o Tipo</option>
                                <option value="apartamento">Apartamento</option>
                                <option value="casa">Casa</option>
                                <option value="terreno">Terreno</option>
                            </select></div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltCondicao">Condição do Imóvel</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltCondicao" name="sltCondicao">
                                <option value="">Informe a Condição</option>
                                <option value="construcao">Em Construção</option>
                                <option value="novo">Novo</option>
                                <option value="usado">Usado</option>
                            </select></div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltQuarto">Quarto</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltQuarto" name="sltQuarto">
                                <option value="">Informe a Quantidade de Quarto</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">+ de 05</option>
                            </select></div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltGaragem">Garagem</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltGaragem" name="sltGaragem">
                                <option value="">Informe a Quantidade de Garagem</option>
                                <option value="nenhuma">Nenhuma</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">+ de 05</option>
                            </select></div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltBanheiro">Banheiro</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltBanheiro" name="sltBanheiro">
                                <option value="">Informe a Quantidade de Banheiro</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">+ de 05</option>
                            </select></div>
                    </div>


                </div>
            </div>
            <div class="col-lg-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Informações Adicionais </div>
                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltDiferencial">Diferencial</label>
                        <div class="col-lg-8">
                            <select id="sltDiferencial" multiple="multiple" name="sltDiferencial[]">
                                <option value="Academia">Academia</option>
                                <option value="AreaServico">Área de Serviço</option>
                                <option value="DependenciaEmpregada">Dependência de Empregada</option>
                                <option value="Elevador">Elevador</option>
                                <option value="Piscina">Piscina</option>
                                <option value="Quadra">Quadra</option>
                            </select>
                        </div>
                    </div>                      
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtArea">Área (M<sup>2</sup>)</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtArea" name="txtArea" class="form-control" placeholder="Informe a Área">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltSuite">Suite</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltSuite" name="sltSuite">
                                <option value="">Informe Nº de Suite</option>
                                <option value="nenhuma">Nenhuma</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">+ de 05</option>
                            </select></div>
                    </div>                      

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtDescricao"> Descrição </label>
                        <div class="col-lg-8">
                            <textarea maxlength="100" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea><br />
                        </div>

                        <div id="divApartamento">
                            <div id="divAndar">
                                <label class="col-lg-3 control-label" for="sltAndar">Andar</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="sltAndar" name="sltAndar">
                                        <option value="">Informe o Andar</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>                   
                                    </select><br />
                                </div>
                            </div>
                            <div id="divCobertura">
                                <div class="checkbox">
                                    <label class="col-sm-offset-3 col-sm-9" for="chkCobertura">
                                        <input type="checkbox" id="chkCobertura" name="chkCobertura"> Está na Cobertura      </label>                      
                                </div> 
                            </div>
                            <div class="checkbox">
                                <label class="col-sm-offset-3 col-sm-9" for="chkSacada">
                                    <input type="checkbox" id="chkSacada" name="chkSacada"> Possui Sacada     </label>                       
                            </div>

                            <br />  
                            <div id="divCondominio">
                                <label class="col-lg-3 control-label" for="txtArea">Valor do Condomínio</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtCondominio" name="txtCondominio" class="form-control" placeholder="Informe o Valor do Condominio">
                                </div> 
                            </div>

                        </div>    

                    </div>

                </div>
            </div>
        </div>
        <!-- Segunda Linha -->        
        <div class="row">
            <div class="col-lg-12">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading"> Endereço </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="txtCEP">CEP</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="txtCEP" name="txtCEP" placeholder="Informe o CEP do Imóvel">
                                </div>
                            </div>

                            <div id="divCEP">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtCidade">Cidade</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtCidade" name="txtCidade" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtEstado">Estado</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtEstado" name="txtEstado" readonly="true" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtBairro">Bairro</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtBairro" name="txtBairro" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtLogradouro">Logradouro</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtLogradouro" name="txtLogradouro" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtNumero">N&uacute;mero</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtNumero" name="txtNumero" placeholder="Informe o n&ordm;"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtComplemento">Complemento</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="Informe o Complemento"> 
                                    </div>
                                </div>                                
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <button id="btnCEP" type="button" class="btn btn-info">Buscar CEP</button>
                                </div>
                            </div>
                            <div id="alertCEP"></div>
                            <div class="popin">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button id="btnConfirmar"  type="button" class="btn btn-primary">Confirmar</button>
                        <button id="btnCancelar" type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
            </div>
            <div class="modal-body">  </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button id="btnCadastrar" type="button" class="btn btn-primary">Cadastrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->