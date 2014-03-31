<?php

class Email {
    
    public static function enviarEmail($dadosEmail) {
        //enviar email
                    $mail = new PHPMailer();

                    $mail->Charset = 'UTF-8';

                    $mail->From = 'emailfrom@email.com';
                    $mail->FromName = 'Nome de quem enviou';

                    $mail->IsHTML(true);
                    $mail->Subject = 'Assunto do e-mail';
                    
                    $mail->Body = $dadosEmail['msg'];
//                    $mail->Body = "<br> <h1>Teste de envio</h1> <br>";
//                    $mail->AltBody = 'Conteudo sem HTML para editores que não suportam, sim, existem alguns';
                    
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Host = "ssl://smtp.googlemail.com";
                    $mail->Port = 465;
                    $mail->Username = 'pipcontato@gmail.com';
                    $mail->Password = 'osestudantes1';

                    $mail->AddAddress($dadosEmail['destino'], $dadosEmail['nome']);

                    if ($mail->Send()) {
                        return true;
                    } else {
                        return false;
                    }
    }
}

