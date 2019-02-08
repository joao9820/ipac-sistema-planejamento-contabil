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


class EditarDemanda
{

    private $Dados;
    private $DadosId;

    public function editDemanda($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $this->editDemandaPriv();

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhuma demanda encontrado!</div>";
            $UrlDestino = URLADM .'demandas/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editDemandaPriv()
    {
        if (!empty($this->Dados['EditDemanda']))
        {

            unset($this->Dados['EditDemanda']);

            $editDemanda = new \App\adms\Models\AdmsEditarDemanda();

            // Chamando o metodo para alterar a demanda
            $editDemanda->altDemanda($this->Dados);
            if ($editDemanda->getResultado())
            {

                $_SESSION['msg'] = "<div class='alert alert-success'>Demanda editada com sucesso!</div>";
                $UrlDestino = URLADM .'ver-demanda/ver-demanda/'.$this->Dados['id'];
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->editDemandaViewPriv();

            }

        } else {

            $dadosDemanda = new \App\adms\Models\AdmsEditarDemanda();
            $this->Dados['form'] = $dadosDemanda->verDemanda($this->DadosId);

            $this->editDemandaViewPriv();

        }

    }


    private function editDemandaViewPriv()
    {
        if ($this->Dados['form']) {

            $botao = ['vis_demanda' => ['menu_controller' => 'ver-demanda', 'menu_metodo' => 'ver-demanda']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            //Carregar Menu
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            //Carregar a view
            $carregarView = new \Core\ConfigView("adms/Views/gerenciar/editarDemanda", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Você não tem permissão de editar a demanda selecionada!</div>";
            $UrlDestino = URLADM .'demandas/listar';
            header("Location: $UrlDestino");
        }

    }

}