<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

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

            $validaUsuario = new \App\adms\Models\AdmsEditarSenha();
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
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhum usuário encontrado!</div>";
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editSenhaPriv()
    {
        if (!empty($this->Dados['EditSenha']))
        {

            unset($this->Dados['EditSenha']);

            $editSenha = new \App\adms\Models\AdmsEditarSenha();
            $editSenha->editSenha($this->Dados);
            if ($editSenha->getResultado())
            {

                $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
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

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new \Core\ConfigView("adms/Views/usuario/editarSenha", $this->Dados);
            $carregarView->renderizar();

        }
        else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Você não tem permissão de editar o usuário selecionado!</div>";
            $UrlDestino = URLADM .'usuarios/listar';
            header("Location: $UrlDestino");

        }

    }


}