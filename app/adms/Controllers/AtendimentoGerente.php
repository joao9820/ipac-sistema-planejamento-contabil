<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 15:08
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsArquivarAtendGerente;
use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarAtenGerente;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerAtendGerente;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtendimentoGerente
{

    private $Dados;
    private $DadosId;
    private $PageId;

    public function ver($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId))
        {
            $ver = new AdmsVerAtendGerente();
            $this->Dados['atendimento'] = $ver->visualizar($this->DadosId);
            $this->Dados['total_horas_atendimento'] = $ver->verTotalHoras($this->Dados['atendimento'][0]['id_demanda']);

            $botao = ['edit_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'editar'],
                'list_atendimento' => ['menu_controller' => 'gerenciar-atendimento', 'menu_metodo' => 'listar'],
                'arqui_atendimento' => ['menu_controller' => 'gerenciar-atendimento', 'menu_metodo' => 'arquivado'],
                'list_logs' => ['menu_controller' => 'logs-atendimento', 'menu_metodo' => 'listar']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            if ($this->PageId){
                $this->Dados['pg'] = $this->PageId;
            } else {
                $this->Dados['pg'] = 1;
            }


            //Carregar Menu
            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new ConfigView("adms/Views/gerenciar/verAtendimentos", $this->Dados);
            $carregarView->renderizar();


        } else {
            $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
            header("Location: $UrlDestino");
        }

    }




    public function arquivar($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId))
        {
            if ($this->PageId){
                $this->Dados['pg'] = $this->PageId;
            } else {
                $this->Dados['pg'] = 1;
            }

            $cancelar = new AdmsArquivarAtendGerente();
            $cancelar->arquivar($this->DadosId);
            $UrlDestino = URLADM . "gerenciar-atendimento/listar/{$this->PageId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
            header("Location: $UrlDestino");
        }

    }

    public function desarquivar($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->DadosId))
        {
            if ($this->PageId){
                $this->Dados['pg'] = $this->PageId;
            } else {
                $this->Dados['pg'] = 1;
            }

            $cancelar = new AdmsArquivarAtendGerente();
            $cancelar->desarquivar($this->DadosId);
            $UrlDestino = URLADM . "gerenciar-atendimento/arquivado/{$this->PageId}";
            header("Location: $UrlDestino");
        } else {
            $UrlDestino = URLADM . 'gerenciar-atendimento/arquivado';
            header("Location: $UrlDestino");
        }

    }



    public function editar($DadosId = null)
    {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);
        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId) AND !empty($this->PageId))
        {
            $this->editAtendimentoPrev();

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhum atendimento selecionado!","danger");
            $UrlDestino = URLADM ."gerenciar-atendimento/listar";
            header("Location: $UrlDestino");
        }
    }

    private function editAtendimentoPrev()
    {

        if (!empty($this->Dados['EditAtendimento']))
        {

            unset($this->Dados['EditAtendimento']);


            $editAtividade = new AdmsEditarAtenGerente();
            $editAtividade->altAtendimento($this->Dados);
            if ($editAtividade->getResultado())
            {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atendimento atualizado!","danger");
                $UrlDestino = URLADM .'atendimento-gerente/ver/'.$this->Dados['id'].'?pg='.$this->PageId;
                //echo $UrlDestino;
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;

                $this->editAtendimentoViewPriv();

            }

        } else {

            $dadosAtendimento = new AdmsEditarAtenGerente();
            $this->Dados['form'] = $dadosAtendimento->verAtendimento($this->DadosId);

            $this->editAtendimentoViewPriv();

        }


    }

    private function editAtendimentoViewPriv()
    {
        if ($this->Dados['form']) {

            $listarSelect = new AdmsEditarAtenGerente();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            $this->Dados['dadosAtendimento'] = $listarSelect->verAtendimento($this->DadosId);

            $botao = ['vis_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'ver'],
                'list_atendimento' => ['menu_controller' => 'gerenciar-atendimento', 'menu_metodo' => 'listar']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $this->Dados['pg'] = $this->PageId;

            //Carregar Menu
            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            //Carregar a view
            $carregarView = new ConfigView("adms/Views/gerenciar/editarAtendimentos", $this->Dados);
            $carregarView->renderizar();

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão de editar o atendimento selecionado!","danger");
            $UrlDestino = URLADM .'gerenciar-atendimento/listar';
            header("Location: $UrlDestino");

        }

    }

}