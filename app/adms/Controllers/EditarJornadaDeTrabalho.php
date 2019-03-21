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
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhum funcionário encontrado!</div>";
            $UrlDestino = URLADM .'jornada-de-trabalho/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editFuncPriv()
    {
        if (!empty($this->Dados['EditFuncionario']))
        {

            unset($this->Dados['EditFuncionario']);

            $editFunc = new \App\adms\Models\AdmsEditarJorDeTrab();
            $editFunc->updateEditFuncionario($this->Dados);
            if ($editFunc->getResultado())
            {

                //$_SESSION['msg'] = "<div class='alert alert-success'>Funcionário editado com sucesso!</div>";
                $UrlDestino = URLADM .'jornada-de-trabalho/listar';
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->editFuncionarioViewPriv();

            }

        } else {

            $dadosFuncionario = new \App\adms\Models\AdmsEditarJorDeTrab();
            $this->Dados['form'] = $dadosFuncionario->verFuncionario($this->DadosId);

            $this->editFuncionarioViewPriv();

        }

    }


    private function editFuncionarioViewPriv()
    {
        if ($this->Dados['form']) {

            $botao = ['listar' => ['menu_controller' => 'jornada-de-trabalho', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $select = new \App\adms\Models\AdmsEditarJorDeTrab();
            $this->Dados['select'] = $select->listarCadastrar();

            $dFuncionario = new \App\adms\Models\AdmsEditarJorDeTrab();
            $this->Dados['funcionarioInfo'] = $dFuncionario->verFuncionario($this->DadosId);

            //Carregar Menu
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new \Core\ConfigView("adms/Views/gerenciar/editarJornadaDeTrabalho", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Você não tem permissão de editar o funcionário selecionado!</div>";
            $UrlDestino = URLADM .'jornada-de-trabalho/listar';
            header("Location: $UrlDestino");
        }

    }

}