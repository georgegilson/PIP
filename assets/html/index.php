<!-- Carousel
 ================================================== -->
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


