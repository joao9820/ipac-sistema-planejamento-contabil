<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:39
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditarConfEmail;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarConfEmail
{

    private $Dados;

    public function editConfEmail() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditConfEmail'])) {
            unset($this->Dados['EditConfEmail']);
            $editarConfEmail = new AdmsEditarConfEmail();
            $editarConfEmail->altConfEmail($this->Dados);
            if ($editarConfEmail->getResultado()) {
                $UrlDestino = URLADM . 'editar-conf-email/edit-conf-email';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editConfEmailViewPriv();
            }
        } else {
            $verConfEmail = new AdmsEditarConfEmail();
            $this->Dados['form'] = $verConfEmail->verConfEmail();
            $this->editConfEmailViewPriv();
        }
    }

    private function editConfEmailViewPriv() {
        if ($this->Dados['form']) {

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/confEmail/editarConfEmail", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Formulário para editar os dados do servidor de e-mail não encontrado!","danger");
            $UrlDestino = URLADM . 'editar-conf-email/edit-conf-email';
            header("Location: $UrlDestino");
        }
    }

}