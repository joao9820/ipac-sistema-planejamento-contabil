<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 13:15
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class GerenciarAtendimento
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['vis_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'ver'],
            'edit_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'editar'],
            'arquivar_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'arquivar'],
            'arqui_atendimento' => ['menu_controller' => 'gerenciar-atendimento', 'menu_metodo' => 'arquivado']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimentos = new \App\adms\Models\AdmsListarAtendGerente();
        $this->Dados['listAtendimentos']= $listarAtendimentos->listarAtendimentos($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimentos->getResultadoPg();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/gerenciar/listarAtendimentos", $this->Dados);
        $carregarView->renderizar();
    }



    public function arquivado($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['list_atendimento' => ['menu_controller' => 'gerenciar-atendimento', 'menu_metodo' => 'listar'],
            'vis_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'ver'],
            'edit_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'editar'],
            'desarqui_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'desarquivar']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimentos = new \App\adms\Models\AdmsListarAtendArquiGerente();
        $this->Dados['listAtendimentosAq']= $listarAtendimentos->listarAtendimentosArquivados($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimentos->getResultadoPgAq();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/gerenciar/listarAtendimentosArquivados", $this->Dados);
        $carregarView->renderizar();

    }

}