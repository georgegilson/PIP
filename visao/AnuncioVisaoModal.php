<?php
$item = $this->getItem();
$anuncio = $item["anuncio"][0];
$imovel = $item["imovel"][0];
$endereco = $item["endereco"][0];
$usuario = $item["usuario"][0];
//echo "<pre>";print_r($item);die();
?>
<script src="assets/js/gridforms.js"></script>
<div class="row">
    <div class="col-xs-6">
        foto
    </div>
    <div class="col-xs-6">
        <form class="grid-form">
            <div data-row-span="1">
                <div data-field-span="1">
                    <label>Descrição</label>
                    <?php echo $anuncio->getDescricaoanuncio(); ?>
                </div>
            </div>
            <div data-row-span="1">
                <div data-field-span="1">
                    <label>Valor</label>
                    R$ <?php echo $anuncio->getValor(); ?>
                </div>
            </div>
            
            <?php 
            $valoresVisiveis = $anuncio->getValorvisivel();
            if($valoresVisiveis != ""){
                $valoresVisiveis = (json_decode($valoresVisiveis));
                foreach($valoresVisiveis as $campo){
                    ?>
            <div data-row-span="1">
                <div data-field-span="1">
                    <label><?php echo $campo; ?></label>
                    <?php $get = "get".ucfirst($campo); echo $imovel->$get(); ?>
                </div>
            </div>
            <?php
                }
            }            
            ?>
            
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Localização</div>
                    
                    <?php if($anuncio->getPublicarmapa() == "SIM") { ?>
                    mapa
                    <?php } else  { ?>
                    so endereço
                    <?php } ?>
        </div>
    </div>
    <div class="col-xs-6">
        <div id="forms" class="panel panel-default">
            <div class="panel-heading">Entre em Contato</div>
            s
        </div>
    </div>
 </div>
