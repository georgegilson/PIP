
<script>
    $(document).ready(function() {
        $('#form').validate({
            rules: {
                txtValor: {
                    minlength: 1,
                    maxlength: 15,
                    required: true
                },
                txtTopico: {
                    required: true
                },
                txtDescricao: {
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
                    data: {
                        hdnId: $('#hdnId').val(),
                        hdnDataCadastro: $('#hdnDataCadastro').val(),
                        hdnDataAtualizacao: $('#hdnDataAtualizacao').val(),
                        hdnEntidade: $('#hdnEntidade').val(),
                        hdnAcao: $('#hdnAcao').val(),
                        txtValor: $('#txtValor').val(),
                        txtTopico: $('#txtTopico').val(),
                        txtDescricao: $('#txtDescricao').val()
                    },
                    beforeSend: function() {
                        $('.alert').html("...processando...").attr('class', 'alert alert-warning');
                        $('button[type=submit]').attr('disabled', 'disabled');
                        //<div class="alert alert-warning">...</div>
                    },
                    success: function(resposta) {
                        $('button[type=submit]').removeAttr('disabled');
                        if (resposta.resultado == 1) {
                            $('.alert').html("Anuncio Cadastrado Com Sucesso").attr('class', 'alert alert-success');
                        } else {
                            $('.alert').html("Erro ao atualizar").attr('class', 'alert alert-danger');
                        }
                    }
                })
                return false;
            }
        });
    })

</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Cadastrar Anuncio</h1>
    
    <?php
        $item = $this->getItem();
        if ($item){
            foreach ($item as $imovel) {
        ?>
    
    <!-- Example row of columns -->
    <div class="alert">Preencha os campos abaixo</div>
    
    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnId" name="hdnId" value="<?php echo $imovel->getId()?>"/>
        <input type="hidden" id="hdnDataCadastro" name="hdnDataCadastro" value="<?php echo $imovel->getDatahoracadastro()?>"/>
        <input type="hidden" id="hdnDataAtualizacao" name="hdnDataAtualizacao" value=""/>
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtValor">Informe o Valor</label>
            <div class="col-lg-3">
                <input type="text" id="txtValor" name="txtValor" class="form-control" placeholder="informe o valor do imóvel" value="">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtTopico">Tópico do Anuncio</label>
            <div class="col-lg-3">
                <input type="text" id="txtTopico" name="txtTopico" class="form-control" placeholder="digite um tópico para o anuncio" value="">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtDescricao">Descrição do Anuncio</label>
            <div class="col-lg-3">
                <input type="text" id="txtDescricao" name="txtDescricao" class="form-control" placeholder="digite uma descrição do anuncio" value="">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="sltFinalidade">Finalidade</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                    
                    <option value="" disabled="true">Informe a Finalidade</option>
                    <option <?php if($imovel->getFinalidade()=="venda"){print "selected='true'";}?>value="venda" disabled="true">Venda</option>
                    <option <?php if($imovel->getFinalidade()=="aluguel"){print "selected='true'";}?>value="aluguel" disabled="true">Aluguel</option>
                    
                    <?php //} ?>
                    
                </select></div>
        </div>
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltQuarto">Quartos</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltQuarto" name="sltQuarto">
                    <option value="" disabled="true">Informe a quantidade de quartos</option>
                    <option <?php if($imovel->getQuarto()=="01"){print "selected='true'";}?> value="01" disabled="true">01</option>
                    <option <?php if($imovel->getQuarto()=="02"){print "selected='true'";}?>value="02" disabled="true">02</option>
                    <option <?php if($imovel->getQuarto()=="03"){print "selected='true'";}?>value="03" disabled="true">03</option>
                    <option <?php if($imovel->getQuarto()=="04"){print "selected='true'";}?>value="04" disabled="true">04</option>
                    <option <?php if($imovel->getQuarto()=="05"){print "selected='true'";}?>value="05" disabled="true">05</option>
                    <option <?php if($imovel->getQuarto()=="06"){print "selected='true'";}?>value="06" disabled="true">+ de 05</option>
                </select></div>
        </div>
        
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltTipo">Tipo de Imóvel</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltTipo" name="sltTipo">
                    <option value="" disabled="true">Informe o Tipo</option>
                    <option <?php if($imovel->getTipo()=="apartamento"){print "selected='true'";}?>value="apartamento" disabled="true">Apartamento</option>
                    <option <?php if($imovel->getTipo()=="casa"){print "selected='true'";}?>value="casa" disabled="true">Casa</option>
                    <option <?php if($imovel->getTipo()=="terreno"){print "selected='true'";}?>value="terreno" disabled="true">Terreno</option>
                </select></div>
        </div>
        
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltGaragem">Garagem(ns)</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltGaragem" name="sltGaragem">
                    <option value="" disabled="true">Informe a Quantidade de Garagens</option>
                    <option <?php if($imovel->getGaragem()=="nenhuma"){print "selected='true'";}?>value="nenhuma" disabled="true">Nenhuma</option>
                    <option <?php if($imovel->getGaragem()=="01"){print "selected='true'";}?>value="01" disabled="true">01</option>
                    <option <?php if($imovel->getGaragem()=="02"){print "selected='true'";}?>value="02" disabled="true">02</option>
                    <option <?php if($imovel->getGaragem()=="03"){print "selected='true'";}?>value="03" disabled="true">03</option>
                    <option <?php if($imovel->getGaragem()=="04"){print "selected='true'";}?>value="04" disabled="true">04</option>
                    <option <?php if($imovel->getGaragem()=="05"){print "selected='true'";}?>value="05" disabled="true">05</option>
                    <option <?php if($imovel->getGaragem()=="06"){print "selected='true'";}?>value="06" disabled="true">+ de 05</option>
                </select></div>
        </div>

        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltBanheiro">Banheiro(s)</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltBanheiro" name="sltBanheiro">
                    <option value="" disabled="true">Informe a Quantidade de Banheiro(s)</option>
                    <option <?php if($imovel->getBanheiro()=="01"){print "selected='true'";}?>value="01" disabled="true">01</option>
                    <option <?php if($imovel->getBanheiro()=="02"){print "selected='true'";}?>value="02" disabled="true">02</option>
                    <option <?php if($imovel->getBanheiro()=="03"){print "selected='true'";}?>value="03" disabled="true">03</option>
                    <option <?php if($imovel->getBanheiro()=="04"){print "selected='true'";}?>value="04" disabled="true">04</option>
                    <option <?php if($imovel->getBanheiro()=="05"){print "selected='true'";}?>value="05" disabled="true">05</option>
                    <option <?php if($imovel->getBanheiro()=="06"){print "selected='true'";}?>value="06" disabled="true">+ de 05</option>
                </select></div>
        </div>
        
        <label class="checkbox-inline">
        <input <?php if($imovel->getPiscina()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkPiscina" value="SIM" name="chkPiscina" disabled="true"> Piscina
        </label>

        <label class="checkbox-inline">
        <input <?php if($imovel->getQuadra()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkQuadra" value="SIM" name="chkQuadra" disabled="true"> Quadra
        </label>
               
        <label class="checkbox-inline">
        <input <?php if($imovel->getAcademia()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkAcademia" value="SIM" name="chkAcademia" disabled="true"> Academia
        </label>
        
        <label class="checkbox-inline">
        <input <?php if($imovel->getAreaServico()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkAreaServico" value="SIM" name="chkAreaServico" disabled="true"> Área de Serviço
        </label>
        
        <label class="checkbox-inline">
        <input <?php if($imovel->getDependenciaEmpregada()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkDependenciaEmpregada" value="SIM" name="chkDependenciaEmpregada" disabled="true"> Dependência de Empregada
        </label>
        
        <label class="checkbox-inline">
        <input <?php if($imovel->getElevador()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkElevador" value="SIM" name="chkElevador" disabled="true"> Elevador
        </label>
        
        <label class="checkbox-inline">
        <input <?php if($imovel->getSacada()=="SIM"){print "checked='true'";}?>type="checkbox" id="chkSacada" value="SIM" name="chkSacada" disabled="true"> Sacada
        </label><p>
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtArea">Informa a Área em M2</label>
            <div class="col-lg-3">
                <input type="text" id="txtArea" name="txtArea" class="form-control" placeholder="Área em M2" disabled="true" value="<?php print $imovel->getArea()?>">
            </div>
        </div>
        
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltSuite">Suite(s)</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltSuite" name="sltSuite">
                    <option value="" disabled="true">Informe Nº de Suite(s)</option>
                    <option <?php if($imovel->getSuite()=="nenhuma"){print "selected='true'";}?>value="nenhuma" disabled="true">Nenhuma</option>
                    <option <?php if($imovel->getSuite()=="01"){print "selected='true'";}?>value="01" disabled="true">01</option>
                    <option <?php if($imovel->getSuite()=="02"){print "selected='true'";}?>value="02" disabled="true">02</option>
                    <option <?php if($imovel->getSuite()=="03"){print "selected='true'";}?>value="03" disabled="true">03</option>
                    <option <?php if($imovel->getSuite()=="04"){print "selected='true'";}?>value="04" disabled="true">04</option>
                    <option <?php if($imovel->getSuite()=="05"){print "selected='true'";}?>value="05" disabled="true">05</option>
                    <option <?php if($imovel->getSuite()=="06"){print "selected='true'";}?>value="06" disabled="true">+ de 05</option>
                </select></div>
        </div>
        
        <?php } } ?>
<!--        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltSuite">Suites</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Suite</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtArea">&Aacute;rea (m<sup>2</sup>)</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtArea" placeholder="Informe a &Aacute;rea"> 
            </div>
        </div>
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltSuite">Suites</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Suite</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>


        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltGaragem">Garagem</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Garagem</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtTopicoImovel">T&oacute;pico do Im&oacute;vel</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtTopicoImovel" placeholder="Informe o T&oacut&oacute;pico do Im&oacute;vel">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtDescricaoImovel">Descri&ccedil;&atilde;o do Im&oacute;vel</label>
            <div class="col-lg-3">
                <textarea class="form-control" id="txtDescricaoImovel" placeholder="Informe a Desc"> </textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtCEP">CEP</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtCEP" placeholder="Informe CEP">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtBuscaAvancada">Busca Avan&ccedil;ada</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtBuscaAvancada" placeholder="Informe os termos para Busca Avan&ccedil;ada">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtCEP">CEP</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtCEP" placeholder="Informe CEP">
            </div>
        </div>
-->
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary">Editar</button>
                <button type="button" class="btn btn-warning">Cancelar</button>
            </div>
        </div>


    </form>
