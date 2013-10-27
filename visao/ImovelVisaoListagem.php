<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Listagem de Im&oacute;veis</h1>
    <!-- Example row of columns -->
    <div class="alert">Todos</div>
   
<table class="table table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>Valor</th>
            <th>Finalidade</th>
            <th>Quarto</th>
          </tr>
        </thead>
        <tbody>
       <?php
        
        if ($this->item){
            foreach ($this->item as $imovel) {
       ?>
       
          <tr>
            <td><?php echo $imovel->getId(); ?></td>
            <td><?php echo $imovel->getValor(); ?></td>
            <td><?php echo $imovel->getFinalidade(); ?></td>
            <td><?php echo $imovel->getQuarto(); ?></td>
          </tr>
        <?php } } else { ?>
          <tr> <td colspan="4">N&atilde;o h&aacute; registros</td> </tr>
        <?php } ?>
        </tbody>
      </table>