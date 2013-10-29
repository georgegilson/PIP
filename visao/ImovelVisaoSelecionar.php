
<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    <h1>Cadastrar Im&oacute;veis</h1>
    
    <?php
        
        if ($this->item){
            foreach ($this->item as $imovel) {
        
       ?>
    
    <!-- Example row of columns -->
    <div class="alert">Preencha os campos abaixo</div>
    
    <form id="form">
        <input type="hidden" id="hdnId" name="hdnId" value="<?php $imovel->getId()?>"/>
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Imovel"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="editar" />
        <div class="form-group">
            <label class="control-label" for="txtValor">Valor</label>
            <div class="col-lg-1">
                <input type="text" id="txtValor" name="txtValor" class="form-control" 
                placeholder="Informe o valor" value="<?php echo $imovel->getValor();?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label" for="sltFinalidade">Finalidade</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltFinalidade" name="sltFinalidade">
                    
                    <?//php for($x = 0; $x<=1; $x++){
                        
                    
                    ?>
                    
                    <option value="">Informe a Finalidade</option>
                    <option <?php if($imovel->getFinalidade()=="venda"){print "selected='true'";}?>value="venda">Venda</option>
                    <option <?php if($imovel->getFinalidade()=="aluguel"){print "selected='true'";}?>value="aluguel">Aluguel</option>
                    
                    <?php //} ?>
                    
                </select></div>
        </div>
        <div class="form-group">
            <label  class="control-label" for="sltQuarto">Quartos</label>
            <div class="col-lg-3">
                <select class="form-control" id="sltQuarto" name="sltQuarto">
                    <option value="">Informe a quantidade de quartos</option>
                    <option <?php if($imovel->getQuarto()=="01"){print "selected='true'";}?> value="01">01</option>
                    <option <?php if($imovel->getQuarto()=="02"){print "selected='true'";}?>value="02">02</option>
                    <option <?php if($imovel->getQuarto()=="03"){print "selected='true'";}?>value="03">03</option>
                    <option <?php if($imovel->getQuarto()=="04"){print "selected='true'";}?>value="04">04</option>
                    <option <?php if($imovel->getQuarto()=="05"){print "selected='true'";}?>value="05">05</option>
                    <option <?php if($imovel->getQuarto()=="06"){print "selected='true'";}?>value="06">+ de 05</option>
                </select></div>
        </div>
        <?php } } ?>
<!--        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltSuite">Suites</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Suite</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtArea">&Aacute;rea (m<sup>2</sup>)</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtArea" placeholder="Informe a &Aacute;rea"> 
            </div>
        </div>
        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltSuite">Suites</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Suite</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>


        <div class="form-group">
            <label  class="col-lg-2 control-label" for="sltGaragem">Garagem</label>
            <div class="col-lg-3">
                <select class="form-control">
                    <option>Informe a quantidade de Garagem</option>
                    <option>00</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>+ de 05</option>
                </select></div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtTopicoImovel">T&oacute;pico do Im&oacute;vel</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtTopicoImovel" placeholder="Informe o T&oacut&oacute;pico do Im&oacute;vel">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtDescricaoImovel">Descri&ccedil;&atilde;o do Im&oacute;vel</label>
            <div class="col-lg-3">
                <textarea class="form-control" id="txtDescricaoImovel" placeholder="Informe a Desc"> </textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtCEP">CEP</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtCEP" placeholder="Informe CEP">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtBuscaAvancada">Busca Avan&ccedil;ada</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtBuscaAvancada" placeholder="Informe os termos para Busca Avan&ccedil;ada">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="txtCEP">CEP</label>
            <div class="col-lg-3">
                <input type="text" class="form-control" id="txtCEP" placeholder="Informe CEP">
            </div>
        </div>
-->
        <div class="row">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>

    </form>
