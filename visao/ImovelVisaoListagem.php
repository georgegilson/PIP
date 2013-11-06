<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Listagem de Im&oacute;veis</h1>
    <!-- Example row of columns -->
    <div class="alert">Todos</div>
    <form>   
<table class="table table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>Finalidade</th>
            <th>Quarto(s)</th> 
            <th>Tipo</th>
            <th>Garagem(ns)</th>
            <th>Banheiro(s)</th>
            <th>Psicina</th>
            <th>Quadra</th>
            <th>Academia</th>
            <th>Dependencia Empregada</th>
            <th>Área Serviço</th>
            <th>Elevador</th>
            <th>Sacada</th>
            <th>Área</th>
            <th>Suíte(s)</th>
            <th>Data do Cadastro</th>
            <th>Data da Última Alteração</th>
          </tr>
        </thead>
        <tbody>
       <?php
       $item = $this->getItem();
        if ($item){
            foreach ($item as $imovel) {
        ?>
       
          <tr>
            <td><?php echo $imovel->getId(); ?></td>
            <td><?php echo $imovel->getFinalidade(); ?></td>
            <td><?php echo $imovel->getQuarto(); ?></td>
            <td><?php echo $imovel->getTipo(); ?></td>
            <td><?php echo $imovel->getGaragem(); ?></td>
            <td><?php echo $imovel->getBanheiro(); ?></td>
            <td><?php echo $imovel->getPiscina(); ?></td>
            <td><?php echo $imovel->getQuadra(); ?></td>
            <td><?php echo $imovel->getAcademia(); ?></td>
            <td><?php echo $imovel->getDependenciaEmpregada(); ?></td>
            <td><?php echo $imovel->getAreaServico(); ?></td>
            <td><?php echo $imovel->getElevador(); ?></td>
            <td><?php echo $imovel->getSacada(); ?></td>
            <td><?php echo $imovel->getArea(); ?></td>
            <td><?php echo $imovel->getSuite(); ?></td>
            <td><?php echo $imovel->getDatahoracadastro(); ?></td>
            <td><?php echo $imovel->getDatahoraalteracao(); ?></td>
            <td><a href="index.php?entidade=Imovel&acao=selecionar&id=<?php echo $imovel->getId();?>">Editar</a> <br /></td>
            <td><a href="index.php?entidade=Imovel&acao=publicar&id=<?php echo $imovel->getId();?>">Publicar Anuncio</a> <br /></td>
          </tr>
        <?php } } else { ?>
          <tr> <td colspan="4">N&atilde;o h&aacute; registros</td> </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>