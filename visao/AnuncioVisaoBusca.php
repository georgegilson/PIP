<?php
include_once 'modelo/Imovel.php';

$imovel = new Imovel();
?>
       <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
       <script src="assets/js/gmaps.js"></script>
       <script src="assets/js/bootstrap-multiselect.js"></script>
<script>
     
$(document).ready(function(){
           $('#sltDiferencial').multiselect({
            buttonClass: 'btn btn-default btn-sm',
            includeSelectAllOption: true
        });
    $("select[name=sltCidade]").change(function(){
    $('select[name=sltBairro]').html('<option value="">Procurando...</option>');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade='+$('#sltCidade').val(),
                    function(resposta){
                    $('select[name=sltBairro]').html(resposta);
                    }

            );
            });
});

</script>

<script>
     
$(document).ready(function(){
    $("select[name=sltCidadeAvancado]").change(function(){
    $('select[name=sltBairroAvancado]').html('<option value="">Procurando...</option>');
            $.post('index.php?hdnEntidade=Bairro&hdnAcao=selecionarBairro&idcidade='+$('#sltCidadeAvancado').val(),
                    function(resposta){
                    $('select[name=sltBairroAvancado]').html(resposta);
                    }

            );
            });
});

</script>

<script>
$(document).ready(function(){
    $("#divValorVenda").hide(); //oculta a div dos valores de venda 
    $("#divValorAluguel").hide(); //oculta a div dos valores de aluguel

        $("#sltFinalidade").change(function() {
            if ($(this).val() == "venda") {
                $("#divValorInicial").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVenda").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CPF")
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicial").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVenda").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CNPJ");
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            } 
            
            if ($(this).val() == ""){
                $("#divValorVenda").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguel").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorInicial").fadeIn(); //oculta campos exclusivos do apartamento 
            }
            
        })
    });         
</script>

<script>
$(document).ready(function(){
    $("#divValorVendaAvancado").hide(); //oculta a div dos valores de venda 
    $("#divValorAluguelAvancado").hide(); //oculta a div dos valores de aluguel

        $("#sltFinalidadeAvancado").change(function() {
            if ($(this).val() == "venda") {
                $("#divValorInicialAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVendaAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CPF")
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CPF");
            }
            if ($(this).val() == "aluguel") {
                $("#divValorInicialAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorVendaAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
                //             $("#lblCpfCnpj").html("CNPJ");
                //             $("#txtCpfCnpj").attr("placeholder", "Informe o CNPJ");
            } 
            
            if ($(this).val() == ""){
                $("#divValorVendaAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorAluguelAvancado").fadeOut(); //oculta campos exclusivos do apartamento 
                $("#divValorInicialAvancado").fadeIn(); //oculta campos exclusivos do apartamento 
            }
            
        })
    });         
</script>
    
   <div class="container divBusca"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) -->         
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->

    <div class="bs-example bs-example-tabs">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-search"></span> Busca</a></li>
            <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-search"></span> Busca Avançada</a></li>
        </ul>
    </div>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="home">

            <form id="form" class="form-horizontal" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="buscar" />    
                
                <div class="row">
                    <div id="divFinalidade">
                        <p />
                        <div class="col-lg-3">
                            <label class="col-lg-3" for="sltFinalidade">Finalidade</label>
                            <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                                <option value="">Informe a Finalidade</option>
                                <option value="venda">Venda</option>
                                <option value="aluguel">Aluguel</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="divValorInicial">
                        <div class="col-lg-3">
                            <label  for="sltValor">Valor do Imóvel</label>
                            <select class="form-control" id="sltValor" name="sltValor">
                                <option value="">Selecione a Finalidade</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="divValorVenda">
                        <div class="col-lg-3">
                            <label  for="sltValorVenda">Valor do Imóvel</label>
                            <select class="form-control" id="sltValorVenda" name="sltValorVenda">
                                <option value="">Selecione o Valor</option>
                                <option value="20000">Menos de R$40.000</option>
                                <option value="40000">Entre R$40.000 e R$60.000</option>
                                <option value="60000">Entre R$60.000 e R$80.000</option>
                                <option value="80000">Entre R$80.000 e R$100.000</option>
                                <option value="100000">Entre R$100.000 e R$120.000</option>
                                <option value="120000">Entre R$120.000 e R$140.000</option>
                                <option value="140000">Entre R$140.000 e R$160.000</option>
                                <option value="160000">Entre R$160.000 e R$180.000</option>
                                <option value="180000">Entre R$180.000 e R$200.000</option>
                                <option value="200000">Entre R$200.000 e R$220.000</option>
                                <option value="220000">Entre R$220.000 e R$240.000</option>
                                <option value="240000">Entre R$240.000 e R$260.000</option>
                                <option value="260000">Entre R$260.000 e R$280.000</option>
                                <option value="280000">Entre R$280.000 e R$300.000</option>
                                <option value="300000">Entre R$300.000 e R$320.000</option>
                                <option value="320000">Entre R$320.000 e R$340.000</option>
                                <option value="340000">Entre R$340.000 e R$360.000</option>
                                <option value="360000">Entre R$360.000 e R$380.000</option>
                                <option value="380000">Entre R$380.000 e R$400.000</option>
                                <option value="400000">Entre R$400.000 e R$420.000</option>
                                <option value="420000">Entre R$420.000 e R$440.000</option>
                                <option value="440000">Entre R$440.000 e R$460.000</option>
                                <option value="460000">Entre R$460.000 e R$480.000</option>
                                <option value="480000">Entre R$480.000 e R$500.000</option>
                                <option value="500000">Mais de R$500.000</option>
                            </select>
                        </div>
                    </div>
                    
                     <div id="divValorAluguel">
                        <div class="col-lg-3">
                            <label  for="sltValorAluguel">Valor do Aluguel</label>
                            <select class="form-control" id="sltValorAluguel" name="sltValorAluguel">
                                <option value="">Selecione o Valor</option>
                                <option value="100">Menos de R$200,00</option>
                                <option value="200">Entre R$200,00 e R$400,00</option>
                                <option value="400">Entre R$400,00 e R$600,00</option>
                                <option value="600">Entre R$600,00 e R$800,00</option>
                                <option value="800">Entre R$800,00 e R$1000,00</option>
                                <option value="1000">Entre R$1.000,00 e R$1200,00</option>
                                <option value="1200">Entre R$1.200,00 e R$1400,00</option>
                                <option value="1400">Entre R$1.400,00 e R$1600,00</option>
                                <option value="1600">Entre R$1.600,00 e R$1.800,00</option>
                                <option value="1800">Entre R$1.800,00 e R$2.000,00</option>
                                <option value="2000">Entre R$2.000,00 e R$2.200,00</option>
                                <option value="2200">Entre R$2.200,00 e R$2.400,00</option>
                                <option value="2400">Entre R$2.400,00 e R$2.600,00</option>
                                <option value="2600">Entre R$2.600,00 e R$2.800,00</option>
                                <option value="2800">Entre R$2.800,00 e R$3.000,00</option>
                                <option value="3000">Entre R$3.000,00 e R$3.200,00</option>
                                <option value="3200">Entre R$3.200,00 e R$3.400,00</option>
                                <option value="3400">Entre R$3.400,00 e R$3.600,00</option>
                                <option value="3600">Entre R$3.600,00 e R$3.800,00</option>
                                <option value="3800">Entre R$3.800,00 e R$4.000,00</option>
                                <option value="4000">Mais de R$4.000,00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <label  for="sltTipo">Tipo de Imóvel</label>
                        <select class="form-control" id="sltTipo" name="sltTipo">
                            <option value="">Informe o Tipo</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="casa">Casa</option>
                            <option value="terreno">Terreno</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltQuarto">Quarto(s)</label>
                        <select class="form-control" id="sltQuarto" name="sltQuarto">
                            <option value="">Informe Número de Quarto(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>
                    
                </div>

                <br />

                <div class="row">

                    <div class="col-lg-3">
                        <label  for="sltCidade">Cidade</label>
                        <select class="form-control" id="sltCidade" name="sltCidade">
                            <option value="">Informe a Cidade</option>
                            <option value="1">Belém</option>
                            <option value="2">Ananindeua</option>
                            <option value="3">Marituba</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltBairro">Bairro</label>
                        <select class="form-control" id="sltBairro" name="sltBairro">
                            <option value="">Selecione a Cidade</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-3">
                        <label  for="sltBanheiro">Banheiro(s)</label>
                        <select class="form-control" id="sltBanheiro" name="sltBanheiro">
                            <option value="">Informe Número de Banheiro(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <br/>
                        <input type="checkbox" id="chkGaragem" name="chkGaragem" checked="true"> Imóvel com Garagem &nbsp; &nbsp; &nbsp; &nbsp; 
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>

                </div>
            </form>
        </div>

        <!--        <div class="row text-danger" id="divmsgerro" hidden="true"></div>-->
        <div class="tab-pane fade" id="profile">
            <form id="form" class="form-horizontal" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="buscarAvancado" />    
                
                <div class="row">
                    <div id="divFinalidadeAvancado">
                        <p />
                        <div class="col-lg-3">
                            <label for="sltFinalidadeAvancado">Finalidade</label>
                            <select class="form-control" id="sltFinalidadeAvancado" name="sltFinalidadeAvancado">
                                <option value="">Informe a Finalidade</option>
                                <option value="venda">Venda</option>
                                <option value="aluguel">Aluguel</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="divValorInicialAvancado">
                        <div class="col-lg-3">
                            <label for="sltValorAvancado">Valor do Imóvel</label>
                            <select class="form-control" id="sltValorAvancado" name="sltValorAvancado">
                                <option value="">Selecione a Finalidade</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="divValorVendaAvancado">
                        <div class="col-lg-3">
                            <label  for="sltValorVendaAvancado">Valor do Imóvel</label>
                            <select class="form-control" id="sltValorVendaAvancado" name="sltValorVendaAvancado">
                                <option value="">Selecione o Valor</option>
                                <option value="20000">Menos de R$40.000</option>
                                <option value="40000">Entre R$40.000 e R$60.000</option>
                                <option value="60000">Entre R$60.000 e R$80.000</option>
                                <option value="80000">Entre R$80.000 e R$100.000</option>
                                <option value="100000">Entre R$100.000 e R$120.000</option>
                                <option value="120000">Entre R$120.000 e R$140.000</option>
                                <option value="140000">Entre R$140.000 e R$160.000</option>
                                <option value="160000">Entre R$160.000 e R$180.000</option>
                                <option value="180000">Entre R$180.000 e R$200.000</option>
                                <option value="200000">Entre R$200.000 e R$220.000</option>
                                <option value="220000">Entre R$220.000 e R$240.000</option>
                                <option value="240000">Entre R$240.000 e R$260.000</option>
                                <option value="260000">Entre R$260.000 e R$280.000</option>
                                <option value="280000">Entre R$280.000 e R$300.000</option>
                                <option value="300000">Entre R$300.000 e R$320.000</option>
                                <option value="320000">Entre R$320.000 e R$340.000</option>
                                <option value="340000">Entre R$340.000 e R$360.000</option>
                                <option value="360000">Entre R$360.000 e R$380.000</option>
                                <option value="380000">Entre R$380.000 e R$400.000</option>
                                <option value="400000">Entre R$400.000 e R$420.000</option>
                                <option value="420000">Entre R$420.000 e R$440.000</option>
                                <option value="440000">Entre R$440.000 e R$460.000</option>
                                <option value="460000">Entre R$460.000 e R$480.000</option>
                                <option value="480000">Entre R$480.000 e R$500.000</option>
                                <option value="500000">Mais de R$500.000</option>
                            </select>
                        </div>
                    </div>
                    
                     <div id="divValorAluguelAvancado">
                        <div class="col-lg-3">
                            <label  for="sltValorAluguelAvancado">Valor do Aluguel</label>
                            <select class="form-control" id="sltValorAluguelAvancado" name="sltValorAluguelAvancado">
                                <option value="">Selecione o Valor</option>
                                <option value="100">Menos de R$200,00</option>
                                <option value="200">Entre R$200,00 e R$400,00</option>
                                <option value="400">Entre R$400,00 e R$600,00</option>
                                <option value="600">Entre R$600,00 e R$800,00</option>
                                <option value="800">Entre R$800,00 e R$1000,00</option>
                                <option value="1000">Entre R$1.000,00 e R$1200,00</option>
                                <option value="1200">Entre R$1.200,00 e R$1400,00</option>
                                <option value="1400">Entre R$1.400,00 e R$1600,00</option>
                                <option value="1600">Entre R$1.600,00 e R$1.800,00</option>
                                <option value="1800">Entre R$1.800,00 e R$2.000,00</option>
                                <option value="2000">Entre R$2.000,00 e R$2.200,00</option>
                                <option value="2200">Entre R$2.200,00 e R$2.400,00</option>
                                <option value="2400">Entre R$2.400,00 e R$2.600,00</option>
                                <option value="2600">Entre R$2.600,00 e R$2.800,00</option>
                                <option value="2800">Entre R$2.800,00 e R$3.000,00</option>
                                <option value="3000">Entre R$3.000,00 e R$3.200,00</option>
                                <option value="3200">Entre R$3.200,00 e R$3.400,00</option>
                                <option value="3400">Entre R$3.400,00 e R$3.600,00</option>
                                <option value="3600">Entre R$3.600,00 e R$3.800,00</option>
                                <option value="3800">Entre R$3.800,00 e R$4.000,00</option>
                                <option value="4000">Mais de R$4.000,00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <label  for="sltTipo">Tipo de Imóvel</label>
                        <select class="form-control" id="sltTipo" name="sltTipo">
                            <option value="">Informe o Tipo</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="casa">Casa</option>
                            <option value="terreno">Terreno</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <label  for="sltQuarto">Quarto(s)</label>
                        <select class="form-control" id="sltQuarto" name="sltQuarto">
                            <option value="">Quarto(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-2">
                        <label  for="sltBanheiro">Banheiro(s)</label>
                        <select class="form-control" id="sltBanheiro" name="sltBanheiro">
                            <option value="">Banheiro(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>
                    
                </div>    
                    
                <br />
                
                <div class="row">
                    
                    <div class="col-lg-3">
                        <label  for="sltCidadeAvancado">Cidade</label>
                        <select class="form-control" id="sltCidadeAvancado" name="sltCidadeAvancado">
                            <option value="">Informe a Cidade</option>
                            <option value="1">Belém</option>
                            <option value="2">Ananindeua</option>
                            <option value="3">Marituba</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltBairroAvancado">Bairro</label>
                        <select class="form-control" id="sltBairroAvancado" name="sltBairroAvancado">
                            <option value="">Selecione a Cidade</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                       <label  for="sltGaragem">Garagem(ns)</label>
                        <select class="form-control" id="sltGaragem" name="sltGaragem">
                            <option value="">Garagem(ns)</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select> 
                    </div>
                    
                    <div class="col-lg-2">
                        <label  for="sltSuite">Suite(s)</label>
                        <select class="form-control" id="sltGaragem" name="sltSuite">
                            <option value="">Suite(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div> 
                    
                    <div class="col-lg-2">
                        <label  for="sltM2">Área (m²)</label>
                        <select class="form-control" id="sltM2" name="sltM2">
                            <option value="">Informe a Área(s)</option>
                            <option value="00">Menos de 40</option>
                            <option value="40">Mais de 40</option>
                            <option value="60">Mais de 60</option>
                            <option value="80">Mais de 80</option>
                            <option value="100">Mais de 100</option>
                            <option value="120">Mais de 120</option>
                            <option value="140">Mais de 140</option>
                            <option value="160">Mais de 160</option>
                            <option value="180">Mais de 180</option>
                            <option value="200">Mais de 200</option>
                        </select>
                    </div> 
                    
                </div>

                <br />

                <div class="row">            
                    
                    <div class="col-lg-3">
                        <label  for="sltCondicao">Condição do Imóvel</label>
                        <select class="form-control" id="sltCondicao" name="sltCondicao">
                            <option value="">Informe a Condição</option>
                            <option value="construcao">Em Construção</option>
                            <option value="novo">Novo</option>
                            <option value="usado">Usado</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-2">
                        <label  for="txtReferencia">Referência do Imóvel</label>
                         <input type="text" id="txtReferencia" name="txtReferencia" class="form-control" placeholder="Ex: 20130000001">
                    </div>
                    
                    <div class="col-lg-3">
                        <label  for="sltDiferencial">Diferencial</label>
                        <div class="form-group">
                            <select id="sltDiferencial" multiple="multiple"  name="sltDiferencial[]">
                                <option value="academia">Academia</option>
                                <option value="areaservico">Área de Serviço</option>
                                <option value="dependenciaempregada">Dependência de Empregada</option>
                                <option value="elevador">Elevador</option>
                                <option value="piscina">Piscina</option>
                                <option value="quadra">Quadra</option>
                            </select>
                        </div>
                    
                    </div>
                    
                    <br />
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">Buscar Imóvel</button>
                    </div> 
                    
                </div>    
 
             </div>    
                
            </form>
            
            <p/>
            
        </div>
   </div>      



<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
     <script src="assets/js/gridforms.js"></script>
     <form class="grid-form">
    <!-- Example row of columns -->
    
        <table class="table table-hover">
            <thead>
                <!--<tr>
                    <th>Valor</th>
                    <th>Titulo</th>
                    <th>Descrição</th> 
                    <th>Banheiro(s)</th>
                    <th>Data da Publicação</th>
                </tr>-->
            </thead>
            <tbody>

            <br/>

            <?php
            $item = $this->getItem();
//                $_POST = array_slice($_POST, 2);
//                print "Sua Busca: ";
//                
//                foreach ($_POST as $post)
//                    
//                    if(!empty($post)){    
//
//                    print "<span class='label label-primary'>".$post."</span>, ";
//
//                    }
//                print "<br/>";
            ?>

            <script>
                $(document).ready(function() {
                    var NumeroMaximo = 10;
                    $("input[id^='selecoes_']").click(function() {
                        if ($("input[id^='selecoes_']").filter(':checked').size() > NumeroMaximo) {
                            alert('Selecione no máximo ' + NumeroMaximo + ' imóveis para a comparação');
                            return false;
                        } else {
                            if ($(this).filter(':checked').size() > 0) {
                                $(this).parent().parent().parent().css('border', '3px dotted orange');
                            } else {
                                $(this).parent().parent().parent().css('border', '0px');
                            }
                        }
                    })
                });
            </script>

            <?php
            echo "<span class='label label-danger'>" . count($item) . "</span> imóvel(is) encontrado(s)<p/>";

            if ($item) {
                foreach ($item as $anuncio) {
                    ?>
        <link rel="stylesheet" type="text/css" href="assets/css/gridforms.css">            
        
        <div class="panel panel-warning col-md-11"  id="<?php echo $anuncio->id; ?>" >

        <div class="panel-body">
        
        <fieldset class="col-md-9">
                        
                        <div data-row-span="1">
                         <input type="checkbox" id="selecoes_<?php echo $anuncio->id; ?>" class="option" name="selecoes[]" value=<?php echo $anuncio->id; ?>> Selecionar Imóvel         
                        </div>
            
                        <div data-row-span="7">
				<div data-field-span="2">
                                    <label style="text-align: center">Título</label>
					<?php echo "<span class='label label-info'>" . strtoupper($anuncio->tituloanuncio) . "</span>"; ?>
				</div>
                            
                                <div data-field-span="1">
					<label style="text-align: center">Tipo</label>
					<?php echo "<span class='label label-warning'>" . strtoupper($anuncio->tipo) . "</span>"; ?>
				</div>
                            
				<div data-field-span="1">
					<label style="text-align: center">Finalidade</label>
					<?php echo "<span class='label label-primary'>" . strtoupper($anuncio->finalidade) . "</span>"; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Quarto(s)</label>
					<?php echo $anuncio->quarto; ?>
				</div>
                                <div data-field-span="1">
                                    <label style="text-align: center">Área (em m<sup>2</sup>)</label>
					<?php echo $anuncio->area; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Condição</label>
					<?php echo $anuncio->condicao; ?>
				</div>
			</div>
            
			<div data-row-span="7">
				<div data-field-span="3">
					<label style="text-align: center">Descrição</label>
					<?php echo $anuncio->descricao; ?>
				</div>
				<div data-field-span="1">
					<label style="text-align: center">Valor</label>
					 R$ <?php echo $anuncio->valor; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Banheiro(s)</label>
					<?php echo $anuncio->banheiro; ?>
				</div>
                                 <div data-field-span="1">
					<label style="text-align: center">Garagem(ns)</label>
					<?php echo $anuncio->garagem; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Referência</label>
					<?php echo "<span class='label label-info'>" . substr($anuncio->datahoracadastro, 6, -9) . substr($anuncio->datahoracadastro, 3, -14) . str_pad($anuncio->idimovel, 5, "0", STR_PAD_LEFT) . "</span>"; ?>
				</div>
			</div>
            
                        <div data-row-span="7">
                            <div data-field-span="3" style="background-color: #e4fcff">
					<label style="text-align: center;">Endereço</label>
					<?php echo $anuncio->logradouro . ", Nº " . $anuncio->numero;?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Cidade</label>
					<?php echo $anuncio->cidade ;?>
				</div>
				<div data-field-span="1">
					<label style="text-align: center">Bairro</label>
					<?php echo $anuncio->bairro; ?>
				</div>
                                <div data-field-span="1">
					<label style="text-align: center">Suite(s)</label>
					<?php echo $anuncio->suite; ?>
				</div>
                                 <div data-field-span="1">
					<label style="text-align: center">Condição</label>
					<?php echo $anuncio->condicao; ?>
				</div>
                                
			</div>
                            
                 
            
            
        </fieldset>
            <br/>
            <fieldset class="col-md-2">
                
                <div>
                    
                    <img src="<?php echo $anuncio->diretorio ?>" height="160" width="160" class="img-thumbnail" style="margin-left: 60px">
                    
                </div>
                
                <br/>
                
                <div>

                    <button type="button" id="btnAnuncioModal<?php echo substr($anuncio->datahoracadastro, 6, -9) . substr($anuncio->datahoracadastro, 3, -14) . str_pad($anuncio->idimovel, 5, "0", STR_PAD_LEFT); ?>" class="btn btn-default btn-sm" style="margin-left: 60px" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->id; ?>" data-title="<?php echo $anuncio->tituloanuncio; ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span> Veja mais detalhes
                    </button>
                    
                </div>
                
            </fieldset>    
           
            <!-- Modal -->
<div class="modal fade" id="divAnuncioModal" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
<!--            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" id="lblAnuncioModal"></h2>
            </div>-->
            <div id="modal-body" class="modal-body text-center">
            </div>
<!--            <div class="modal-footer text-right"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
            </div>-->
        </div>
    </div>
</div><!-- /.modal -->

<script>
    $(document).ready(function() {
        $('[id^=btnAnuncioModal]').click(function() {
            $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
            $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
            $("#modal-body").load("index.php", {hdnEntidade:'Anuncio', hdnAcao:'modal', hdnToken:'<?php //Sessao::gerarToken(); echo $_SESSION["token"]; ?>', hdnModal:$(this).attr('data-modal')});
        })

        var NumeroMaximo = 10;
        $("input[id^='selecoes_']").click(function() {
            if ($("input[id^='selecoes_']").filter(':checked').size() > NumeroMaximo) {
                alert('Selecione no máximo '+ NumeroMaximo +' imóveis para a comparação');
                return false;
            }
        })

        $("input[type='submit']").click(function() {
                alert('teste');
    //            if ($("input[type='checkbox']").filter(':checked').size( ) == 0)
    //            {
    //                alert('Selecione no mínimo 2 imóveis para a comparação');
    //                return false;
    //            }
        })
        
    })
</script>

            
        </div>
            
        </div>    
            
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        
            <?php
                }
            }
            ?>
            </tbody>
        </table>
       
        <!-- Divs ocultas que serao exibidas dentro do popover. -->
        <?php
        $item = $this->getItem();
        if ($item) {
            foreach ($item as $imovel) {
                ?>   
                <div id="popover<?php echo $imovel->id; ?>-content" class="hide">
                    <?php
                    echo "Tipo: " . $imovel->getTipo() . "<br />";
                    echo "Condição: " . $imovel->getCondicao() . "<br />";
                    echo "Quartos: " . $imovel->getQuarto() . "<br />";
                    echo "Garagen(s): " . $imovel->getGaragem() . "<br />";
                    echo "Banheiro(s): " . $imovel->getBanheiro() . "<br />";
                    echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
                    echo "Suite(s): " . (($imovel->getSuite() != "nenhuma") ? '<span class="text-primary">' . $imovel->getSuite() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Piscina: " . (($imovel->getPiscina() == "SIM") ? '<span class="text-primary">' . $imovel->getPiscina() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Quadra: " . (($imovel->getQuadra() == "SIM") ? '<span class="text-primary">' . $imovel->getQuadra() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Academia: " . (($imovel->getAcademia() == "SIM") ? '<span class="text-primary">' . $imovel->getAcademia() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Área Serviço: " . (($imovel->getAreaServico() == "SIM") ? '<span class="text-primary">' . $imovel->getAreaServico() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Dependencia: " . (($imovel->getDependenciaEmpregada() == "SIM") ? '<span class="text-primary">' . $imovel->getDependenciaEmpregada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';

                    if ($imovel->getTipo() == "apartamento") {
                        echo "Sacada: " . (($imovel->getSacada() == "SIM") ? '<span class="text-primary">' . $imovel->getSacada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                        echo "Cobertura: " . (($imovel->getCobertura() == "SIM") ? '<span class="text-primary">' . $imovel->getCobertura() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                        echo "Condomínio: " . (($imovel->getCondominio() != "") ? '<span class="text-primary">' . $imovel->getCondominio() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                        echo "Andar: " . (($imovel->getAndar() != "") ? '<span class="text-primary">' . $imovel->getAndar() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                    }
                    ?>
                </div>
                <?php
            }
        }
        ?>

        <script type="text/javascript">
            $(document).ready(function() {
                // Associa o evento do popover ao clicar no link.
                $("a[id^='popover']").popover({
                    trigger: 'hover',
                    html: true,
                    title: 'Detalhes do Imóvel',
                    content: function() {
                        var div = '#' + $(this).attr('id') + '-content';
                        return $(div).html();
                    }
                }).click(function(e) {
                    e.preventDefault();
                    // Exibe o popover.
                    $(this).popover('show');
                });
            });
        </script>
    </form>
</div>