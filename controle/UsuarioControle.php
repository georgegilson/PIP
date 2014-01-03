<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/RecuperaSenha.php';
include_once 'controle/UsuarioPlanoControle.php';
include_once 'DAO/GenericoDAO.php';
include_once 'assets/mailer/class.phpmailer.php';
include_once 'assets/mailer/class.smtp.php';
include_once 'configuracao/ConsultaUrl.php';

class UsuarioControle {

    function form($parametros) {
        $visao = new Template();
        switch ($parametros['tipo']) {
            case "cadastro":
                $visao->exibir('UsuarioVisaoCadastro.php');
                break;
            case "login":
                $visao->exibir('UsuarioVisaoLogin.php');
                break;
            case "esquecisenha":
                $visao->setItem("erroemail");
                $visao->exibir('VisaoErrosGenerico.php');
                //$visao->exibir('UsuarioVisaoEsqueciSenha.php');
                break;
            case "alterarsenha":
                $recuperasenha = new RecuperaSenha();
                $genericoDAO = new GenericoDAO();
                $selecionarRecuperaSenha = $genericoDAO->consultar($recuperasenha, false, array("hash" => $parametros["id"]));
                if ($selecionarRecuperaSenha && $selecionarRecuperaSenha[0]->getStatus() == "ativo") {
                    $_SESSION['idRecuperaSenhaUsuario'] = $selecionarRecuperaSenha[0]->getIdusuario();
                    $_SESSION['idRecuperaSenha'] = $selecionarRecuperaSenha[0]->getId();
                    $visao->exibir('UsuarioVisaoAlterarSenha.php');
                } else
                    $visao->setItem("errolink");
                $visao->exibir('VisaoErrosGenerico.php');
                break;
        }
    }

    function cadastrar($parametros) {
        //Endereço
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->cadastrar($parametros);
            $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
            //Usuário
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->cadastrar($parametros, $idEndereco);
            $idUsuario = $genericoDAO->cadastrar($entidadeUsuario);
            //Empresa
            $idEmpresa = false;
            if ($entidadeUsuario->getTipousuario() == "pj") {
                $empresa = new Empresa();
                $entidadeEmpresa = $empresa->cadastrar($parametros, $idUsuario);
                $idEmpresa = $genericoDAO->cadastrar($entidadeEmpresa);
            } else {
                $idEmpresa = true;
            }
            //Telefone
            $quantidadeTelefone = count($parametros['hdnTipoTelefone']);
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $idUsuario, $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }

            if ($idEndereco && $idUsuario && $idEmpresa && $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErros.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function selecionar($parametro) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, true, array("id" => $_SESSION["idusuario"]));
            //visao
            $visao = new Template();
            $visao->setItem($selecionarUsuario);
            $visao->exibir('UsuarioVisaoEdicao.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    function alterar($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->editar($parametros);
            $idEndereco = $genericoDAO->editar($entidadeEndereco);
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->editar($parametros);
            $genericoDAO = new GenericoDAO();
            $resultado = $genericoDAO->editar($entidadeUsuario);
            //visao
            if ($resultado)
                echo json_encode(array("resultado" => 1));
            else
                $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            $visao->setItem("errobanco");
            $visao->exibir('VisaoErros.php');
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }

    function buscarLogin($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }
    
    function buscarEmail($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }
    
    function buscarCpf($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCpf']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }
    
    function buscarCnpj($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCnpj']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }

    function autenticar($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));
            if (($selecionarUsuario != 0) && ($selecionarUsuario[0]->getSenha() == md5($parametros['txtSenha']))) {
                Sessao::configurarSessaoUsuario($selecionarUsuario);
                $resultado = ConsultaUrl::consulta($_SERVER['HTTP_REFERER']);
                switch ($resultado) {
                    case "login":
                        $visao = new Template();
                        $visao->exibir('index', 1);
                        break;
                    case "plano":
                        $redirecionamento = new UsuarioPlanoControle();
                        $redirecionamento->listar();
                        break;
                }
            } else {
                $visao = new Template();
                $visao->setItem("errologinsenha");
                $visao->exibir('UsuarioVisaoLogin.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }

    function logout($parametros) {
        if (Sessao::encerrarSessaoUsuario()) {
            echo json_encode(array("resultado" => 1));
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }

    //ajax
    function esquecersenha($parametros) {
        if (Sessao::verificarToken($parametros)) {
            //verifica se tem link ativo
            // pendente!
            //Verificar o email
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));
            if ($selecionarUsuario) {
                //gravar registro no banco
                $genericoDAO = new GenericoDAO();
                $genericoDAO->iniciarTransacao();
                $recuperasenha = new RecuperaSenha();
                $entidadeRecuperaSenha = $recuperasenha->cadastrar($selecionarUsuario[0]->getId());
                $idResuperaSenha = $genericoDAO->cadastrar($entidadeRecuperaSenha);
                if ($idResuperaSenha) {
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                    //enviar email
                    $mail = new PHPMailer();

                    $mail->Charset = 'UTF-8';

                    $mail->From = 'emailfrom@email.com';
                    $mail->FromName = 'Nome de quem enviou';

                    $mail->IsHTML(true);
                    $mail->Subject = 'Assunto do e-mail';
                    $mail->Body = "&lt;h1&gt;Teste de envio de e-mail&lt;/h1&gt; &lt;p&gt;Isso é um teste&lt;/p&gt;
                        <br> 
                        <a href=http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    $mail->AltBody = 'Conteudo sem HTML para editores que não suportam, sim, existem alguns';

                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Host = "ssl://smtp.googlemail.com";
                    $mail->Port = 465;
                    $mail->Username = 'pipcontato@gmail.com';
                    $mail->Password = 'osestudantes1';

                    $mail->AddAddress($selecionarUsuario[0]->getEmail(), $selecionarUsuario[0]->getNome());

                    if ($mail->Send())
                        echo 'E-mail enviado com sucesso';
                    else
                        echo 'Erro ao enviar e-mail';
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    $visao = new Template();
                    $visao->exibir('UsuarioVisaoLogin.php');
                }
            } else {
                $visao->setItem("erroemail");
                $visao->exibir('VisaoErros.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }

    //ajax
    function alterarsenha($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->alterarSenha($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            $recuperasenha = new RecuperaSenha();
            $entidadeRecuperaSenha = $recuperasenha->editar($parametros);
            $resultadoAlterarSenha = $genericoDAO->editar($entidadeRecuperaSenha);
            if ($resultadoUsuario && $resultadoAlterarSenha) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao = new Template();
                $visao->exibir('UsuarioVisaoLogin.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErros.php');
        }
    }

}
