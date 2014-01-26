<script>
     
$(document).ready(function(){
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
                    <p />
                    <div class="col-lg-3">
                        <label class="col-lg-3" for="sltFinalidade">Finalidade</label>
                        <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                            <option value="">Informe a Finalidade</option>
                            <option value="venda">Venda</option>
                            <option value="aluguel">Aluguel</option>
                        </select>
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

                    <div class="col-lg-3">
                        <label  for="sltBanheiro">Banheiro(s)</label>
                        <select class="form-control" id="sltGaragem" name="sltBanheiro">
                            <option value="">Informe Número de Banheiro(s)</option>
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
                        <label  for="sltValor">Valor do Imóvel</label>
                        <select class="form-control" id="sltCidade" name="sltValor">
                            <option value="">Informe o Valor</option>
                            <option value="2">Menos de R$40.000</option>
                            <option value="4">Entre R$40.000 e R$60.000</option>
                            <option value="6">Entre R$60.000 e R$80.000</option>
                            <option value="8">Entre R$80.000 e R$100.000</option>
                            <option value="10">Entre R$100.000 e R$120.000</option>
                            <option value="12">Entre R$120.000 e R$140.000</option>
                            <option value="14">Entre R$140.000 e R$160.000</option>
                            <option value="16">Entre R$160.000 e R$180.000</option>
                            <option value="18">Entre R$180.000 e R$200.000</option>
                            <option value="20">Entre R$200.000 e R$220.000</option>
                            <option value="22">Entre R$220.000 e R$240.000</option>
                            <option value="24">Entre R$240.000 e R$260.000</option>
                            <option value="26">Entre R$260.000 e R$280.000</option>
                            <option value="28">Entre R$280.000 e R$300.000</option>
                            <option value="30">Entre R$300.000 e R$320.000</option>
                            <option value="32">Entre R$320.000 e R$340.000</option>
                            <option value="34">Entre R$340.000 e R$360.000</option>
                            <option value="36">Entre R$360.000 e R$380.000</option>
                            <option value="38">Entre R$380.000 e R$400.000</option>
                            <option value="40">Entre R$400.000 e R$420.000</option>
                            <option value="42">Entre R$420.000 e R$440.000</option>
                            <option value="44">Entre R$440.000 e R$460.000</option>
                            <option value="46">Entre R$460.000 e R$480.000</option>
                            <option value="48">Entre R$480.000 e R$500.000</option>
                            <option value="50">Mais de R$500.000</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">Buscar Imóvel</button>
                    </div>

                </div>
            </form>
        </div>

        <!--        <div class="row text-danger" id="divmsgerro" hidden="true"></div>-->
        <div class="tab-pane fade" id="profile">
            <form id="form" class="form-horizontal" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="buscarAvancada" />    

                <div class="row">
                    <p />
                    <div class="col-lg-3">
                        <label class="col-lg-3" for="sltFinalidade">Finalidade</label>
                        <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                            <option value="">Informe a Finalidade</option>
                            <option value="venda">Venda</option>
                            <option value="aluguel">Aluguel</option>
                        </select>
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
                        <label  for="sltCondicao">Condição do Imóvel</label>
                        <select class="form-control" id="sltCondicao" name="sltCondicao">
                            <option value="">Informe a Condição</option>
                            <option value="construcao">Em Construção</option>
                            <option value="novo">Novo</option>
                            <option value="usado">Usado</option>
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

                <hr />

                <div class="row">

                    <div class="col-lg-3">
                        <label  for="sltGaragem">Garagem(ns)</label>
                        <select class="form-control" id="sltGaragem" name="sltGaragem">
                            <option value="">Informe Número de Garagem(ns)</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltCidade">Cidade</label>
                        <select class="form-control" id="sltGaragem" name="sltCidade">
                            <option value="">Informe a Cidade</option>
                            <option value="1">Belém</option>
                            <option value="2">Ananindeua</option>
                            <option value="3">Marituba</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltBairro">Bairro</label>
                        <select class="form-control" id="sltGaragem" name="sltBairro">
                            <option value="">Informe o Bairro</option>
                            <option value="jurunas">Jurunas</option>
                            <option value="batistacampos">Batista Campos</option>
                            <option value="cremacao">Cremação</option>
                            <option value="umarizal">Umarizal</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltBanheiro">Banheiro(s)</label>
                        <select class="form-control" id="sltGaragem" name="sltBanheiro">
                            <option value="">Informe Número de Banheiro(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>

                </div> 

                <hr />

                <div class="row">
                    
                    <div class="col-lg-3">
                        <label  for="sltSuite">Suite(s)</label>
                        <select class="form-control" id="sltGaragem" name="sltSuite">
                            <option value="">Informe Número de Suite(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">Mais de 05</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltDiferencial">Diferencial</label>
                        <div class="form-group">
                            <select id="sltDiferencial" multiple="multiple"  name="sltDiferencial[]">
                                <option value="Academia">Academia</option>
                                <option value="AreaServico">Área de Serviço</option>
                                <option value="DependenciaEmpregada">Dependência de Empregada</option>
                                <option value="Elevador">Elevador</option>
                                <option value="Piscina">Piscina</option>
                                <option value="Quadra">Quadra</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
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

                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">Buscar Imóvel</button>
                    </div> 

                </div>

        </div>


    </div>
</form>  

</div>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <?php
    $item = $this->getItem();
    $count = 0;
    $anuncios = $item['anuncios'];
    if (count($anuncios) % 3 != 0) {
        //Append 1 or 2 items from start of array if needed
        $anuncios = array_merge($anuncios, array_slice($anuncios, 0, 3 - count($anuncios) % 3));
    }
    ?>
    <form id="form" class="form-horizontal" action="index.php" method="post">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Anuncio"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="comparar" />
        <div class="row">
            <?php
            foreach ($anuncios as $anuncio) {
                $imovel = $anuncio->getImovel();
                if (($count > 0) and ($count % 3 == 0)) {
                    ?>
                </div><div class="row">
                    <?php
                }
                ?>
                <div class="col-lg-4">
                    <input type="checkbox" id="selecoes[]" name="selecoes[]" value=<?php echo $anuncio->getId(); ?>> 
                    <h2><span class="glyphicon glyphicon-bullhorn"></span> <?php echo $anuncio->getTituloAnuncio(); ?></h2>
                    <p><?php echo $anuncio->getDescricaoAnuncio(); ?>
                        <?php
                        if (count($anuncio->getImagem()) > 0) {
                            $imagem = $anuncio->getImagem();
                            $imagem = (is_array($imagem) ? $imagem[0] : $imagem);
                            echo '<img src="' . $imagem->getDiretorio() . '" width="250px" >';
                        }
                        ?>
                    </p>

                    <button id="btnAnuncioModal<?php echo $imovel->Referencia(); ?>" class="btn btn-default btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->getId(); ?>" data-title="<?php echo $anuncio->getTituloAnuncio(); ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span> Veja mais detalhes
                    </button>
                </div>
                <?php
                $count++;
            }
            ?>
                          <button type="submit" class="btn btn-link" id="comparar">Comparar</button>
        </div>
    </form>
</div>    

<!-- Modal -->
<div class="modal fade" id="divAnuncioModal" tabindex="-1" role="dialog" aria-labelledby="lblAnuncioModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" id="lblAnuncioModal"></h2>
            </div>
            <div id="modal-body" class="modal-body text-center">
            </div>
            <div class="modal-footer text-right"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
            </div>
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
        $("input[type='checkbox']").click(function() {
            if ($("input[type='checkbox']").filter(':checked').size() > NumeroMaximo) {
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
