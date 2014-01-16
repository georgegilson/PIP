
<?php
$item = $this->getItem();
if ($item) {
    foreach ($item as $anuncio) {
        ?>
        <div class="table-responsive col-lg-2">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>   
                        <th>
                            <?php echo $anuncio->tituloanuncio ?>             
                        </th>            
                    </tr>
                </thead>

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
                </tbody>
            </table>
        </div>
        <?php
    }
}
?>

