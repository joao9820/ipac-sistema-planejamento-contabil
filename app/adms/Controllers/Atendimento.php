<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/01/2019
 * Time: 16:33
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Atendimento
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['abrir_atendimento' => ['menu_controller' => 'novo-atendimento', 'menu_metodo' => 'novo'],
            'vis_atendimento' => ['menu_controller' => 'ver-atendimento', 'menu_metodo' => 'ver-atendimento'],
            'edit_atendimento' => ['menu_controller' => 'editar-atendimento', 'menu_metodo' => 'edit-atendimento'],
            'arqui_atendimento' => ['menu_controller' => 'arquivar-atendimento', 'menu_metodo' => 'arquivar'],
            'ver_arqui_atend' => ['menu_controller' => 'atendimento', 'menu_metodo' => 'arquivado'],
            'can_atendimento' => ['menu_controller' => 'cancelar-atendimento', 'menu_metodo' => 'cancelar']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new \App\adms\Models\AdmsListarAtendimento();
        $this->Dados['listAtendimento']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();
        $this->Dados['arquivado'] = $listarAtendimento->getResultadoArquivado();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/atendimento/atendimento", $this->Dados);
        $carregarView->renderizar();
    }


    public function arquivado($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['des_arquiAten' => ['menu_controller' => 'desarquivar-atendimento', 'menu_metodo' => 'aten'],
            'list_atendimento' => ['menu_controller' => 'atendimento', 'menu_metodo' => 'listar']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarDesAtendimento = new \App\adms\Models\AdmsListarAtendimento();
        $this->Dados['listAtendimentoArquivado']= $listarDesAtendimento->listarAtendimentoArquivado($this->PageId);
        $this->Dados['paginacao'] = $listarDesAtendimento->getResultadoPg();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/atendimento/atendimentoArquivado", $this->Dados);
        $carregarView->renderizar();
    }


}