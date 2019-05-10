<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/01/2019
 * Time: 16:33
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarAtendimentoPendente;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtendimentoEmAndamento
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['pendente' => ['menu_controller' => 'atendimento-pendente', 'menu_metodo' => 'listar'],
                'concluido' => ['menu_controller' => 'atendimento-concluido', 'menu_metodo' => 'listar'],
                'vis' => ['menu_controller' => 'funcionario-ver-atendimento', 'menu_metodo' => 'ver-iniciado'],
                'edit' => ['menu_controller' => 'funcionario-editar-atendimento', 'menu_metodo' => 'edit-iniciado']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new AdmsListarAtendimentoPendente();
        $this->Dados['listAtendimentoEmAndamento']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new ConfigView("adms/Views/atendimento/funcionario/atendimentoEmAndamento", $this->Dados);
        $carregarView->renderizar();
    }



}