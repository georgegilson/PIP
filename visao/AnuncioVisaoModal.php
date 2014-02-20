<!-- INICIO DO MAPA --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="assets/js/gmaps.js"></script>
<!-- FIM DO MAPA --> 
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
    <div class="col-xs-8">
        foto
    </div>
    <div class="col-xs-4">
        <form class="grid-form">
            <div data-row-span="1">
                <div data-field-span="1">
                    <label>Descrição</label>
                    <?php echo $anuncio->getDescricaoanuncio(); ?>
                </div>
            </div>

            <?php
            //valor do anuncio
            if ($anuncio->getValor() != "") {
                ?>
                <div data-row-span="1">
                    <div data-field-span="1">
                        <label>Valor</label>
                        R$ <?php echo $anuncio->getValor(); ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            //valores visiveis
            $valoresVisiveis = $anuncio->getValorvisivel();
            if ($valoresVisiveis != "") {
                $valoresVisiveis = (json_decode($valoresVisiveis));
                foreach ($valoresVisiveis as $campo) {
                    if ($campo != "multiselect-all") {
                        ?>
                        <div data-row-span="1">
                            <div data-field-span="1">
                                <label><?php echo $campo; ?></label>
                                <?php
                                $get = "get" . ucfirst($campo);
                                echo $imovel->$get();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
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

            <?php if ($anuncio->getPublicarmapa() == "SIM") { ?>
                <div class="popin">
                    <div id="map"></div>
                </div>
            <?php } else { ?>
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
<script>
    $(document).ready(function() {
        var endereco = "<?php echo $endereco->enderecoMapa(); ?>";
        //######### INICIO DO CEP ########
        map = new GMaps({
            div: '#map',
            lat: 0,
            lng: 0
        });
        GMaps.geocode({
            address: endereco.trim(),
            callback: function(results, status) {
                console.log(map);
                if (status == 'OK') {
                    var latlng = results[0].geometry.location;
                    map.setCenter(latlng.lat(), latlng.lng());
                    map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });
                }
            }
        });
    });

</script>