<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/jquery.price_format.min.js"></script>

<style>

    #gallery { float: left; width: 88%; min-height: 12em; }
    .gallery.custom-state-active { background: #eee; }
    .gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; display: inline-table;}
    .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
    .gallery li img { width: 100%; cursor: move; }

    #trash { float: right; width: 12%; min-height: 35em; padding: 1%;}
    #trash .gallery table { display: none; }
    #trash .gallery h5 { display: none; }
    #trash li img { height: 72px; width: 96px; cursor: move; }

    /*            #gallery { float: left; width: 65%; min-height: 12em; }
                .gallery.custom-state-active { background: #eee; }
                .gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
                .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
                .gallery li a { float: right; }
                .gallery li a.ui-icon-zoomin { float: left; }
                .gallery li img { width: 100%; cursor: move; }*/

    /*            #trash { float: right; width: 32%; min-height: 18em; padding: 1%; }
                #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
                #trash h4 .ui-icon { float: left; }
                #trash .gallery h5 { display: none; }*/
</style>

<script>
    $(function() {
        // there's the gallery and the trash
        var $gallery = $("#gallery"),
                $trash = $("#trash");

        // let the gallery items be draggable
        $("li", $gallery).draggable({
            cancel: "a.ui-icon", // clicking an icon won't initiate dragging
            revert: "invalid", // when not dropped, the item will revert back to its initial position
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

        // let the trash be droppable, accepting the gallery items
        $trash.droppable({
            accept: "#gallery > li",
            activeClass: "ui-state-highlight",
            drop: function(event, ui) {
                deleteImage(ui.draggable);
            }
        });

        // let the gallery be droppable as well, accepting items from the trash
        $gallery.droppable({
            accept: "#trash li",
            activeClass: "custom-state-active",
            drop: function(event, ui) {
                recycleImage(ui.draggable);
            }
        });

        // image deletion function
        var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='glyphicon glyphicon-chevron-left'></a>";
        function deleteImage($item) {
            $item.fadeOut(function() {
                var $list = $("ul", $trash).length ?
                        $("ul", $trash) :
                        $("<ul class='gallery ui-helper-reset'/>").appendTo($trash);

                $item.find("a.glyphicon-chevron-right").remove();
                $item.append(recycle_icon).appendTo($list).fadeIn(function() {
//                            $item
//                                    .animate({width: "48px"})
//                                    .find("img")
//                                    .animate({height: "36px"});
                });
            });
        }

        // image recycle function
        var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='glyphicon glyphicon-chevron-right'></a>";
        function recycleImage($item) {
            $item.fadeOut(function() {
                $item
                        .find("a.glyphicon-chevron-left")
                        .remove()
                        .end()
                        .css("width", "96px")
                        .append(trash_icon)
                        .find("img")
                        .css("height", "72px")
                        .end()
                        .appendTo($gallery)
                        .fadeIn();
            });
        }

        // image preview function, demonstrating the ui.dialog used as a modal window
        function viewLargerImage($link) {
            var src = $link.attr("href"),
                    title = $link.siblings("img").attr("alt"),
                    $modal = $("img[src$='" + src + "']");

            if ($modal.length) {
                $modal.dialog("open");
            } else {
                var img = $("<img alt='" + title + "' width='384' height='288' style='display: none; padding: 8px;' />")
                        .attr("src", src).appendTo("body");
                setTimeout(function() {
                    img.dialog({
                        title: title,
                        width: 400,
                        modal: true
                    });
                }, 1);
            }
        }

        // resolve the icons behavior with event delegation
        $("ul.gallery > li").click(function(event) {
            var $item = $(this),
                    $target = $(event.target);

            if ($target.is("a.glyphicon-chevron-right")) {
                deleteImage($item);
            } else if ($target.is("a.ui-icon-zoomin")) {
                viewLargerImage($target);
            } else if ($target.is("a.glyphicon-chevron-left")) {
                recycleImage($item);
            }

            return false;
        });
    });
</script>
</head>
<body>

    <div class="ui-widget ui-helper-clearfix ui-state-default">

        <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
            <?php
            $item = $this->getItem();
            if ($item) {
                ?>

                <li class="ui-corner-tr">
                    <h5 class="ui-widget-header"><?php echo $item[0]->tituloanuncio ?></h5>
                    <!--<img src="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" alt="The peaks of High Tatras" width="96" height="72">-->

                    <?php
                    echo '<img src="' . $item[0]->diretorio . '" width="96" height="72"" >';
                    ?>
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
                                <td id="tdValor<?php echo $item[0]->id ?>"><?php echo $item[0]->valor ?></td>
                            </tr>
    <!--                            <tr>
                                <th>Diferenciais</th>
                                <td><?php
                            if ($item[0]->academia == "SIM") {
                                echo "<span class=glyphicon glyphicon-credit-card ui-state-disabled></span>";
                            }
                            ?>
                                    <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                    <span class="glyphicon glyphicon-credit-card ui-state-disabled"></span>
                                    <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                </td>
                            </tr>-->
                        </tbody>
                    </table>
                    <!--                    <a href="images/high_tatras3.jpg" title="View larger image" class="ui-icon ui-icon-zoomin">View larger</a>-->
                    <a href="link/to/trash/script/when/we/have/js/off" title="Delete this image" class="glyphicon glyphicon-chevron-right"></a>
                </li>
                <?php
            }
//}
            ?>

        </ul>

        <div id="trash" class="ui-widget-content ui-state-default">
            <h6 class="ui-widget-shadow">Anúncios</h6>
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
        <!--                            <img src="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" alt="The peaks of High Tatras" width="96" height="72">-->
                            <!--                            <a href="fotos/r7jstva4aqchie9n65c75k8te0/TerraMedia.png" title="View larger image" class="ui-icon ui-icon-zoomin">View larger</a>-->
                            <?php
                            echo '<img src="' . $anuncio->diretorio . '" width="96" height="72"" >';
                            ?>
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
                                        <td id="tdValor<?php echo $anuncio->id ?>"><?php echo $anuncio->valor ?></td>
                                    </tr>
        <!--                                    <tr>
                                        <th>Diferenciais</th>
                                        <td><?php
                                    if ($anuncio->academia == "SIM") {
                                        echo "<span class=glyphicon glyphicon-credit-card ui-state-disabled></span>";
                                    }
                                    ?>
                                            <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                            <span class="glyphicon glyphicon-credit-card ui-state-disabled"></span>
                                            <span class="glyphicon glyphicon-credit-card ui-state-active"></span>
                                        </td>
                                    </tr>-->
                                </tbody>
                            </table>
                            <a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='glyphicon glyphicon-chevron-left'></a>
                        </li>

                        <?php
                    }
                }
                ?>    

            </ul>
        </div>

    </div>
    
    <script>
    $(document).ready(function() {
        $("td[id^='tdValor']").priceFormat({
            prefix: 'R$ ',
            centsSeparator: ',',
            centsLimit: 0,
            limit: 8,
            thousandsSeparator: '.'
        })
    })
   </script>