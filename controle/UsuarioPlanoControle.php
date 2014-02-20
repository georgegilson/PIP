<?php

include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Plano.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';

class UsuarioPlanoControle {

    public function listar() {
        if (Sessao::verificarSessaoUsuario()) {
            //modelo
            $usuarioPlano = new UsuarioPlano();
            $plano = new Plano();
            $genericoDAO = new GenericoDAO();

            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => $_SESSION["idusuario"]));
            $condicoes["status"] = "ativo";
            if ($_SESSION["tipopessoa"] == "pf") {
                $condicoes["tipo"] = "pf";
            }
            $listarPlano = $genericoDAO->consultar($plano, true, $condicoes);

            $formUsuarioPlano = array();
            $formUsuarioPlano["usuarioPlano"] = $listarUsuarioPlano;
            $formUsuarioPlano["plano"] = $listarPlano;
            //visao
            $visao = new Template();
            $visao->setItem($formUsuarioPlano);
            $visao->exibir('UsuarioPlanoVisaoListagem.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    public function confirmar($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {
            if ($parametros["spnPlano"]) {
                $total = 0;
                foreach ($parametros["spnPlano"] as $id => $qtd) {
                    $total += $parametros["txtPreco"][$id] * $qtd;
                    if ($qtd > 0) {
                        $confirmacao["planos"][$id] = $qtd;
                    }
                }

                if ($total <> $parametros["txtTotal"]) {
                    die("erro no total informado");
                } else {
                    $confirmacao["total"] = $total;
                    $confirmacao["tokenPlano"] = $parametros["hdnToken"];
                    Sessao::configurarSessaoUsuarioPlanoConfirmacao($confirmacao);

                    $condicoesAdHoc = new ConsultasAdHoc();
                    $selecionarPlanos = $condicoesAdHoc->ConsultarPlanosComprados(array_keys($confirmacao["planos"]));

                    $resultado["planosSelecionados"] = $selecionarPlanos;
                    $resultado["confirmacao"] = $confirmacao;

                    $visao = new Template();
                    $visao->setItem($resultado);
                    $visao->exibir('UsuarioPlanoVisaoConfirmar.php');
                }
            }
        }
    }

    public function comprar($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {
            if ($parametros["hdnPlano"] == $_SESSION["usuarioPlano"]["tokenPlano"] & $_SESSION["usuarioPlano"]["planos"]) {
                $genericoDAO = new GenericoDAO();
                $genericoDAO->iniciarTransacao();
                //echo "<pre>";print_r($_SESSION); die();
                foreach ($_SESSION["usuarioPlano"]["planos"] as $id => $qtd) {
                    while ($qtd > 0) {
                        $usuarioPlano = new UsuarioPlano();
                        $genericoDAO->cadastrar($usuarioPlano->cadastrar($id));
                        $qtd--;
                    }
                }
                $genericoDAO->commit();
                Sessao::desconfigurarVariavelSessao("usuarioPlano");
                //$redirecionamento = new UsuarioPlanoControle();
                //$redirecionamento->listar();
                $visao = new Template();
                $visao->exibir('UsuarioPlanoVisaoCompra.php');
            } else {
                die("erro no token do plano");
            }
        }
    }

}
