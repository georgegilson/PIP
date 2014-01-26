 
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
    <!-- Example row of columns -->
    <form>   
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
                
                $_POST = array_slice($_POST, 2);
                
                print "Sua Busca: ";
                
                foreach ($_POST as $post)
                    
                    if(!empty($post)){    

                    print "<span class='label label-primary'>".$post."</span>, ";

                    }
                print "<br/>";
                
                echo count($item)." imóvel(is) encontrado(s)<br/>";
                
                if ($item) {
                    foreach ($item as $anuncio) {
                        ?>
                
            <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $anuncio->tituloanuncio; ?></h3>
                        </div>
                        <div class="panel-body">
                            <label>Finalidade:</label>
                            <?php  echo $anuncio->finalidade."<br/>";?>
                            <label>Tipo:</label>
                            <?php echo $anuncio->tipo."<br/>";?>
                            <label>Descrição:</label>
                            <?php echo $anuncio->descricao."<br/>";?>
                            <label>Valor: R$ </label>
                            <?php echo $anuncio->valor."<br/>";?>
                            <label>Quarto(s):</label>
                            <?php echo $anuncio->quarto."<br/>";?>
                            <label>Garagem(ns):</label>
                            <?php echo $anuncio->garagem."<br/>";?>
                            <label>Cidade:</label>
                            <?php echo $anuncio->cidade."<br/>";?>
                            <label>Bairro:</label>
                            <?php echo $anuncio->bairro."<br/>";?>
                            <label>Banheiro(s):</label>
                            <?php echo $anuncio->banheiro."<br/>";?>
                        </div>
           </div>
             
                        <tr>
                            <td><?php echo $anuncio->valor; ?></td>
                            <td><?php echo $anuncio->tituloanuncio; ?></td>
                            <td><?php echo $anuncio->descricao; ?></td>
                            <td><?php echo $anuncio->banheiro; ?></td>
                            <td><?php echo $anuncio->cidade; ?></td>
                        </tr>
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
                <div id="popover<?php echo $imovel->getId(); ?>-content" class="hide">
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
            <?php }
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