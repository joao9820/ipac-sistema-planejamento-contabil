<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/01/2019
 * Time: 14:24
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarAtividade;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarAtividade
{

    private $Dados;
    private $DadosId;
    private $DemandaId;

    public function editAtividade($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DemandaId = filter_input(INPUT_GET, 'demanda', FILTER_DEFAULT);
        $this->DadosId = $DadosId;
        //var_dump($this->DadosId);
        //$this->DadosId = (int) $DadosId[1];
        if (!empty($this->DadosId))
        {
            $this->editAtividadePriv();

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhuma atividade encontrado!</div>";
            $UrlDestino = URLADM .'demandas/listar';
            header("Location: $UrlDestino");
        }

    }

    private function editAtividadePriv()
    {
        if (!empty($this->Dados['EditAtividade']))
        {

            unset($this->Dados['EditAtividade']);

            if(empty($this->Dados['atividade_antecessora_id'])){
                unset($this->Dados['atividade_antecessora_id']);
            }

            $editAtividade = new AdmsEditarAtividade();
            // Chamando o metodo para alterar a atividade
            $editAtividade->altAtividade($this->Dados);
            if ($editAtividade->getResultado())
            {

                $_SESSION['msg'] = "<div class='alert alert-success'>Atividade atualizada com sucesso!</div>";
                $UrlDestino = URLADM .'ver-demanda/ver-demanda/'.$this->Dados['adms_demanda_id'];
                //echo $UrlDestino;
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;
                $this->Dados['formDemanda'] = $editAtividade->verAtividade($this->DadosId);
                $this->editAtividadeViewPriv();

            }

        } else {

            $dadosAtividade = new AdmsEditarAtividade();
            $this->Dados['form'] = $dadosAtividade->verAtividade($this->DadosId);
            $this->Dados['formDemanda'] = $dadosAtividade->verAtividade($this->DadosId);

            $this->editAtividadeViewPriv();

        }

    }


        private function editAtividadeViewPriv()
        {
            if ($this->Dados['form']) {

                $botao = ['vis_demanda' => ['menu_controller' => 'ver-demanda', 'menu_metodo' => 'ver-demanda']];
                $listarBotao = new AdmsBotao();
                $this->Dados['botao'] = $listarBotao->valBotao($botao);

                //Carregar Menu
                $listarMenu = new AdmsMenu();
                $this->Dados['menu'] = $listarMenu->itemMenu();

                $listarAtividades = new AdmsEditarAtividade();
                $this->Dados['listaAtividades'] = $listarAtividades->listarAtividades($this->DadosId, $this->DemandaId);

                //Carregar a view
                $carregarView = new ConfigView("adms/Views/gerenciar/editarAtividade", $this->Dados);
                $carregarView->renderizar();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Você não tem permissão de editar a atividade selecionada!</div>";
                $UrlDestino = URLADM .'demandas/listar';
                header("Location: $UrlDestino");
            }

        }


}