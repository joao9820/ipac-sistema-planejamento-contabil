<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarJorDeTrab;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarJornadaDeTrabalho
{

    private $Dados;
    private $DadosId;

    public function editar($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $this->editFuncPriv();

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhum funcionário encontrado!","danger");
            $UrlDestino = URLADM .'jornada-de-trabalho/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editFuncPriv()
    {
        if (!empty($this->Dados['EditFuncionario']))
        {


            unset($this->Dados['EditFuncionario']);

            if (empty($this->Dados['jornada_de_trabalho'])) {
                unset($this->Dados['jornada_de_trabalho']);
            }

            if (empty($this->Dados['adms_departamento_id'])) {
                unset($this->Dados['adms_departamento_id']);
            }

            if (empty($this->Dados['adms_departamento_id']) and empty($this->Dados['jornada_de_trabalho']))
            {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhum funcionário atualizado!","info");
                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");
            } else {

                $editFunc = new AdmsEditarJorDeTrab();
                $editFunc->updateEditFuncionario($this->Dados);
                if ($editFunc->getResultado()) {

                    //$_SESSION['msg'] = "<div class='alert alert-success'>Funcionário editado com sucesso!</div>";
                    $UrlDestino = URLADM . 'jornada-de-trabalho/listar';
                    header("Location: $UrlDestino");

                } else {

                    $this->Dados['form'] = $this->Dados;

                    $this->editFuncionarioViewPriv();

                }

            }

        } else {

            $dadosFuncionario = new AdmsEditarJorDeTrab();
            $this->Dados['form'] = $dadosFuncionario->verFuncionario($this->DadosId);

            $this->editFuncionarioViewPriv();

        }

    }


    private function editFuncionarioViewPriv()
    {
        if ($this->Dados['form']) {

            $botao = ['listar' => ['menu_controller' => 'jornada-de-trabalho', 'menu_metodo' => 'listar']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $select = new AdmsEditarJorDeTrab();
            $this->Dados['select'] = $select->listarCadastrar();

            $dFuncionario = new AdmsEditarJorDeTrab();
            $this->Dados['funcionarioInfo'] = $dFuncionario->verFuncionario($this->DadosId);

            //Carregar Menu
            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new ConfigView("adms/Views/gerenciar/editarJornadaDeTrabalho", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão de editar o funcionário selecionado!","danger");
            $UrlDestino = URLADM .'jornada-de-trabalho/listar';
            header("Location: $UrlDestino");
        }

    }

}