<div class="container">    
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li class="active">Publicar Anúncio</li>
    </ol>
    <?php
    $item = $this->getItem();
    if (!$item) {
        ?>
        <span class="text-info"><strong>Seus imóveis já possuem anúncio. Cadastre um novo imóvel para anunciar.</strong></span>
    <?php } else { ?>
        <form>   
            <table class="table table-hover table-responsive table-condensed">
                <thead>
                    <tr>  
                        <th>Referência</th>
                        <th>Tipo</th>
                        <th>Imóvel</th>
                        <th>Endereço</th>
                        <th>Data Cadastro</th>
                        <th class="text-center" colspan="2">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $params = array(
                        'mode' => 'Sliding',
                        'perPage' => 5,
                        'dela' => 2,
                        'itemData' => $this->getItem());

                    $pager = & Pager::factory($params);
                    $data = $pager->getPageData();
                    Sessao::gerarToken();
                    foreach ($data as $imovel) {
                        ?>
                        <tr>        
                            <?php
                            echo "<td><span class=\"label label-info\">" . $imovel->Referencia() . "</span></td>";
                            echo "<td><span class=\"label label-warning\">" . $imovel->getTipo() . "</span></td>";
                            if (trim($imovel->getDescricao()) != "") {
                                echo "<td>" . $imovel->getDescricao() . "</td>";
                            }
                            else
                                echo "<td class='text-danger'>Nenhuma Identificação</td>";
                            echo "<td>" . $imovel->getEndereco()->getLogradouro() . ", " . $imovel->getEndereco()->getBairro()->getNome() . "</td>";
                            echo "<td>" . $imovel->getDatahoracadastro() . "</td>";
                            echo "<td><a href='#' id='popover" . $imovel->getId() . "'class='btn btn-success'><span class='glyphicon glyphicon-home'></span> Detalhes do Imóvel</a></td>";
                            if (count($imovel->getAnuncio()) == 0) {
                                echo"<td><a href='index.php?entidade=Anuncio&acao=form&idImovel=" . $imovel->getId() . "&token=" . $_SESSION['token'] . "' class='btn btn-info'><span class='glyphicon glyphicon-bullhorn'></span> Publicar Anúncio</a></td>";
                            }
                        }
                        ?>             
                    </tr>         
                </tbody>
            </table>
            &nbsp;
            <?php
            $links = $pager->getLinks();
            echo ($links['all'] != "" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: " . $links['all'] : "");
            ?>
        </form>
    </div>
    <?php
    foreach ($item as $imovel) {
        ?>   
        <div id="popover<?php echo $imovel->getId(); ?>-content" class="hide">
            <?php
            if ($imovel->getTipo() != "terreno") {

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
                    echo "Elevador: " . (($imovel->getElevador() == "SIM") ? '<span class="text-primary">' . $imovel->getElevador() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Sacada: " . (($imovel->getSacada() == "SIM") ? '<span class="text-primary">' . $imovel->getSacada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Cobertura: " . (($imovel->getCobertura() == "SIM") ? '<span class="text-primary">' . $imovel->getCobertura() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
                    echo "Condomínio: " . (($imovel->getCondominio() != "") ? '<span class="text-primary">' . $imovel->getCondominio() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                    echo "Andar: " . (($imovel->getAndar() != "") ? '<span class="text-primary">' . $imovel->getAndar() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
                }
            } else { //caso seja um terreno
                echo "Tipo: " . $imovel->getTipo() . "<br />";
                echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
            }
            ?>
        </div>
        <?php
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

<?php }
?>