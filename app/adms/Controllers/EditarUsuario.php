<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarUsuario
{

    private $Dados;
    private $DadosId;
    private $Registro;

    public function editUsuario($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $this->editUsuarioPriv();

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhum usuário encontrado!</div>";
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editUsuarioPriv()
    {
        if (!empty($this->Dados['EditUsuario']))
        {

            unset($this->Dados['EditUsuario']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editUsuario = new \App\adms\Models\AdmsEditarUsuario();
            $editUsuario->altUsuario($this->Dados);
            if ($editUsuario->getResultado())
            {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário atualizado", "success");
                $UrlDestino = URLADM .'ver-usuario/ver-usuario/'.$this->Dados['id'];
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->editUsuarioViewPriv();

            }

        } else {

            $dadosUsuario = new \App\adms\Models\AdmsEditarUsuario();
            $this->Dados['form'] = $dadosUsuario->verUsuario($this->DadosId);

            $this->editUsuarioViewPriv();

        }

    }


    private function editUsuarioViewPriv()
    {
        if ($this->Dados['form']) {
            //Dados do Select
            $listarSelect = new \App\adms\Models\AdmsEditarUsuario();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            //Carregar Menu
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            //Carregar a view
            $carregarView = new \Core\ConfigView("adms/Views/usuario/editarUsuario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Você não tem permissão de editar o usuário selecionado!</div>";
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");
        }

    }

}