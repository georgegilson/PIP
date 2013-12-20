<!-- INICIO DO MAPA --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<!-- FIM DO MAPA --> 
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script src="assets/js/bootstrap-multiselect.js"></script>
<script src="assets/js/bootstrap-maxlength.js"></script>
<script>
    $(document).ready(function() {

        $("#divApartamento").hide(); //oculta campos exclusivos do apartamento 

        $("#sltTipo").change(function() {
            if ($(this).val() == "casa" || $(this).val() == "terreno") {
                $("#divApartamento").fadeOut('slow'); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CPF")
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            } else {
                $("#divApartamento").fadeIn('slow'); //mostra campos exclusivos do apartamento
                //             $("#lblCpfCnpj").html("CNPJ");
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            }
        })

        $("#map").hide(); //oculta campos do mapa
        $("#txtCEP").mask("99.999-999"); //mascara
        $("#divCEP").hide(); //oculta campos do DIVCEP
        $("#btnCEP").click(function() {
            buscarCep()
        });
        $("#txtCEP").blur(function() {
            buscarCep()
        });

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
                sltFinalidade: {
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
            submitHandler: function() {
                if ($("#hdnCEP").val() != "") {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#form').serialize(),
                        beforeSend: function() {
                            $('.alert').html("...processando...").attr('class', 'alert alert-warning');
                            $('button[type=submit]').attr('disabled', 'disabled');
                        },
                        success: function(resposta) {
                            $('button[type=submit]').removeAttr('disabled');
                            if (resposta.resultado == 1) {
                                $('.alert').html("Imovel Cadastrado Com Sucesso").attr('class', 'alert alert-success');
                            } else {
                                $('.alert').html("Erro ao cadastrar").attr('class', 'alert alert-danger');
                            }
                        }
                    })
                    return false;
                } else {
                    $("#msgCEP").remove();
                    var msgCEP = $("<div>", {id: "msgCEP"});
                    msgCEP.attr('class', 'alert alert-danger').html("Primeiro faça a busca do CEP").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    $("#alertCEP").append(msgCEP);
                }
            }
        });
    })

</script>


<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Cadastrar Im&oacute;veis</h1>
    </div>
    <!-- Alertas -->
    <div class="alert">Preencha os campos abaixo</div>
    <!-- form -->
    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnId" name="hdnId" />
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
        <input type="hidden" id="hdnCEP" name="hdnCEP" />
        <!-- Primeira Linha -->        
        <div class="row">
            <div class="col-lg-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Informações Básicas </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="sltFinalidade">Finalidade</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                                <option value="">Informe a Finalidade</option>
                                <option value="venda">Venda</option>
                                <option value="aluguel">Aluguel</option>
                            </select></div>
                    </div>

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
                        <div class="col-lg-9">
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
                        <div class="col-lg-9">
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
                        <div class="col-lg-9">
                            <input type="text" id="txtArea" name="txtArea" class="form-control" placeholder="Informe a Área">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-3 control-label" for="sltSuite">Suite</label>
                        <div class="col-lg-9">
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
                        <div class="col-lg-9">
                            <textarea maxlength="100" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="Informe uma Descrição do Imóvel"> </textarea><br />
                        </div>

                        <div id="divApartamento">

                            <label class="col-lg-3 control-label" for="sltAndar">Andar</label>
                            <div class="col-lg-9">
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

                            <div class="checkbox">
                                <label class="col-lg-3 control-label" for="chkCobertura"></label>
                                <input type="checkbox" id="chkCobertura" name="chkCobertura"> Está na Cobertura                            
                            </div> 

                            <div class="checkbox">
                                <label class="col-lg-3 control-label" for="chkSacada"></label>
                                <input type="checkbox" id="chkSacada" name="chkSacada"> Possui Sacada                            
                            </div>

                            <br />  

                            <label class="col-lg-3 control-label" for="txtArea">Valor do Condomínio</label>
                            <div class="col-lg-9">
                                <input type="text" id="txtCondominio" name="txtCondominio" class="form-control" placeholder="Informe o Valor do Condominio">
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
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="txtCEP" name="txtCEP" placeholder="Informe o CEP do Imóvel">
                                </div>
                            </div>

                            <div id="divCEP">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtCidade">Cidade</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="txtCidade" name="txtCidade" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtEstado">Estado</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="txtEstado" name="txtEstado" readonly="true" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtBairro">Bairro</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="txtBairro" name="txtBairro" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtLogradouro">Logradouro</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="txtLogradouro" name="txtLogradouro" readonly="true"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtNumero">N&uacute;mero</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="txtNumero" name="txtNumero" placeholder="Informe o n&ordm;"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtComplemento">Complemento</label>
                                    <div class="col-lg-9">
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
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <button type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>                
            </div>
        </div>
    </form>
</div>