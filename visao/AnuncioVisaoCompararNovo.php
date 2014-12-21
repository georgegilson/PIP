<script src="assets/js/jquery.price_format.min.js"></script>
       <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
       <script src="assets/js/gmaps.js"></script>

<div class="container">
    <br><br>
<!--<h3 id="thumbnails-custom-content">Custom content</h3>
  <p>With a bit of extra markup, it's possible to add any kind of HTML content like headings, paragraphs, or buttons into thumbnails.</p>-->
    <div class="row">
 <?php
            $item = $this->getItem();            
            if ($item) {
                function comparaValores($valor, $criterio, $anuncios){
                    $valores = array();
                    foreach ($anuncios as $anuncio) {
                        array_push($valores, $anuncio->$criterio);    
                    }
                    $indices = array_keys($valores, $valor);
                    if(count($indices) >= 2){
                        return TRUE;
                    }else {return false;}
                }
                
                foreach ($item as $anuncio) {
                    $referencia = substr($anuncio->datahoracadastro, 6, -9) . substr($anuncio->datahoracadastro, 3, -14) . str_pad($anuncio->idimovel, 5, "0", STR_PAD_LEFT);
                    
                ?>

        <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <?php
                    echo '<img src="' . $anuncio->diretorio . '" width="180px" height="180px" style="
    width: 180px;
    height: 180px; ">';
                    ?>
          <div class="caption"> 
            <h3><?php echo $anuncio->tituloanuncio?></h3>
            <div class="list-group">
            <a class=" <?php if (comparaValores($anuncio->finalidade, "finalidade", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->finalidade?></span>Finalidade</a>
            <a class="<?php if (comparaValores($anuncio->condicao, "condicao", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->condicao ?></span>Condição</a>
            <a class="<?php if (comparaValores($anuncio->tipo, "tipo", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->tipo ?></span>Tipo</a>
            <a class="<?php if (comparaValores($anuncio->area, "area", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->area ?></span>Área (m2)</a>
            <a class="<?php if (comparaValores($anuncio->quarto, "quarto", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->quarto ?></span>Quartos</a>
            <a class="<?php if (comparaValores($anuncio->banheiro, "banheiro", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->banheiro ?></span>Banheiros</a>
            <a class="<?php if (comparaValores($anuncio->suite, "suite", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->suite ?></span>Suites</a>
            <a class="<?php if (comparaValores($anuncio->garagem, "garagem", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span class="badge"><?php echo $anuncio->garagem ?></span>Garagem</a>
            <a class="<?php if (comparaValores($anuncio->valor, "valor", $item)){print "list-group-item list-group-item-success";}else{print "list-group-item list-group-item-danger";}?>"><span id="tdValor<?php echo $anuncio->id ?>" class="badge"><?php echo $anuncio->valor ?></span>Valor</a>
            </div>
            <p><button type="button" id="btnAnuncioModal<?php echo $referencia; ?>" class="btn btn-default btn-sm" data-toggle="modal" data-target="#divAnuncioModal" data-modal="<?php echo $anuncio->idanuncio; ?>" data-title="<?php echo $anuncio->tituloanuncio; ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span> Veja mais detalhes
                    </button> </p>
          </div>
        </div>
      </div>
      <?php
                }
                    }
                ?> 
    </div>
  </div><!-- /.bs-example -->
  
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
        $("span[id^='tdValor']").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })
        $('[id^=btnAnuncioModal]').click(function() {
            $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
            $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
            $("#modal-body").load("index.php", {hdnEntidade:'Anuncio', hdnAcao:'modal', hdnToken:'<?php //Sessao::gerarToken(); echo $_SESSION["token"]; ?>', hdnModal:$(this).attr('data-modal')});
        })
    })
   </script>
