<script type="text/javascript">
        $(document).ready(function() {
            $("span[data-toggle='tooltip']").tooltip();

            $('[id^=btnAnuncioModal]').click(function() {
                $("#lblAnuncioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
                $("#modal-body").html('<img src="assets/imagens/loading.gif" /><h2>Aguarde... Carregando...</h2>');
                $("#modal-body").load("index.php", {hdnEntidade: 'Imovel', hdnAcao: 'modal', hdnToken: '', hdnModal: $(this).attr('data-modal')});
            })
            $('[id^=btnExcluir]').click(function() {
                $("#lblNegocioModal").html("<span class='glyphicon glyphicon-bullhorn'></span> " + $(this).attr('data-title'));
                $("#hdnImovel").val($(this).attr('data-modal'));
            })

            $('#form').validate({
                submitHandler: function() {
                    $.ajax({
                        url: "index.php",
                        dataType: "json",
                        type: "POST",
                        data: $('#form').serialize(),
                        beforeSend: function() {
                            $('.alert').show();
                            $('#btnConfirmar').attr('disabled', 'disabled');
                            $('#btnCancelar').attr('disabled', 'disabled');
                        },
                        success: function(resposta) {
                            $(".alert").hide();
                            if (resposta.resultado == 1) {
                                $("#modal-body-negociacao").html('<div class="row text-success">\n\
                                                                <p class="text-center">Imóvel Excluido com Sucesso</p>\n\
                                                                </div>');
                                $('#btnConfirmar').remove();
                                $('#btnCancelar').remove();
                            } else {
                                $("#modal-body-negociacao").html('<div class="row text-danger">\n\
                                                                <h2 class="text-center">Tente novamente mais tarde!</h2>\n\
                                                                <p class="text-center">Houve um erro no processamento. </p>\n\
                                                                </div>');
                                $('#btnConfirmar').removeAttr("disable");
                            }
                        }
                    })
                    return false;
                }
            })
            $('#divNegocioModal').on('hidden.bs.modal', function(e) {
                window.location.reload();
            })
        });
    </script>

<div class="container">  
    
    <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?entidade=Usuario&acao=meuPIP">Meu PIP</a></li>
        <li class="active">Imóvel(is) para Alterar</li>
    </ol>
    
    <div class="alert">Escolha um Imóvel para Alterar</div>
    <form>   
        <table class="table table-hover">
            <thead>
                <tr>  
                    <th>Referência</th>
                    <th>Imóvel</th>
                    <th>Logradouro</th> 
                    <th>Bairro</th>
                    <th>Data Cadastro</th>
                </tr>
            </thead>
            <tbody>

    <?php
              
    $params = array(
    'mode'       => 'Sliding',
    'perPage'    => 5,
    'dela'       => 2,
    'itemData'   => $this->getItem());
    
    $pager = & Pager::factory($params);
    $data  = $pager->getPageData();

    Sessao::gerarToken(); 
    
    foreach($data as $imovel){?>
        <tr>        
        <?php
        echo "<td><span class=\"label label-info\">" . $imovel->Referencia() . "</span></td>";
        if(trim($imovel->getDescricao()) !=""){
            echo "<td>" . $imovel->getDescricao() . "</td>";
        }else echo "<td class='text-danger'>Nenhuma Identificação</td>";
        echo "<td>" . $imovel->getEndereco()->getLogradouro() . "</td>";
        echo "<td>" . $imovel->getEndereco()->getBairro()->getNome() . "</td>";
        echo "<td>" . $imovel->getDatahoracadastro() . "</td>";
        echo "<td><a href='#' id='popover".$imovel->getId()."'class='btn btn-success'><span class='glyphicon glyphicon-home'></span> Detalhes </a></td>";
       // echo "<td><a href='index.php?entidade=Imovel&acao=selecionar&id=".$imovel->getId()."&token=".$_SESSION['token']."' class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span> Editar</a> <br /></td>";
        if(count($imovel->getAnuncio())>0 && verificaAnuncioAtivo($imovel->getAnuncio())){echo"<td colspan='2'><span class='text-primary'><span class='glyphicon glyphicon-bullhorn'></span> Imóvel com anúncio ativo</span></td>";}
          else {
             echo "<td class='col-lg-1'><a href='index.php?entidade=Imovel&acao=selecionar&id=".$imovel->getId()."&token=".$_SESSION['token']."' class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span> Alterar</a> <br /></td>";    
             
             if(count($imovel->getAnuncio())>0){echo"<td><span class='text-primary'><span class='glyphicon glyphicon-bullhorn'></span> Imóvel possui anúncio. Não é possível excluir</span></td>";}
             else{
             echo "<td class='col-lg-2'><button type='button' id='btnExcluir".$imovel->getId()."' class='btn btn-danger' data-toggle='modal' data-target='#divNegocioModal'  data-modal='".$imovel->getId()."' data-title='".$imovel->Referencia()."'><span class='glyphicon glyphicon-remove'></span> Excluir </button></td>";}
             }
          }
    ?>             
        </tr>         
            </tbody>
        </table>
        &nbsp;
    <?php
    
    $links = $pager->getLinks();
    echo ($links['all']!="" ? "&nbsp;&nbsp;&nbsp;&nbsp;Página: ".$links['all'] : ""); 
    
    ?>
        
        <!-- Divs ocultas que serao exibidas dentro do popover. -->
       
    </form>
</div>
<?php   
        
        $item = $this->getItem();
        if ($item) {
            foreach ($item as $imovel) {
                ?>   
                <div id="popover<?php echo $imovel->getId(); ?>-content" class="hide">
                    <?php
                    	 
                    if($imovel->getTipo()!= "terreno"){
                    
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
                    }else{ //caso seja um terreno
                    echo "Tipo: " . $imovel->getTipo() . "<br />";
                    echo "Área: " . $imovel->getArea() . " m<sup>2</sup><br />";
                    }
                    ?>
                </div>
<?php }
        }
        ?>

<form id="form" class="form-horizontal" action="index.php" method="post">
        <div class="modal fade" id="divNegocioModal" tabindex="-1" role="dialog" aria-labelledby="lblNegocioModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="lblNegocioModal"></h2>
                    </div>
                    <div id="modal-body-negociacao" class="modal-body text-center">
                        <div class="alert alert-warning" style="display:none">Aguarde Processando...</div>
                        <strong>Confirmar a Exclusão do Imóvel?</strong>
                        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
                        <input type="hidden" id="hdnAcao" name="hdnAcao" value="excluir" />
                        <input type="hidden" id="hdnImovel" name="hdnImovel"/>
                        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION["token"]; ?>" />                      
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" name="btnCancelar" id="btnCancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btnConfirmar" id="btnConfirmar" class="btn btn-danger">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
        
<?php
function verificaAnuncioAtivo($listaAnuncios) {
   $temAnuncioAtivo = false;
   if (count($listaAnuncios) > 1) {
       foreach ($listaAnuncios as $anuncio) {
           if ($anuncio->getStatus() == "cadastrado")
               $temAnuncioAtivo = true;
       }
   } else {
       if ($listaAnuncios->getStatus() == "cadastrado")
           $temAnuncioAtivo = true;
   }
   return $temAnuncioAtivo;
}
?>