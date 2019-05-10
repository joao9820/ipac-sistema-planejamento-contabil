<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditarSenha;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSenha
{

    private $Dados;
    private $DadosId;

    public function editSenha($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $validaUsuario = new AdmsEditarSenha();
            $validaUsuario->valUsuario($this->DadosId);
            if($validaUsuario->getResultado())
            {
                $this->editSenhaPriv();
            }
            else {

                $UrlDestino = URLADM . 'usuarios/listar';
                header("Location: $UrlDestino");

            }

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhum usuário encontrado!","danger");
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editSenhaPriv()
    {
        if (!empty($this->Dados['EditSenha']))
        {

            unset($this->Dados['EditSenha']);

            $editSenha = new AdmsEditarSenha();
            $editSenha->editSenha($this->Dados);
            if ($editSenha->getResultado())
            {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Senha atualizada com sucesso!","success");
                $UrlDestino = URLADM .'ver-usuario/ver-usuario/'.$this->Dados['id'];
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados['id'];

                $this->editSenhaViewPriv();

            }

        } else {

            $this->Dados['form'] = $this->DadosId;

            $this->editSenhaViewPriv();

        }

    }

    private function editSenhaViewPriv()
    {
        if ($this->Dados['form']) {

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new ConfigView("adms/Views/usuario/editarSenha", $this->Dados);
            $carregarView->renderizar();

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão de editar o usuário selecionado!","danger");
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");

        }

    }


}