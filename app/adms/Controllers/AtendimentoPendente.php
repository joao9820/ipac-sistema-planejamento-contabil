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
        $botao = ['abrir' => ['menu_controller' => 'novo-atendimento', 'menu_metodo' => 'novo'],
            'vis' => ['menu_controller' => 'ver-atendimento', 'menu_metodo' => 'ver-atendimento'],
            'edit' => ['menu_controller' => 'editar-atendimento', 'menu_metodo' => 'edit-atendimento']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new \App\adms\Models\AdmsListarAtendimentoPendente();
        $this->Dados['listAtendimentoPendente']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new \Core\ConfigView("adms/Views/atendimento/funcionario/atendimentoPendente", $this->Dados);
        $carregarView->renderizar();
    }


}