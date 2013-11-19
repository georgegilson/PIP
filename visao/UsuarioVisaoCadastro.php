<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script>
    $(document).ready(function() {
        //######### CAMPOS DO FORMULARIO ########
        $("#divEmpresa").hide(); //oculta campos do DIVEMPRESA 

        $("#sltTipoUsuario").change(function() {
            if ($(this).val() == "fisica") {
                $("#divEmpresa").fadeOut('slow'); //oculta campos do DIVEMPRESA 
                $("#lblCpfCnpj").html("CPF")
                $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            } else {
                $("#divEmpresa").fadeIn('slow'); //mostra campos do DIVEMPRESA
                $("#lblCpfCnpj").html("CNPJ");
                $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            }
        })
       
        $("#btnTelefone").click(function(){
        $("#dadosTelefone").append(
               "<tr><td> <input type=hidden id=hdnTipoTelefone[] name=hdnTipoTelefone[] value=" + $("#sltTipotelefone").val() + ">" + $("#sltTipotelefone").val() + "</td>" +
               "<td> <input type=hidden id=hdnOperadora[] name=hdnOperadora[] value=" + $("#sltOperadora").val() + ">" + $("#sltOperadora").val() + "</td>" +
               "<td> <input type=hidden id=hdnTelefone[] name=hdnTelefone[] value=" + $("#txtTel").val() + ">" + $("#txtTel").val() + "</td>" +
               "<td> <button type=button class=btn btn-info onclick=$(this).parent().parent().remove()>Excluir</button> </td></tr>");     
        })

        //######### INICIO DO CEP ########
//        map = new GMaps({
//            div: '#map',
//            lat: -12.043333,
//            lng: -77.028333
//        });
//        $("#map").hide(); //oculta campos do mapa
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
//                        $("#map").fadeOut('slow'); //oculta campos do mapa
//                        $("#alertCEP").append(msgCEP);
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
//                            $("#map").fadeIn('slow'); //mostra campos do mapa
                            $('#txtEstado').val(resposta.uf);
                            $('#txtCidade').val(resposta.cidade);
                            $('#txtBairro').val(resposta.bairro);
                            $('#txtLogradouro').val(resposta.logradouro);
                            $('#hdnCEP').val($('#txtCEP').val());

                            //var endereco = $('#txtCEP').val() + resposta.logradouro + ', ' + $('#num').val() + ', ' + resposta.bairro + ', ' + resposta.cidade + ', ' + ', ' + resposta.uf;
                            var endereco = 'Brazil, ' + resposta.uf + ', ' + resposta.cidade + ', ' + resposta.bairro + ', ' + resposta.logradouro;
//                            GMaps.geocode({
//                                address: endereco.trim(),
//                                callback: function(results, status) {
//                                    if (status == 'OK') {
//                                        var latlng = results[0].geometry.location;
//                                        map.setCenter(latlng.lat(), latlng.lng());
//                                        map.addMarker({
//                                            lat: latlng.lat(),
//                                            lng: latlng.lng()
//                                        });
//                                    }
//                                }
//                            });
                        }
                        $("#alertCEP").append(msgCEP); //mostra resultado de busca cep
                        $('#txtCEP').removeAttr('disabled');
                        $('#btnCEP').removeAttr('disabled');
                    }
                })
            }
        }

        //######### FIM DO CEP ########
        
        //######### VALIDACAO DO FORMULARIO ########
        $('#form').validate({
            rules: {
                sltTipoUsuario: {
                    required: true
                },
                txtNome: {
                    required: true
                },
                txtCpfCnpj: {
                    required: true
                },
                txtLogin: {
                    required: true
                },
                txtResponsavel: {
                    required: true
                },
                txtEmail: {
                    required: true
                },
                txtRazaoSocial: {
                    required: true
                },
                txtSenha: {
                    required: true
                },   
                txtCEP: {
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
                            $('.alert').html("Usuário Cadastrado Com Sucesso").attr('class', 'alert alert-success');
                        } else {
                            $('.alert').html("Erro ao cadastrar").attr('class', 'alert alert-danger');
                        }
                    }
                })
                return false;

            }
        });
    })

</script> 

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Cadastro de Usuário</h1>
    </div>
    <!-- Alertas -->
    <div class="alert">Preencha os campos abaixo</div>

    <!-- form -->
    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
<!--        <input type="hidden" id="hdnTipoTelefone[]" name="hdnTipoTelefone[]" value=""  />-->
        <!-- Primeira Linha -->    
        <div class="row">
            <div class="col-lg-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Informações Básicas </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="sltTipoUsuario">Tipo de Pessoa</label>
                        <div class="col-lg-9">
                            <select class="form-control" id="sltTipoUsuario" name="sltTipoUsuario">
                                <option value="fisica">Física</option>
                                <option value="juridica">Jurídica</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtNome">Nome</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="Informe o seu nome">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtCpfCnpj" id="lblCpfCnpj">CPF</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtCpfCnpj" name="txtCpfCnpj" class="form-control" placeholder="Informe o seu CPF">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtLogin">Login</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Informe um login">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtSenha">Senha</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe uma senha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtEmail">Email</label>
                        <div class="col-lg-9">
                            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o seu email">
                        </div>
                    </div>
                    <div id="divEmpresa">
                        <div class="form-group" id="divresp">
                            <label class="col-lg-3 control-label" for="txtResponsavel">Responsável</label>
                            <div class="col-lg-9">
                                <input type="text" id="txtResponsavel" name="txtResponsavel" class="form-control" placeholder="Informe o nome do responsável da empresa">
                            </div>
                        </div>
                        <div class="form-group" id="divsocial">
                            <label class="col-lg-3 control-label" for="txtRazaoSocial">Razão Social</label>
                            <div class="col-lg-9">
                                <input type="text" id="txtRazaoSocial" name="txtRazaoSocial" class="form-control" placeholder="Informe a razão social da empresa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading"> Endereço </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtCEP">CEP</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="txtCEP" name="txtCEP" placeholder="Informe o seu CEP">                            
                        </div>
                        <div class="col-lg-2">
                            <button id="btnCEP" type="button" class="btn btn-info">Buscar CEP</button>
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
            </div>

        </div>
        <!-- Segunda Linha -->    
        <div class="row">
            <div class="col-lg-12">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading"> Telefones </div>
                    <div class="form-group">
                        <label class="col-lg-1 control-label" for="sltTipotelefone">Tipo</label>
                        <div class="col-lg-2">
                            <select class="form-control" id="sltTipotelefone" name="sltTipotelefone">                                    
                                <option value="Fixo">Fixo</option>
                                <option value="Celular">Celular</option>
                            </select>
                        </div>
                        <label class="col-lg-1 control-label" for="sltOperadora">Operadora</label>
                        <div class="col-lg-2">
                            <select class="form-control" id="sltOperadora" name="sltOperadora">                                    
                                <option value="Oi">Oi</option>
                                <option value="Tim">Tim</option>
                                <option value="Vivo">Vivo</option>
                                <option value="Claro">Claro</option>
                                <option value="Embratel">Embratel</option>
                            </select>
                        </div>
                        <label class="col-lg-1 control-label" for="txtTel">Numero</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" id="txtTel" name="txtTel" placeholder="Informe o Numero do Telefone">
                        </div>
                        <div class="col-lg-2">
                            <button id="btnTelefone" type="button" class="btn btn-info">Adcionar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tipo de Telefone</th>
                            <th>Operadora</th>
                            <th>Numero</th>
                        </tr>
                    </thead>
                    <tbody id="dadosTelefone">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Terceira Linha -->    
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
