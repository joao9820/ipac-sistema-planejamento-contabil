<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:32
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditarFormCadUsuario;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarFormCadUsuario
{

    private $Dados;

    public function editFormCadUsuario() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditFormCad'])) {
            unset($this->Dados['EditFormCad']);

            $editarFormCadUsuario = new AdmsEditarFormCadUsuario();
            $editarFormCadUsuario->altFormCadUsuario($this->Dados);
            if ($editarFormCadUsuario->getResultado()) {
                $UrlDestino = URLADM . 'editar-form-cad-usuario/edit-form-cad-usuario';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verFormCadUsuario = new AdmsEditarFormCadUsuario();
            $this->Dados['form'] = $verFormCadUsuario->verFormCadUsuario();
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarFormCadUsuario();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/usuario/editarFormCadUsuario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Formulário para editar o cadastro de usuário na página de login não encontrado!","danger");
            $UrlDestino = URLADM . 'editar-form-cad-usuario/edit-form-cad-usuario';
            header("Location: $UrlDestino");
        }
    }

}