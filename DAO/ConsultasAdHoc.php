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
        $sql = "SELECT e.*, i.* "
                . " FROM imovel i"
                . " JOIN endereco e ON e.id = i.idendereco"
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
                . " WHERE a.id in( %s )", implode(
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

    public function bucarImovel($parametros) {

        $parametro = array_slice($parametros, 0);

        $fromInicial = " SELECT * FROM anuncio a, imovel i, usuario u, endereco e ";

        if (!empty($parametro["sltCidade"]) && empty($parametro["sltBairro"])) {
            $fromCidade = ", cidade c ";
            $fromInicial = $fromInicial . $fromCidade;
        }

        if (!empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) {

            $fromCidadeBairro = ", bairro b ";
            $fromInicial = $fromInicial . $fromCidadeBairro;
        }

        $sql = $fromInicial . "
                            WHERE 
                            a.idimovel = i.id 
                            AND i.idusuario = u.id 
                            AND i.idendereco = e.id
                            AND a.status = 'cadastrado'";


        $sqlFinalidade = " AND i.finalidade = :finalidade";
        $sqlTipo = " AND i.tipo = :tipo";
        $sqlQuarto = " AND i.quarto = :quarto";
        $sqlBanheiro = " AND i.banheiro = :banheiro";
        $sqlCidade = " AND e.cidade = c.id AND c.id = :cidade";
        $sqlCidadeBairro = " AND e.bairro = b.id AND b.id = :bairro";

        if ($parametro["sltValor"] == 2) {
            $sqlValor = " AND a.valor < 40000";
        } elseif ($parametro["sltValor"] == 50) {
            $sqlValor = " AND a.valor > 500000";
        } else {
            $sqlValor = " AND a.valor >= " . $parametro['sltValor'] . "0000  AND a.valor <= " . $parametro['sltValor'] . "0000 + 20000";
        }

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
            $sqlFinal = $sql . $sqlFinalidade;
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
            $sqlFinal = $sql . $sqlFinalidade . $sqlTipo;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':tipo', $parametro["sltTipo"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltQuarto"])) { //finalidade e quarto preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlQuarto;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':quarto', $parametro["sltQuarto"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltBanheiro"])) { //finalidade e banheiro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlBanheiro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':banheiro', $parametro["sltBanheiro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltCidade"])) { //finalidade e cidade preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidade;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':cidade', $parametro["sltCidade"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltCidade"]) && !empty($parametro["sltBairro"])) { //finalidade, cidade e bairro preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlCidadeBairro;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
        }

        if (!empty($parametro["sltFinalidade"]) && !empty($parametro["sltValor"])) { //finalidade e valor preenchidos
            $sqlFinal = $sql . $sqlFinalidade . $sqlValor;
            $statement = $this->conexao->prepare($sqlFinal);
            $statement->bindParam(':finalidade', $parametro["sltFinalidade"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
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
            $statement->bindParam(':bairro', $parametro["sltBairro"]);
            $statement->bindParam(':valor', $parametro["sltValor"]);
        }

        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

}

?>
