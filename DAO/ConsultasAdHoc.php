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
    public function ConsultarAnunciosPublicos($idanuncios) {       
        
        $sql = "SELECT * "
                . " FROM anuncio a"
                . " JOIN imovel i ON a.idimovel = i.id"
                . " WHERE a.id"
                . " IN ( ";
        
        $sql = $sql . implode(", ", $idanuncios) . " )";
        
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }
}
?>
