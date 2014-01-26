<link rel="stylesheet" href="assets/css/jquery-ui.css" type="text/css" />
<script src="assets/js/jquery-ui.js"></script>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <div class="page-header">
        <h1>Comparação de Imóveis</h1>
    </div>
    <style>
        #gallery { float: left; width: 65%; min-height: 12em; }
        .gallery.custom-state-active { background: #eee; }
        .gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; display: inline-table;}
        .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
        .gallery li img { width: 100%; cursor: move; }

        #trash { float: right; width: 32%; min-height: 18em; padding: 1%;}
        #trash .gallery table { display: none; }
        #trash .gallery h5 { display: none; }
        #trash li img { height: 36px; width: 48px; cursor: move; }
    </style>
    <script>
        $(document).ready(function() {

            var $gallery = $("#gallery"),
                    $trash = $("#trash");

            $("li", $gallery).draggable({
                revert: "invalid",
                containment: "document",
                helper: "clone",
                cursor: "move"
            });

            $("li", $trash).draggable({
                cancel: ".ui-state-disabled",
                revert: "invalid",
                containment: "document",
                helper: "clone",
                cursor: "move"
            });

            $trash.droppable({
                accept: "#gallery > li",
                activeClass: "ui-state-highlight",
                drop: function(event, ui) {
                    deleteImage(ui.draggable);
                    //        if ($("#gallery > li").length > 1) {
                    //                        $("#trashul").addClass("ui-state-disabled");
                    //                    }
                    ui.draggable
                            .find("img")
                            .tooltip({content: '<img src="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" />'});
                }
            });

            $gallery.droppable({
                accept: "#trash li",
                activeClass: "custom-state-active",
                drop: function(event, ui) {
                    recycleImage(ui.draggable);
                    //        if ($("#gallery > li").length == 1) {
                    //                        $("#trashul").removeClass("ui-state-disabled");
                    //                    }
                }
            });

            function deleteImage($item) {
                $item.fadeOut(function() {
                    var $list = $("ul", $trash).length ?
                            $("ul", $trash) :
                            $("<ul class='gallery ui-helper-reset connectedSortable'/>").appendTo($trash);

                    $item.appendTo($list).fadeIn(function() {
                        $item
                                .animate({width: "48px"})
                                .find("img")
                                .animate({height: "36px"});
                    });
                });
            }

            function recycleImage($item) {
                $item.fadeOut(function() {
                    $item
                            .css("width", "96px")
                            .find("img")
                            .css("height", "72px")
                            .end()
                            .appendTo($gallery)
                            .fadeIn();
                });

            }

        });
    </script>

    <div class="ui-widget ui-helper-clearfix ui-state-default">

        <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
            <?php
            $item = $this->getItem();
            if ($item) {
                ?>

                <li class="ui-corner-tr">
                    <h5 class="ui-widget-header"><?php echo $item[0]->tituloanuncio ?></h5>
                    <img src="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" alt="The peaks of High Tatras" width="96" height="72">

                    <table class="table table-bordered table-striped table-responsive">
                        <tbody>
                            <tr>
                                <th>Finalidade</th>
                                <td><?php echo $item[0]->finalidade ?></td>           
                            </tr>
                            <tr>
                                <th>Condição</th>
                                <td><?php echo $item[0]->condicao ?></td>
                            </tr>
                            <tr>
                                <th>Tipo</th>
                                <td><?php echo $item[0]->tipo ?></td>
                            </tr>
                            <tr>
                                <th>Área (m2)</th>
                                <td><?php echo $item[0]->area ?></td>
                            </tr>
                            <tr>
                                <th>Quartos</th>
                                <td><?php echo $item[0]->quarto ?></td>
                            </tr>
                            <tr>
                                <th>Banheiros</th>
                                <td><?php echo $item[0]->banheiro ?></td>
                            </tr>
                            <tr>
                                <th>Suites</th>
                                <td><?php echo $item[0]->suite ?></td>
                            </tr>
                            <tr>
                                <th>Garagem</th>
                                <td><?php echo $item[0]->garagem ?></td>
                            </tr>
                            <tr>
                                <th>Valor</th>
                                <td><?php echo $item[0]->valor ?></td>
                            </tr>
                            <tr>
                                <th>Diferenciais</th>
                                <td><?php if ($item[0]->academia == "SIM") {
                echo "<span class=glyphicon glyphicon-credit-card ui-state-disabled></span>";
            } ?>
                                    <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                    <span class="glyphicon glyphicon-credit-card ui-state-disabled"></span>
                                    <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                <?php
            }
//}
            ?>

        </ul>

        <div id="trash" class="ui-widget-content ui-state-default">
            <h4 class="ui-widget-header">Anúncios</h4>
            <ul id="trashul" class="gallery ui-helper-reset">
                <?php
                $item = $this->getItem();
                $teste = true;
                if ($item) {
                    foreach ($item as $anuncio) {
                        if ($teste) {
                            $teste = false;
                            continue;
                        }
                        ?>

                        <li class="ui-corner-tr">
                            <h5 class="ui-widget-header"><?php echo $anuncio->tituloanuncio ?></h5>
                            <img src="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" alt="The peaks of High Tatras" width="96" height="72">
<!--                            <a href="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" title="View larger image" class="ui-icon ui-icon-zoomin">View larger</a>-->
                            <table class="table table-bordered table-striped table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Finalidade</th>
                                        <td><?php echo $anuncio->finalidade ?></td>           
                                    </tr>
                                    <tr>
                                        <th>Condição</th>
                                        <td><?php echo $anuncio->condicao ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tipo</th>
                                        <td><?php echo $anuncio->tipo ?></td>
                                    </tr>
                                    <tr>
                                        <th>Área (m2)</th>
                                        <td><?php echo $anuncio->area ?></td>
                                    </tr>
                                    <tr>
                                        <th>Quartos</th>
                                        <td><?php echo $anuncio->quarto ?></td>
                                    </tr>
                                    <tr>
                                        <th>Banheiros</th>
                                        <td><?php echo $anuncio->banheiro ?></td>
                                    </tr>
                                    <tr>
                                        <th>Suites</th>
                                        <td><?php echo $anuncio->suite ?></td>
                                    </tr>
                                    <tr>
                                        <th>Garagem</th>
                                        <td><?php echo $anuncio->garagem ?></td>
                                    </tr>
                                    <tr>
                                        <th>Valor</th>
                                        <td><?php echo $anuncio->valor ?></td>
                                    </tr>
                                    <tr>
                                        <th>Diferenciais</th>
                                        <td><?php if ($anuncio->academia == "SIM") {
                            echo "<span class=glyphicon glyphicon-credit-card ui-state-disabled></span>";
                        } ?>
                                            <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                            <span class="glyphicon glyphicon-credit-card ui-state-disabled"></span>
                                            <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
        <?php
    }
}
?>    

            </ul>
        </div>

    </div>


</div>