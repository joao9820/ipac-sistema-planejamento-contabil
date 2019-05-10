<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarDemanda;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

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
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhuma demanda encontrado!","danger");
            $UrlDestino = URLADM .'demandas/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editDemandaPriv()
    {
        if (!empty($this->Dados['EditDemanda']))
        {

            unset($this->Dados['EditDemanda']);

            $editDemanda = new AdmsEditarDemanda();

            // Chamando o metodo para alterar a demanda
            $editDemanda->altDemanda($this->Dados);
            if ($editDemanda->getResultado())
            {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Demanda editada!","success");
                $UrlDestino = URLADM .'ver-demanda/ver-demanda/'.$this->Dados['id'];
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->editDemandaViewPriv();

            }

        } else {

            $dadosDemanda = new AdmsEditarDemanda();
            $this->Dados['form'] = $dadosDemanda->verDemanda($this->DadosId);

            $this->editDemandaViewPriv();

        }

    }


    private function editDemandaViewPriv()
    {
        if ($this->Dados['form']) {

            $botao = ['vis_demanda' => ['menu_controller' => 'ver-demanda', 'menu_metodo' => 'ver-demanda']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            //Carregar Menu
            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            //Carregar a view
            $carregarView = new ConfigView("adms/Views/gerenciar/editarDemanda", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão de editar a demanda selecionada!","danger");
            $UrlDestino = URLADM .'demandas/listar';
            header("Location: $UrlDestino");
        }

    }

}