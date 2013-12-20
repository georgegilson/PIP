<script src="assets/js/gmaps.js"></script>
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/pwstrength.js"></script>
<script>

//Inicio CEP
    $(document).ready(function() {
        $("#txtCEP").mask("99.999-999"); //mascara
        //$("#divCEP").hide(); //oculta campos do DIVCEP
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
                            $("#divCEP").fadeIn('slow'); //mostra campos do DIVCEP
                            $('#txtEstado').val(resposta.uf);
                            $('#txtCidade').val(resposta.cidade);
                            $('#txtBairro').val(resposta.bairro);
                            $('#txtLogradouro').val(resposta.logradouro);
                            $('#hdnCEP').val($('#txtCEP').val());

                            var endereco = 'Brazil, ' + resposta.uf + ', ' + resposta.cidade + ', ' + resposta.bairro + ', ' + resposta.logradouro;

                        }
                        $("#alertCEP").append(msgCEP); //mostra resultado de busca cep
                        $('#txtCEP').removeAttr('disabled');
                        $('#btnCEP').removeAttr('disabled');
                    }
                })
            }
        }

        //######### FIM DO CEP ########

//       Inicio Informações Básicas

//        $("#divEmpresa").hide(); //oculta campos do DIVEMPRESA 
////        $("#divnome").hide();
////        $("#divCpf").hide();
////        $("#divCnpj").hide();
        $("#txtCpf").mask("999.999.999-99");
        $("#txtCnpj").mask("99.999.999/9999-99");
        $("#txtCpfResponsavel").mask("999.999.999-99");
//        $("#sltTipoUsuario").change(function() {
//            if ($(this).val() == "fisica") {
//                $("#divnome").fadeIn('slow');
//                $("#divEmpresa").fadeOut('slow'); //oculta campos do DIVEMPRESA 
//                $("#divCnpj").hide();
//                $("#divCpf").show();
//                $("#lblNome").html("Nome da Completo");
//            } else if ($(this).val() == "juridica") {
//                $("#divnome").fadeIn('slow');
//                $("#divEmpresa").fadeIn('slow'); //mostra campos do DIVEMPRESA
//                $("#divCnpj").show();
//                $("#divCpf").hide();
//                $("#lblNome").html("Nome da Empresa");
//                $("#txtNome").attr("placeholder", "Informe o nome da empresa");
//                
//            } else {
//                $("#divnome").fadeOut('slow');
//                $("#divEmpresa").fadeOut('slow'); //mostra campos do DIVEMPRESA
//                $("#divCnpj").fadeOut('slow');
//                $("#divCpf").fadeOut('slow');
//            }
//        });

        "use strict";
        var options = {
            bootstrap3: true,
            minChar: 8,
            errorMessages: {
                password_too_short: "<font color='red'>A senha é muito pequena</font>",
                same_as_username: "<font color='red'>Sua senha não pode ser igual ao seu login</font>"
            },
            verdicts: ["Fraca", "Normal", "Média", "Forte", "Muito Forte"],
            usernameField: "#txtLogin",
            onLoad: function() {
                $('#messages').text('Start typing password');
            },
            onKeyUp: function(evt) {
                $(evt.target).pwstrength("outputErrorList");
            }
        };
        $('#txtSenha').pwstrength(options);

//        Fim Informações Básicas

//        Inicio Telefone
        $("#btnTelefone").click(function() {
            $("#txtTel").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            $("#sltOperadora").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            $("#sltTipotelefone").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            var telefone = $("#txtTel");
            var tipoTelefone = $("#sltOperadora");
            var tipoOperadora = $("#sltTipotelefone");
            if (telefone.valid() && tipoTelefone.valid() && tipoOperadora.valid()) {
                $("#dadosTelefone").append(
                        "<tr><td> <input type=hidden id=hdnTipoTelefone[] name=hdnTipoTelefone[] value=" + $("#sltTipotelefone").val() + ">" + $("#sltTipotelefone").val() + "</td>" +
                        "<td> <input type=hidden id=hdnOperadora[] name=hdnOperadora[] value=" + $("#sltOperadora").val() + ">" + $("#sltOperadora").val() + "</td>" +
                        "<td> <input type=hidden id=hdnTelefone[] name=hdnTelefone[] value=" + $("#txtTel").val() + ">" + $("#txtTel").val() + "</td>" +
                        "<td> <button type=button class=btn btn-default btn-lg onclick=$(this).parent().parent().remove()> <span class=glyphicon glyphicon-trash></span> Excluir</button> </td></tr>");
            }
            $("#txtTel").rules("remove");
            $("#sltOperadora").rules("remove");
            $("#sltTipotelefone").rules("remove");
            $("#txtTel").val("");
            $("#sltOperadora").val("");
            $("#sltTipotelefone").val("");
        });

        $("#txtTel").mask("(99)9999-9999");

//        Fim do Telefone

        //######### VALIDACAO DO FORMULARIO ########
        $('#form').validate({
            onkeyup: false,
            rules: {
                sltTipoUsuario: {
                    required: true
                },
                txtNome: {
                    required: true
                },
                txtCpf: {
                    required: true,
                    cpf: 'both'
                },
                txtCnpj: {
                    required: true,
                    cnpj: 'both'
                },
                txtCpfResponsavel: {
                    required: true,
                    cpf: 'both'
                },
                txtLogin: {
                    required: true,
                    minlength: 2,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarLogin"
                                }
                            }
                    //locate: true
                },
                txtResponsavel: {
                    required: true
                },
                txtEmail: {
                    email: true,
                },
                txtRazaoSocial: {
                    required: true
                },
                txtSenha: {
                    required: true,
                    minlength: 4
                },
                txtConfirmSenha: {
                    required: true,
                    equalTo: "#txtSenha"
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
                }

            },
            messages: {
                txtCpf: {
                    required: "Campo obrigatório"
                },
                txtCnpj: {
                    required: "Campo obrigatório"
                },
                sltTipoUsuario: {
                    required: "Campo obrigatório"
                },
                txtNome: {
                    required: "Campo obrigatório"
                },
                txtLogin: {
                    required: "Campo obrigatório",
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    required: "Campo obrigatório",
                    minlength: "Senha deve possuir no mínimo 4 caracteres"
                },
                txtConfirmSenha: {
                    required: "Campo obrigatório",
                    equalTo: "Por Favor digite o mesmo valor novamente"
                },
                txtRazaoSocial: {
                    required: "Campo obrigatório"
                },
                txtResponsavel: {
                    required: "Campo obrigatório"
                },
                txtCEP: {
                    required: "Campo obrigatório"
                },
                txtCpfResponsavel: {
                    required: "Campo obrigatório"
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
                                $('.alert').html(
                                        "<p align=center> <h4>A sua conta de usuário foi criada com sucesso!\n\
                    <br>Confira o seu email, " + $("#txtEmail").val() + ", e confirme seu cadastro\n\
                    <br>Caso não tenha recebido a confirmação de cadastro, verifique também a sua caixa de SPAM\n\
                    <br>Lembramos que a ativação de sua conta se dá mediante sua confirmação.</h4> </center>").attr('class', 'alert alert-success');
                                $('#divlinha1').fadeOut('slow');
                                $('#divlinha2').fadeOut('slow');
                                $('#divlinha3').fadeOut('slow');
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

<?php
    $sessao = new Sessao();
    $sessao->gerarToken();  
?>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Cadastro de Usuário</h1>
    </div>
    <?php
    $item = $this->getItem();
    if ($item) {
        foreach ($item as $usuario) {
            ?>
            <!-- Alertas -->
            <div class="alert">Preencha os campos abaixo</div>

            <!-- form -->
            <form id="form" class="form-horizontal">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="alterar" />
                <input type="hidden" id="hdnCEP" name="hdnCEP" value="<?php echo $usuario->getEndereco()->getCep()?>"/>
                <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />
                <!-- Primeira Linha -->    
                <div class="row" id="divlinha1">

                    <!--            <div id="alertsucesso" class="col-lg-12"></div>-->
                    <div class="col-lg-6" id="divinformacoesbasicas">
                        <div id="forms" class="panel panel-default">
                            <div class="panel-heading">Informações Básicas </div>
                            <br>
<!--                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="sltTipoUsuario">Tipo de Pessoa</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="sltTipoUsuario" name="sltTipoUsuario">
                                        <option value="">Informe o Tipo de Pessoa</option>
                                        <option <?php
                                        if ($usuario->getTipousuario() == "fisica") {
                                            print "selected='true'";
                                        }
                                        ?> value="fisica">Física</option>
                                        <option <?php
                                        if ($usuario->getTipousuario() == "juridica") {
                                            print "selected='true'";
                                        }
                                        ?> value="juridica">Jurídica</option>
                                    </select>
                                </div>
                            </div>-->
                            <div class="form-group" id="divnome" <?php
                            if ($usuario->getTipousuario() == "juridica") {
                                print "hidden";
                            }
                            ?>>
                                <label class="col-lg-3 control-label" for="txtNome" id="lblNome">Nome Completo</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="Informe o seu nome" value="<?php echo $usuario->getNome() ?>">
                                </div>
                            </div>
                            <div class="form-group" id="divnomeempresa" <?php
                            if ($usuario->getTipousuario() == "fisica") {
                                print "hidden";
                            }
                            ?>>
                                <label class="col-lg-3 control-label" for="txtNomeempresa" id="lblNome">Nome da Empresa</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtNomeempresa" name="txtNomeempresa" class="form-control" placeholder="Informe o nome da empresa" value="<?php echo $usuario->getNome() ?>">
                                </div>
                            </div>
                            <div class="form-group" id="divCpf" <?php
                            if ($usuario->getTipousuario() == "juridica") {
                                print "hidden";
                            }
                            ?>>
                                <label class="col-lg-3 control-label" for="txtCpf" id="lblCpf">CPF</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtCpf" name="txtCpf" class="form-control" readonly="true" placeholder="Informe o seu CPF" value="<?php echo $usuario->getCpfcnpj() ?>">
                                </div>
                            </div>
                            <div class="form-group" id="divCnpj" <?php
                            if ($usuario->getTipousuario() == "fisica") {
                                print "hidden";
                            }
                            ?>>
                                <label class="col-lg-3 control-label" for="txtCnpj" id="lblCpfCnpj">CNPJ</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtCnpj" name="txtCnpj" class="form-control" placeholder="Informe o seu CNPJ" value="<?php echo $usuario->getCpfcnpj() ?>">
                                </div>
                            </div>
                            <!--                    <div class="form-group">
                                                    <label class="col-lg-3 control-label" for="txtLogin">Login</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Informe um login">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" for="txtSenha">Senha</label>
                                                    <div class="col-lg-8">
                                                        <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe uma senha">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" for="txtConfirmSenha">Confirma Senha</label>
                                                    <div class="col-lg-8">
                                                        <input type="password" id="txtSenha" name="txtConfirmSenha" class="form-control" placeholder="Informe a senha novamente">
                                                    </div>
                                                </div>-->
                            <div class="form-group" >
                                <label class="col-lg-3 control-label" for="txtEmail">Email</label>
                                <div class="col-lg-8">
                                    <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o seu email" value="<?php echo $usuario->getEmail() ?>">
                                </div>
                            </div>
                            <div id="divEmpresa" <?php
                            if ($usuario->getTipousuario() == "fisica") {
                                print "hidden";
                            }
                            ?>>
                                <div class="form-group" id="divresp">
                                    <label class="col-lg-3 control-label" for="txtResponsavel">Responsável</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="txtResponsavel" name="txtResponsavel" class="form-control" placeholder="Informe o nome do responsável da empresa" value="<?php
                                        if ($usuario->getTipousuario() == "juridica") {
                                            echo $usuario->getEmpresa()->getResponsavel();
                                        }
                                        ?>">
                                    </div>
                                </div>
                                <div class="form-group" id="divCpfResp">
                                    <label class="col-lg-3 control-label" for="txtCpfResponsavel">CPF do Responsável</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="txtCpfResponsavel" name="txtCpfResponsavel" class="form-control" placeholder="Informe o CPF do responsável da empresa" value="<?php
                                        if ($usuario->getTipousuario() == "juridica") {
                                            echo $usuario->getEmpresa()->getCpfresponsavel();
                                        }
                                        ?>">
                                    </div>
                                </div>
                                <div class="form-group" id="divsocial">
                                    <label class="col-lg-3 control-label" for="txtRazaoSocial">Razão Social</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="txtRazaoSocial" name="txtRazaoSocial" class="form-control" placeholder="Informe a razão social da empresa" value="<?php
                                        if ($usuario->getTipousuario() == "juridica") {
                                            echo $usuario->getEmpresa()->getRazaosocial();
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" id=divendereco">
                        <div id="forms" class="panel panel-default">
                            <div class="panel-heading"> Endereço </div>
                            <br>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="txtCEP">CEP</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="txtCEP" name="txtCEP" placeholder="Informe o seu CEP" value="<?php echo $usuario->getEndereco()->getCep() ?>">                            
                                </div>
                                <div class="col-lg-2">
                                    <button id="btnCEP" type="button" class="btn btn-info">Buscar CEP</button>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div id="alertCEP" class="col-lg-12"></div>
                            </div>
                            <div id="divCEP">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtCidade">Cidade</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtCidade" name="txtCidade" readonly="true" value="<?php echo $usuario->getEndereco()->getCidade() ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtEstado">Estado</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtEstado" name="txtEstado" readonly="true" value="<?php echo $usuario->getEndereco()->getEstado() ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtBairro">Bairro</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtBairro" name="txtBairro" readonly="true" value="<?php echo $usuario->getEndereco()->getBairro() ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtLogradouro">Logradouro</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtLogradouro" name="txtLogradouro" readonly="true" value="<?php echo $usuario->getEndereco()->getLogradouro() ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtNumero">N&uacute;mero</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtNumero" name="txtNumero" placeholder="Informe o n&ordm;" value="<?php echo $usuario->getEndereco()->getNumero() ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="txtComplemento">Complemento</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="Informe o Complemento" value="<?php echo $usuario->getEndereco()->getComplemento() ?>"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Segunda Linha -->    
                <div class="row" id="divlinha2">
                    <div class="col-lg-12" id="divtelefone">
                        <div id="forms" class="panel panel-default">
                            <div class="panel-heading"> Telefones </div>
                            <br>
                            <div class="form-group">
                                <label class="col-lg-1 control-label" for="sltTipotelefone">Tipo</label>
                                <div class="col-lg-2">
                                    <select class="form-control" id="sltTipotelefone" name="sltTipotelefone">     
                                        <option value="">Tipo do Telefone</option>
                                        <option value="Fixo">Fixo</option>
                                        <option value="Celular">Celular</option>
                                    </select>
                                </div>
                                <label class="col-lg-1 control-label" for="sltOperadora">Operadora</label>
                                <div class="col-lg-2">
                                    <select class="form-control" id="sltOperadora" name="sltOperadora">  
                                        <option value="">Operadora</option>
                                        <option value="Oi">Oi</option>
                                        <option value="Tim">Tim</option>
                                        <option value="Vivo">Vivo</option>
                                        <option value="Claro">Claro</option>
                                        <option value="Embratel">Embratel</option>
                                    </select>
                                </div>
                                <label class="col-lg-1 control-label" for="txtTel">Numero</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="txtTel" name="txtTel" placeholder="Informe o Telefone">
                                </div>
                                <div class="col-lg-2">
                                    <button id="btnTelefone" type="button" class="btn btn-info">Adicionar</button>
                                </div>
                            </div>
                            <!--                </div>-->
                            <!--          </div>-->
                            <div class="form-group">
                                <div class="col-lg-12">

                                    <table class="table table-hover table-condensed">
                    <!--                    <thead>
                                            <tr>
                                                <th>Tipo de Telefone</th>
                                                <th>Operadora</th>
                                                <th>Numero</th>
                                            </tr>
                                        </thead>-->
                                        <tbody id="dadosTelefone">
                                            <?php
                                            foreach ($usuario->getTelefone() as $telefone) {
                                                ?> 
                                                <tr>
                                                    <td> <input type=hidden id=hdnTipoTelefone[] name=hdnTipoTelefone[] value="<?php echo $telefone->getTipotelefone() ?>"> <?php echo $telefone->getTipotelefone() ?> </td>
                                                    <td> <input type=hidden id=hdnOperadora[] name=hdnOperadora[] value="<?php echo $telefone->getOperadora() ?>"> <?php echo $telefone->getOperadora() ?> </td>
                                                    <td> <input type=hidden id=hdnTelefone[] name=hdnTelefone[] value="<?php echo $telefone->getNumero() ?>"> <?php echo $telefone->getNumero() ?> </td>
                                                    <td> <button type=button class=btn btn-default btn-lg onclick=$(this).parent().parent().remove()> <span class=glyphicon glyphicon-trash></span> Excluir</button> </td>
                                                </tr>
                                            <?php } ?>     
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Terceira Linha -->    
                <div class="row" id="divlinha3">
                    <div class="col-lg-12" id="divbotoes">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Alterar</button>
                                <button type="button" class="btn btn-warning">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> 

        <?php
    }
}
?>