<!-- Carousel
 ================================================== -->
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <!-- Example row of columns -->
    <!--    <div class="alert">Todos</div> -->

    <div class="bs-example bs-example-tabs">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Busca</a></li>
            <li><a href="#profile" data-toggle="tab">Busca Avançada</a></li>
        </ul>
    </div>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="home">

            <form id="form" class="form-horizontal" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
                <input type="hidden" id="hdnAcao" name="hdnAcao" value="buscarSimples" />    

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
                        <label  for="sltQuarto">Quarto</label>
                        <select class="form-control" id="sltQuarto" name="sltQuarto">
                            <option value="">Informe Número de Quarto(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">+ de 05</option>
                        </select>
                    </div>


                </div>

                <hr />

                <div class="row">


                    <div class="col-lg-3">
                        <label  for="sltGaragem">Garagem</label>
                        <select class="form-control" id="sltGaragem" name="sltGaragem">
                            <option value="">Informe Número de Garagem(ns)</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">+ de 05</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltCidade">Cidade</label>
                        <select class="form-control" id="sltGaragem" name="sltCidade">
                            <option value="">Informe a Cidade</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="belem">Belém</option>
                            <option value="ananindeua">Ananindeua</option>
                            <option value="marituba">Marituba</option>
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
                        <button type="submit" class="btn btn-primary">Buscar Imóvel</button>
                    </div>

                </div>

                <hr />
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            
                        </div>
                    </div>
                </div>
                
        </div>
        </form>          



        <!--        <div class="row text-danger" id="divmsgerro" hidden="true"></div>-->
        <div class="tab-pane fade" id="profile">
            <form id="form" class="form-horizontal" action="index.php" method="post">
                <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
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
                        <label  for="sltQuarto">Quarto</label>
                        <select class="form-control" id="sltQuarto" name="sltQuarto">
                            <option value="">Informe Número de Quarto(s)</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">+ de 05</option>
                        </select>
                    </div>


                </div>

                <hr />

                <div class="row">

                    <div class="col-lg-3">
                        <label  for="sltGaragem">Garagem</label>
                        <select class="form-control" id="sltGaragem" name="sltGaragem">
                            <option value="">Informe Número de Garagem(ns)</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">+ de 05</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label  for="sltCidade">Cidade</label>
                        <select class="form-control" id="sltGaragem" name="sltCidade">
                            <option value="">Informe a Cidade</option>
                            <option value="nenhuma">Nenhuma</option>
                            <option value="belem">Belém</option>
                            <option value="ananindeua">Ananindeua</option>
                            <option value="marituba">Marituba</option>
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
                        <label  for="sltBanheiro">Banheiros</label>
                        <select class="form-control" id="sltGaragem" name="sltBairro">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">+ de 05</option>
                        </select>
                    </div>

                </div> 

                <hr />

                <div class="row">

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
                        <label  for="sltM2">M2</label>
                        <select class="form-control" id="sltM2" name="sltM2">
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
    <hr />

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">TESTE</button>
            </div>
        </div>
    </div>
    
</div>



<div id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1>PIP Encontre</h1>
                    <p>Seu im&oacute;vel est&aacute; aqui. <br> &Eacute; s&oacute; pesquisar pela palavra-chave ou ent&atilde;o pelas caracter&iacute;sticas desejadas.</p>
                    <p><a class="btn btn-large btn-primary" href="#">Encontre!</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <h1>PIP Anuncie</h1>
                    <p>Conhe&ccedil;a nossos planos de an&uacute;ncios. <br> Classic, Gold e Diamond.</p>
                    <p><a class="btn btn-large btn-primary" href="index.php?entidade=Plano&acao=listar">Anuncie!</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <h1>PIP Compartilhe</h1>
                    <p>Curta e Compartilhe nossa FanPage e fique ligado nas novidades pelo nosso Twitter.</p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->


<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <!-- Example row of columns -->

    <?php
    $item = $this->getItem();
    $count = 0;
    $anuncios = $item['anuncios'];
    if (count($anuncios) % 3 != 0) {
        //Append 1 or 2 items from start of array if needed
        $anuncios = array_merge($anuncios, array_slice($anuncios, 0, 3 - count($anuncios) % 3));
    }
    ?>

    <div class="row">
        <?php
        foreach ($anuncios as $anuncio) {
            if (($count > 0) and ($count % 3 == 0)) {
                ?>
            </div><div class="row">
                <?php
            }
            ?>
            <div class="col-lg-4">
                <h2><?php echo $anuncio->getTituloAnuncio(); ?></h2>
                <p><?php echo $anuncio->getDescricaoAnuncio(); ?>
                    <?php
                    if (count($anuncio->getImagem()) > 0) {
                        $imagem = $anuncio->getImagem();
                        $imagem = (is_array($imagem) ? $imagem[0] : $imagem);
                        echo '<img src="' . $imagem->getDiretorio() . '" width="250px" >';
                    }
                    ?>
                </p>

                <p><a class="btn btn-default" href="#">Veja mais detalhes &raquo;</a></p>
            </div>
            <?php
            $count++;
        }
        ?>
    </div>
</div>    


