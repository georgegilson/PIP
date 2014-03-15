<div class="container">    
    <div class="page-header">
        <h1>Mensagens</h1>
    </div>
    <!--<form>-->   
<!--        <table class="table table-hover">
            <thead>
                <tr>  
                    <th>Nome</th>
                    <th>Assunto</th>
                    <th>Data</th> 
                </tr>
            </thead>
            <tbody>-->
        <div class="panel-group col-lg-8" id="accordion">
    <?php
                
    $params = array(
    'mode'       => 'Sliding',
    'perPage'    => 5,
    'dela'       => 2,
    'itemData'   => $this->getItem());
    
    $pager = & Pager::factory($params);
    $data  = $pager->getPageData();
    Sessao::gerarToken();
    
    foreach($data as $mensagem){?>
<!--        <tr>-->
        <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">    
        <?php
       echo "<a data-toggle=collapse data-parent=#accordion href=#collapse" . $mensagem->getId() . ">";
         echo $mensagem->getNome();
         ?>          
        </a>
      </h4>
    </div>  
        <?php echo  "<div id=collapse" . $mensagem->getId() . " class='panel-collapse collapse'>"; ?>
            <div class="panel-body">
            <?php echo $mensagem->getMensagem(); ?> 
                <br><br>
            <a href="#" class='btn btn-primary'>Responder</a> 
            <a href='#' id='popover".$mensagem->getId()."'class='btn btn-success'><span class='glyphicon glyphicon-home'></span> Anúncio</a>
           </div>
    </div>
  </div>
    <?php         
    }
    ?>             
<!--        </tr>         
            </tbody>
        </table>
        &nbsp;-->
</div>
    <?php
    
    $links = $pager->getLinks();
    echo ($links['all']!="" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: ".$links['all'] : ""); 
    
    ?>
        
        <!-- Divs ocultas que serao exibidas dentro do popover. -->
       
    <!--</form>-->
<!--</div>-->
<?php
        $item = $this->getItem();
        if ($item) {
            foreach ($item as $mensagem) {
                ?>   
                <div id="popover<?php echo $mensagem->getId(); ?>-content" class="hide">
                    //<?php
                    	 
                    echo "Título: " . $mensagem->getTituloAnuncio() . "<br />";
                    echo "Valor: " . $mensagem->getValor() . "<br />";
                    echo "Descrição: " . $imovel->getDescricaoAnuncio() . "<br />";
//                    echo "Banheiro(s): " . $imovel->getBanheiro() . "<br />";
//                    echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
//                    echo "Suite(s): " . (($imovel->getSuite() != "nenhuma") ? '<span class="text-primary">' . $imovel->getSuite() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                    echo "Piscina: " . (($imovel->getPiscina() == "SIM") ? '<span class="text-primary">' . $imovel->getPiscina() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                    echo "Quadra: " . (($imovel->getQuadra() == "SIM") ? '<span class="text-primary">' . $imovel->getQuadra() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                    echo "Academia: " . (($imovel->getAcademia() == "SIM") ? '<span class="text-primary">' . $imovel->getAcademia() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                    echo "Área Serviço: " . (($imovel->getAreaServico() == "SIM") ? '<span class="text-primary">' . $imovel->getAreaServico() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                    echo "Dependencia: " . (($imovel->getDependenciaEmpregada() == "SIM") ? '<span class="text-primary">' . $imovel->getDependenciaEmpregada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//
//                    if ($imovel->getTipo() == "apartamento") {
//                        echo "Sacada: " . (($imovel->getSacada() == "SIM") ? '<span class="text-primary">' . $imovel->getSacada() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                        echo "Cobertura: " . (($imovel->getCobertura() == "SIM") ? '<span class="text-primary">' . $imovel->getCobertura() . '</span>' : '<span class="text-danger">NÃO</span>') . '<br />';
//                        echo "Condomínio: " . (($imovel->getCondominio() != "") ? '<span class="text-primary">' . $imovel->getCondominio() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
//                        echo "Andar: " . (($imovel->getAndar() != "") ? '<span class="text-primary">' . $imovel->getAndar() . '</span>' : '<span class="text-danger">Não Informado</span>') . '<br />';
//                    }
                    ?>
                </div>
<?php }
        }
        ?>
</div>
<script type="text/javascript">
            $(document).ready(function() {
                // Associa o evento do popover ao clicar no link.
                $("a[id^='popover']").popover({
                    trigger: 'hover',
                    html: true,
                    title: 'Anúncio Relacionado',
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

