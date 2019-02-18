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

class AtendimentoPendente
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['em_andamento' => ['menu_controller' => 'atendimento-em-andamento', 'menu_metodo' => 'listar'],
            'vis' => ['menu_controller' => 'funcionario-ver-atendimento', 'menu_metodo' => 'ver'],
            'edit' => ['menu_controller' => 'funcionario-editar-atendimento', 'menu_metodo' => 'edit'],
            'conclu' => ['menu_controller' => 'func-concluir-atendimento', 'menu_metodo' => 'concluir']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new \App\adms\Models\AdmsListarAtendimentoPendente();
        $this->Dados['listAtendimentoPendente']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();
        $this->Dados['listAtendimentoPendenteUrgente'] = $listarAtendimento->listarAtendimentoUrgente();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/atendimento/funcionario/atendimentoPendente", $this->Dados);
        $carregarView->renderizar();
    }



}