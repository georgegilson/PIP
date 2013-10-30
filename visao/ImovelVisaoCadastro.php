
<script>
    $(document).ready(function() {
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
                        hdnEntidade: $('#hdnEntidade').val(),
                        hdnAcao: $('#hdnAcao').val(),
                        txtValor: $('#txtValor').val(),
                        sltFinalidade: $('#sltFinalidade').val(),
                        sltQuarto: $('#sltQuarto').val()
                    },
                    beforeSend: function() {
                        $('.alert').html("...processando...").attr('class', 'alert alert-warning');
                        $('button[type=submit]').attr('disabled', 'disabled');
                        //<div class="alert alert-warning">...</div>
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
            }
        });
    })

</script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Cadastrar Im&oacute;veis</h1>
    <!-- Example row of columns -->
    <div class="alert">Preencha os campos abaixo</div>

    <form id="form" class="form-horizontal">
        <input type="hidden" id="hdnId" name="hdnId" />
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtValor">Valor</label>
            <div class="col-lg-3">
                <input type="text" id="txtValor" name="txtValor" class="form-control" placeholder="Informe o valor">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="sltFinalidade">Finalidade</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                    <option value="">Informe a Finalidade</option>
                    <option value="venda">Venda</option>
                    <option value="aluguel">Aluguel</option>
                </select></div>
        </div>
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltQuarto">Quartos</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltQuarto" name="sltQuarto">
                    <option value="">Informe a quantidade de quartos</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">+ de 05</option>
                </select></div>
        </div>

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
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="button" class="btn btn-warning">Cancelar</button>
            </div>
        </div>

    </form>
