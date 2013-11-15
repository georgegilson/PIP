<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Listagem de Im&oacute;veis</h1>
    <!-- Example row of columns -->
    <div class="alert">Todos</div>
    <form>   
<table class="table table-hover">
        <thead>
          <tr>
            <th>Referência</th>
            <th>Descrição</th>
            <th>Logradouro</th> 
            <th>Bairro</th>
            <th>Data Cadastro</th>
          </tr>
        </thead>
        <tbody>
       <?php
       $item = $this->getItem();
        if ($item){
            foreach ($item as $imovel) {
        ?>
          <tr>
              <td><?php echo substr($imovel->getDatahoracadastro(), 6, -9).substr($imovel->getDatahoracadastro(), 3, -14).str_pad($imovel->getId(), 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $imovel->getDescricao(); ?></td>
            <td><?php echo $imovel->getEndereco()->getLogradouro();?></td>
            <td><?php echo $imovel->getEndereco()->getBairro(); ?></td>
            <td><?php echo $imovel->getDatahoracadastro(); ?></td>
            <td><a href="#" id="a-popover<?php echo $imovel->getId();?>" class="btn btn-success">Detalhes do Imóvel</a></td>
            <td><a href="index.php?entidade=Imovel&acao=selecionar&id=<?php echo $imovel->getId();?>">Editar</a> <br /></td>
            <td><a href="index.php?entidade=Imovel&acao=publicar&id=<?php echo $imovel->getId();?>">Publicar Anuncio</a> <br /></td>
          </tr>
         
<!-- Div oculta que será exibida dentro do popover. -->
<div id="div-popover<?php echo $imovel->getId();?>" class="hide">
   <?php echo "Tipo: ".$imovel->getTipo()."<br />";?>
   <?php echo "Quartos: ".$imovel->getQuarto()."<br />";?>
   <?php echo "Garagen(s): ".$imovel->getQuarto()."<br />";?>
   <?php echo "Banheiro(s): ".$imovel->getBanheiro()."<br />";?>
   <?php echo "Área: ".$imovel->getArea()." m2<br />";?>
   <?php if($imovel->getSuite()!="nenhuma"){echo "Suite(s): ".$imovel->getSuite()."<br />";} else echo "Suite(s): <font color='red'>NÃO</font><br />";?>
   <?php if($imovel->getPiscina()=="SIM"){echo "Piscina: <font color='blue'>SIM</font><br />";}else echo "Piscina: <font color='red'>NÃO</font><br />";?>
   <?php if($imovel->getQuadra()=="SIM"){echo "Quadra: <font color='blue'>SIM</font><br />";}else echo "Quadra: <font color='red'>NÃO</font><br />";?>
   <?php if($imovel->getAcademia()=="SIM"){echo "Academia: <font color='blue'>SIM</font><br />";}else echo "Academia: <font color='red'>NÃO</font><br />";?>
   <?php if($imovel->getAreaServico()=="SIM"){echo "Área Serviço:  <font color='blue'>SIM</font><br />";}else echo "Área Serviço: <font color='red'>NÃO</font><br />";?>
   <?php if($imovel->getDependenciaEmpregada()=="SIM"){echo "Dependencia: <font color='blue'>SIM</font><br />";}else echo "Dependencia: <font color='red'>NÃO</font><br />";?>

</div>
 
 <script type="text/javascript">
   $(document).ready(function () {
      // Associa o evento do popover ao clicar no link.
      $('#a-popover<?php echo $imovel->getId();?>').popover({
         trigger: 'hover',
         html: true,
         title: 'Detalhes do Imóvel',
         content: $('#div-popover<?php echo $imovel->getId();?>').html() // Adiciona o conteúdo da div oculta para dentro do popover.
      }).click(function (e) {
         e.preventDefault();
         // Exibe o popover.
         $(this).popover('show');
      });

   });
 </script>
          
        <?php } } else { ?>
        
        <?php } ?>
        </tbody>
      </table>
       
 