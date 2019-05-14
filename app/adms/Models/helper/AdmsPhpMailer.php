<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsPhpMailer
 *
 */
class AdmsPhpMailer
{

    private $Resultado;
    private $DadosCredEmail;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }


    public function emailPhpMailer(array $Dados)
    {
        $this->Dados = $Dados;
        $credEmail = new AdmsRead();
        $credEmail->fullRead("SELECT * FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->DadosCredEmail = $credEmail->getResultado();

        if ((isset($this->DadosCredEmail[0]['host'])) AND ( !empty($this->DadosCredEmail[0]['host']))) {
            $this->confEmail();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário inserir as credencias do e-mail no administrativo para enviar e-mail!","danger");
            $this->Resultado = false;
        }
    }

    private function confEmail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->DadosCredEmail[0]['host'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->DadosCredEmail[0]['usuario'];                 // SMTP username
            $mail->Password = $this->DadosCredEmail[0]['senha'];                           // SMTP password
            $mail->SMTPSecure = $this->DadosCredEmail[0]['smtpsecure'];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->DadosCredEmail[0]['porta'];                                    // TCP port to connect to
            //Recipients
            $mail->setFrom($this->DadosCredEmail[0]['email'], $this->DadosCredEmail[0]['nome']);
            $mail->addAddress($this->Dados['dest_email'], $this->Dados['dest_nome']);     // Add a recipient
            //
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->Dados['titulo_email'];
            $mail->Body = $this->Dados['cont_email'];
            $mail->AltBody = $this->Dados['cont_text_email'];

            if ($mail->send()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("E-mail enviado com sucesso!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("E-mail não foi enviado!","danger");
                $this->Resultado = false;
            }
        } catch (Exception $e) {
            $this->Resultado = false;
        }
    }

}
