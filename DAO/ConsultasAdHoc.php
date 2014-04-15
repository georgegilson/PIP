<?php

class ConsultasAdHoc extends GenericoDAO {

    public function ConsultarPlanosComprados($ids) {
        $allow = $ids;
        $sql = sprintf(
                "SELECT * FROM plano WHERE id in( %s )", implode(
                        ',', array_map(
                                function($v) {
                            static $x = 0;
                            return ':allow_' . $x++;
                        }, $allow
                        )
                )
        );
        $statement = $this->conexao->prepare($sql);
        foreach ($allow as $k => $v) {
            $statement->bindValue('allow_' . $k, $v);
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ConsultarAnunciosPorUsuario($idUsuario) {
        $sql = "SELECT a.* "
                . " FROM anuncio a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN usuario u ON up.idusuario = u.id"
                . " WHERE u.status = 'ativo'"
                . " AND a.status = 'cadastrado'"
                . " AND u.id = :idUsuario ";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "Anuncio");
        return $resultado;
    }

    public function ConsultarImoveisNaoAnunciadosPorUsuario($idUsuario) {
        $sql = "SELECT i.* "
                . " FROM imovel i"
                . " WHERE i.idusuario = :idUsuario "
                . " AND NOT EXISTS ( "
                . " SELECT 1 FROM anuncio a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN usuario u ON up.idusuario = u.id"
                . " WHERE u.status = 'ativo'"
                . " AND a.status = 'cadastrado'"
                . " AND a.idimovel = i.id"
                . " AND u.id = :idUsuario "
                . " ) ";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "Imovel");
        return $resultado;
    }

    public function ConsultarRegistroAtivoDeRecuperarSenha($idUsuario) {
        $sql = "SELECT r.* "
                . " FROM recuperasenha r"
                . " WHERE r.status = 'ativo'"
                . " AND r.idusuario = :idUsuario ";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "RecuperaSenha");
        return $resultado;
    }

    public function ConsultarAnunciosPublicos($ids) {
        $allow = $ids;
        $sql = sprintf(
                "SELECT * "
                . " FROM anuncio a"
                . " JOIN imovel i ON a.idimovel = i.id"
                . " JOIN imagem im ON a.id = im.idanuncio"
                . " WHERE im.destaque = 'SIM'"
                . " AND a.id in( %s )", implode(
                        ',', array_map(
                                function($v) {
                            static $x = 0;
                            return ':allow_' . $x++;
                        }, $allow
                        )
                )
        );
        $statement = $this->conexao->prepare($sql);
        foreach ($allow as $k => $v) {
            $statement->bindValue('allow_' . $k, $v);
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

        public function buscarImovel($parametros) {
        $parametro = array_slice($parametros, 0);

        $fromInicial = " SELECT i.*,im.*,a.*, b.nome as bairro, c.nome as cidade, e.logradouro, e.numero FROM anuncio a, imovel i, "
                      . "usuario u, endereco e, imagem im, bairro b, cidade c ";

//        if (!empty($parametro["sltCidade"]) && empty($parametro["sltBairro"])) {
//            $fromCidade = ", cidade c ";
//            $fromInicial = $fromInicial . $fromCidade;
//        }
//
//        if (!empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) {
//
//            $fromCidadeBairro = " cidade c, bairro b ";
//            $fromInicial = $fromInicial . $fromCidadeBairro;
//        }

        $sql = $fromInicial . "
                            WHERE 
                            a.idimovel = i.id 
                            AND i.idusuario = u.id 
                            AND i.idendereco = e.id
                            AND a.id = im.idanuncio
                            AND a.status = 'cadastrado'
                            AND e.idbairro = b.id
                            AND e.idcidade = c.id
                            AND im.destaque = 'SIM'";

        if (isset($parametro["chkGaragem"])) {
            $sqlGaragem = " AND i.garagem in ('01', '02', '03', '04', '05', '06')";
        } else
            $sqlGaragem = " AND i.garagem = 'nenhuma'";

        $sql = $sql . $sqlGaragem;


        //    $sqlFinalidade = " AND i.finalidade = :finalidade";
        $sqlTipo = " AND i.tipo = :tipo";
        $sqlQuarto = " AND i.quarto = :quarto";
        $sqlBanheiro = " AND i.banheiro = :banheiro";
        $sqlCidade = " AND e.idcidade = c.id AND c.id = :cidade";
        $sqlCidadeBairro = " AND e.idbairro = b.id AND b.id = :bairro";

        if ($parametro["sltValorVenda"] != null && $parametro["sltValorAluguel"] == null) {

            if ($parametro["sltValorVenda"] == 20000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor < 40000";
            }

            if ($parametro["sltValorVenda"] == 500000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor > 500000";
            }

            if ($parametro["sltValorVenda"] != 20000 && $parametro["sltValorVenda"] != 500000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor >= " . $parametro["sltValorVenda"] . " AND a.valor <= " . $parametro["sltValorVenda"] . " + 20000";
            }
        }

        if ($parametro["sltValorAluguel"] != null && $parametro["sltValorVenda"] == null) {

            if ($parametro["sltValorAluguel"] == 100) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor < 200";
            }

            if ($parametro["sltValorAluguel"] == 4000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor > 4000";
            }

            if ($parametro["sltValorAluguel"] != 100 && $parametro["sltValorAluguel"] != 4000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor >= " . $parametro["sltValorAluguel"] . " AND a.valor <= " . $parametro["sltValorAluguel"] . " + 200";
            }
        }

        if ($parametro["sltFinalidade"] != null && $parametro["sltValorAluguel"] == null && $parametro["sltValorVenda"] == null) {

            $sqlFinalidadeValor = " AND i.finalidade = :finalidade";
        }

        $parametro["sltValorAluguel"] = $parametro["sltValor"];
        $parametro["sltValorVenda"] = $parametro["sltValor"];

//       foreach($parametros as $postValor){
//            
//            if(!empty($postValor) && $postValor != "Anuncio" && $postValor != "buscar"){
//            print "Valor: ".$postValor."<br/>";
//            
//            }
//            
//        }
//        
//        die();
//      

        $statement = $this->conexao->prepare($sql);

        if (!empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidade"]) && empty($parametro["sltValor"])) { //apenas a finalidade preenchida
            $sqlFinal = $sql . $sqlFinalidadeValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
        }

        if (!empty($parametro["sltTipo"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidade"]) && empty($parametro["sltValor"])) { //apenas o tipo preenchido
            $sqlFinal = $sql . $sqlTipo;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
        }

        if (!empty($parametro["sltQuarto"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidade"]) && empty($parametro["sltValor"])) { //apenas o quarto preenchido
            $sqlFinal = $sql . $sqlQuarto;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltBanheiro"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltCidade"]) && empty($parametro["sltValor"])) { //apenas o banheiro preenchido
            $sqlFinal = $sql . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltCidade"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltValor"])) { //apenas a cidade preenchida
            $sqlFinal = $sql . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltValor"])) { //apenas a cidade e o bairro preenchidos
            $sqlFinal = $sql . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltValor"]) && empty($parametro["sltCidade"]) && empty($parametro["sltBairro"]) && empty($parametro["sltFinalidade"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"])) { //apenas o valor preenchido
            $sqlFinal = $sql . $sqlValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }


        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"])) { //finalidade e tipo preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlTipo;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
        }



        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltQuarto"])) { //finalidade e quarto preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlQuarto;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltBanheiro"])) { //finalidade e banheiro preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltCidade"])) { //finalidade e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) { //finalidade, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltValor"])) { //finalidade e valor preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            //    $statement->bindParam(':valor', $parametro["sltValorVenda"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"])) { //tipo e quarto preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlQuarto;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"])) { //tipo e banheiro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidade"])) { //tipo e cidade preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) { //tipo, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltValor"])) { //tipo e valor preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"])) { //quarto e banheiro preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidade"])) { //quarto e cidade preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) { //quarto, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltValor"])) { //quarto e cidade preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"])) { //finalidade, tipo e quarto preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"])) { //finalidade, tipo, quarto e banheiro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidade"])) { //finalidade, tipo, quarto, banheiro e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) { //finalidade, tipo, quarto, banheiro, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltValor"])) { //finalidade, tipo, quarto, banheiro, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    public function buscarAvancado($parametros) {
        
        $parametro = array_slice($parametros, 0);
        
        $fromInicial = " SELECT i.*,im.*,a.*, b.nome as bairro, c.nome as cidade, e.logradouro, e.numero "
                . "FROM anuncio a, imovel i, usuario u, endereco e, imagem im, bairro b, cidade c";
        
        //$fromInicial = " SELECT * FROM anuncio a, imovel i, usuario u, endereco e, imagem im "; //select antigo
        
        $sql = $fromInicial . "
                            WHERE 
                            a.idimovel = i.id 
                            AND i.idusuario = u.id 
                            AND i.idendereco = e.id
                            AND a.id = im.idanuncio
                            AND a.status = 'cadastrado'
                            AND e.idbairro = b.id
                            AND e.idcidade = c.id
                            AND im.destaque = 'SIM'";
        
        if(!empty($parametro["txtReferencia"])){
            
           $ano = substr(chunk_split($parametro["txtReferencia"], 4),0,4); //ano do imóvel
            
           $mesParametro = substr(chunk_split($parametro["txtReferencia"], 2), 7,8);
          
           $mes = substr($mesParametro, 1, 2); //mês do imóvel
            
           $codigo = substr($parametro["txtReferencia"], -5); //código do imóvel
            
           
//            echo $ano."</br>";
            
//            echo $mes."</br>";
            
//            echo $codigo."</br>";
            
//            echo $parametro["txtReferencia"];
            
      //      die();
            
            $sqlReferencia = " AND i.id = :codigo AND SUBSTRING_INDEX(SUBSTRING_INDEX(i.datahoracadastro,' ', 1),'/',-1) = :ano " //busca o ano do cadastro, utilizando a função substring index 2 vezes
                    . "        AND SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(i.datahoracadastro,' ', 1),'/',-2), '/', 1) = :mes"; //busca o ano do cadastro, utilizando a função substring index 3 vezes
            
            
            $sqlFinal = $sql . $sqlReferencia;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':codigo', substr($parametro["txtReferencia"], -5)); 
            $statement->bindParam(':ano', $ano); 
            $statement->bindParam(':mes', $mes); 
            
        } else{   //caso a referência não esteja preenchida
        
        $sqlDiferencial = "";
            
        if(!empty($parametro["sltDiferencial"])){ //verificar se os campos do diferencial estão preenchidos
            
             $diferencial = $parametro["sltDiferencial"];
             
             foreach ($diferencial as $campo) {
                 if($campo!="multiselect-all")
                   $sqlDiferencial = $sqlDiferencial . " AND " . $campo." = 'SIM'";
                  
             }
               
         } //fim do diferencial
        
//        if (!empty($parametro["sltCidade"]) && empty($parametro["sltBairro"])) {
//            $fromCidade = ", cidade c ";
//            $fromInicial = $fromInicial . $fromCidade;
//        }
//
//        if (!empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) {
//
//            $fromCidadeBairro = ", cidade c, bairro b ";
//            $fromInicial = $fromInicial . $fromCidadeBairro;
//        }

        $sqlTipo = " AND i.tipo = :tipo";
        $sqlQuarto = " AND i.quarto = :quarto";
        $sqlBanheiro = " AND i.banheiro = :banheiro";
        $sqlCidade = " AND e.idcidade = c.id AND c.id = :cidade";
        $sqlCidadeBairro = " AND e.idbairro = b.id AND b.id = :bairro";
        $sqlGaragem = " AND i.garagem = :garagem";
        $sqlSuite = " AND i.suite = :suite";
        $sqlCondicao = " AND i.condicao = :condicao";
        
        if($parametro["sltM2"] != NULL){
            
            if($parametro["sltM2"] == 00){
                
                $sqlArea = " AND i.area  < :area + 40";
                
            } else $sqlArea = " AND i.area  >= :area";
          
        }
        
        
        $sqlCondicao = " AND i.condicao = :condicao";

        if ($parametro["sltValorVendaAvancado"] != null && $parametro["sltValorAluguelAvancado"] == null) {

            if ($parametro["sltValorVendaAvancado"] == 20000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor < 40000";
            }

            if ($parametro["sltValorVendaAvancado"] == 500000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor > 500000";
            }

            if ($parametro["sltValorVendaAvancado"] != 20000 && $parametro["sltValorVendaAvancado"] != 500000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor >= " . $parametro["sltValorVendaAvancado"] . " AND a.valor <= " . $parametro["sltValorVendaAvancado"] . " + 20000";
            }
        }

        if ($parametro["sltValorAluguelAvancado"] != null && $parametro["sltValorVendaAvancado"] == null) {

            if ($parametro["sltValorAluguelAvancado"] == 100) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor < 200";
            }

            if ($parametro["sltValorAluguelAvancado"] == 4000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor > 4000";
            }

            if ($parametro["sltValorAluguelAvancado"] != 100 && $parametro["sltValorAluguelAvancado"] != 4000) {

                $sqlFinalidadeValor = " AND i.finalidade = :finalidade AND a.valor >= " . $parametro["sltValorAluguelAvancado"] . " AND a.valor <= " . $parametro["sltValorAluguelAvancado"] . " + 200";
            }
        }

        if ($parametro["sltFinalidadeAvancado"] != null && $parametro["sltValorAluguelAvancado"] == null && $parametro["sltValorVendaAvancado"] == null) {

            $sqlFinalidadeValor = " AND i.finalidade = :finalidade";
        }

        $parametro["sltValorAluguelAvancado"] = $parametro["sltValorAvancado"];
        $parametro["sltValorVendaAvancado"] = $parametro["sltValorAvancado"];

//       foreach($parametros as $postValor){
//            
//            if(!empty($postValor) && $postValor != "Anuncio" && $postValor != "buscar"){
//            print "Valor: ".$postValor."<br/>";
//            
//            }
//            
//        }
//        
//        die();
//      

        $statement = $this->conexao->prepare($sql);

        if (!empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltValor"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas a finalidade preenchida
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlDiferencial; //erro
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);            
            
        }

        if (!empty($parametro["sltTipo"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltValor"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas o tipo preenchido
            $sqlFinal = $sql . $sqlTipo . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);            
        }

        if (!empty($parametro["sltQuarto"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltValor"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas o quarto preenchido
            $sqlFinal = $sql . $sqlQuarto . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);            
        }

        if (!empty($parametro["sltBanheiro"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltValor"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas o banheiro preenchido
            $sqlFinal = $sql . $sqlBanheiro . $sqlDiferencial; 
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltValor"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas a cidade preenchida
            $sqlFinal = $sql . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            
        }

        if (!empty($parametro["sltGaragem"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltBairro"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltSuite"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas a garagem preenchida
            $sqlFinal = $sql . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            
        }

        if (!empty($parametro["sltSuite"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltBairro"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltM2"]) && empty($parametro["sltCondicao"])) { //apenas a suite preenchida
            $sqlFinal = $sql . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            
        }
        
        if (!empty($parametro["sltM2"]) && empty($parametro["sltSuite"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltBairro"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltCondicao"])) { //apenas a área preenchida
            $sqlFinal = $sql . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':area', $parametro["sltM2"]);
            
            
        }
        
        if (!empty($parametro["sltCondicao"]) && empty($parametro["sltSuite"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltBairro"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltM2"])) { //apenas a condição preenchida
            $sqlFinal = $sql . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
            
        }

        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairroAvancado"]) && empty($parametro["sltGaragem"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltValor"])) { //apenas a cidade e o bairro preenchidos
            $sqlFinal = $sql . $sqlCidadeBairro . $sqlDiferencial;;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':bairro', $parametro["sltBairroAvancado"]);
        }

        /* if (!empty($parametro["sltValor"]) && empty($parametro["sltCidadeAvancado"]) && empty($parametro["sltBairro"]) && empty($parametro["sltFinalidadeAvancado"]) && empty($parametro["sltTipo"]) && empty($parametro["sltQuarto"]) && empty($parametro["sltBanheiro"]) && empty($parametro["sltGaragem"])) { //apenas o valor preenchido
          $sqlFinal = $sql . $sqlValor;
          $statement = $this->conexao->prepare($sqlFinal);
          $statement->bindParam(':valor', $parametro["sltValor"]);
          } */


        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"])) { //finalidade e tipo preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlTipo . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
        }



        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltQuarto"])) { //finalidade e quarto preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlQuarto . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltBanheiro"])) { //finalidade e banheiro preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlBanheiro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCidadeAvancado"])) { //finalidade e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltValor"])) { //finalidade e valor preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltGaragem"])) { //finalidade e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltM2"])) { //finalidade e área preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //finalidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidadeValor . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"])) { //tipo e quarto preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlQuarto . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"])) { //tipo e banheiro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlBanheiro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"])) { //tipo e cidade preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"])) { //tipo, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidadeBairro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltValor"])) { //tipo e valor preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlValor . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"])) { //tipo e garagem preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltSuite"])) { //tipo e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltM2"])) { //tipo e área preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCondicao"])) { //tipo e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"])) { //quarto e banheiro preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlBanheiro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"])) { //quarto e cidade preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"])) { //quarto, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidadeBairro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltValor"])) { //quarto e valor preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlValor . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"])) { //quarto e garagem preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"])) { //quarto e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltM2"])) { //quarto e área preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCondicao"])) { //quarto e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"])) { //garagem e banheiro preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltGaragem"]) && !empty($parametro["sltCidadeAvancado"])) { //garagem e cidade preenchidos
            $sqlFinal = $sql . $sqlGaragem . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //garagem e suite preenchidos
            $sqlFinal = $sql . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //garagem e área preenchidos
            $sqlFinal = $sql . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //garagem e condição preenchidos
            $sqlFinal = $sql . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //banheiro e área preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //cidade e área preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //suite e área preenchidos
            $sqlFinal = $sql . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //suite e condição preenchidos
            $sqlFinal = $sql . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"])) { //finalidade, tipo e quarto preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltM2"])) { //finalidade, tipo e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"])) { //finalidade, quarto e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlQuarto . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"])) { //finalidade, quarto e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlQuarto . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltM2"])) { //finalidade, quarto e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlQuarto . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCondicao"])) { //finalidade, quarto e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlQuarto . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"])) { //finalidade, banheiro e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlBanheiro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"])) { //finalidade, banheiro e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlBanheiro . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //finalidade, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //finalidade, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltGaragem"])) { //finalidade, cidade e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidade . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //finalidade, cidade e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //finalidade, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //finalidade, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //finalidade, garagem e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //finalidade, garagem e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //finalidade, suite e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //finalidade, suite e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"])) { //tipo, quarto e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlQuarto . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltM2"])) { //tipo, quarto e area preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlQuarto . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCondicao"])) { //tipo, quarto e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlQuarto . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"])) { //tipo, banheiro e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlBanheiro . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //tipo, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //tipo, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //tipo, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //tipo, cidade e area preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //tipo, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //tipo, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //tipo, garagem e area preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //tipo, garagem e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //tipo, suite e area preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltTipo"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //tipo, suite e condição preenchidos
            $sqlFinal = $sql . $sqlTipo . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }


        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //quarto, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //quarto, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //quarto, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //quarto, cidade e area preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //quarto, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //quarto, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //quarto, garagem e area preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //quarto, garagem e condição preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //quarto, suite e area preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //quarto, suite e condição preenchidos
            $sqlFinal = $sql . $sqlQuarto . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"])) { //banheiro, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCidade . $sqlCidadeBairro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //banheiro, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //banheiro, cidade e area preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //banheiro, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //banheiro, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //banheiro, suite e area preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //banheiro, suite e condição preenchidos
            $sqlFinal = $sql . $sqlBanheiro . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltGaragem"])) { //cidade, bairro e suite preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlCidadeBairro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }
        
        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltArea"])) { //cidade, bairro e area preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlCidadeBairro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':area', $parametro["sltArea"]);
        }
        
        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["slCondicao"])) { //cidade, bairro e condição preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlCidadeBairro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':condicao', $parametro["slCondicao"]);
        }

        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //cidade, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //cidade, suite e area preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltCondicao"])) { //cidade, suite e condição preenchidos
            $sqlFinal = $sql . $sqlCidade . $sqlSuite . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"])) { //finalidade, tipo, quarto e banheiro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"])) { //finalidade, tipo, quarto e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, quarto e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, banheiro e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlBanheiro . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, banheiro e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, cidade e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, cidade e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, banheiro e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, cidade e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, garagem e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, garagem e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }


        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"])) { //finalidade, tipo, quarto, banheiro e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidade . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, quarto, banheiro e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }
        
         if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto, banheiro e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto, banheiro e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto, banheiro e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, quarto, cidade e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCidade . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto, cidade e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCidade . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlCidade . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto, garagem e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto, garagem e condicao preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"])) { //finalidade, tipo, quarto, banheiro, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlValor . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, quarto, banheiro, cidade e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto, banheiro, cidade e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidade . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto, banheiro, cidade e area preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlGaragem . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto, banheiro, cidade e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlGaragem . $sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltGaragem"])) { //finalidade, tipo, quarto, banheiro, cidade, bairro e garagem preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlGaragem . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
        }

        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"])) { //finalidade, tipo, quarto, banheiro, cidade, bairro, garagem e suite preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlGaragem . $sqlSuite . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"])) { //finalidade, tipo, quarto, banheiro, cidade, bairro, garagem, suite e área preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlGaragem . $sqlSuite . $sqlArea . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
        }
        
        if (!empty($parametro["sltFinalidadeAvancado"]) && !empty($parametro["sltTipo"]) && !empty($parametro["sltQuarto"]) && !empty($parametro["sltBanheiro"]) && !empty($parametro["sltCidadeAvancado"]) && !empty($parametro["sltBairro"]) && !empty($parametro["sltGaragem"]) && !empty($parametro["sltSuite"]) && !empty($parametro["sltM2"]) && !empty($parametro["sltCondicao"])) { //finalidade, tipo, quarto, banheiro, cidade, bairro, garagem, suite, área e condição preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo . $sqlQuarto . $sqlBanheiro . $sqlCidadeBairro . $sqlGaragem . $sqlSuite . $sqlArea .$sqlCondicao . $sqlDiferencial;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidadeAvancado"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
            $statement->bindParam(':cidade', $parametro["sltCidadeAvancado"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':garagem', $parametro["sltGaragem"]);
            $statement->bindParam(':suite', $parametro["sltSuite"]);
            $statement->bindParam(':area', $parametro["sltM2"]);
            $statement->bindParam(':condicao', $parametro["sltCondicao"]);
        }
      
    }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;  
    } //fim do else

}

?>
