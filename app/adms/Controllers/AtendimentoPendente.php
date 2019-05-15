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

class AtendimentoPendente
{
    private $Dados;
    private $PageId;
    private $DadosModal;
    public function listar($PageId = null)
    {

        $this->DadosModal = filter_input_array(INPUT_GET, 'modal', FILTER_DEFAULT);
        $this->PageId = (int) $PageId ? $PageId : 1;

        //Array botoes
        $botao = ['em_andamento' => ['menu_controller' => 'atendimento-em-andamento', 'menu_metodo' => 'listar'],
            'vis' => ['menu_controller' => 'funcionario-ver-atendimento', 'menu_metodo' => 'ver'],
            'edit' => ['menu_controller' => 'funcionario-editar-atendimento', 'menu_metodo' => 'edit'],
            'conclu' => ['menu_controller' => 'func-concluir-atendimento', 'menu_metodo' => 'concluir']];
        //var_dump($botao);
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new AdmsListarAtendimentoPendente();
        $this->Dados['jornadaDeTrabalho'] = $listarAtendimento->verCargaHoraria();
        $this->Dados['listAtendimentoPendente']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();
        $this->Dados['listAtendimentoPendenteUrgente'] = $listarAtendimento->listarAtendimentoUrgente();
        $this->Dados['listAtendimentoFinalizado'] = $listarAtendimento->listarAtendimentoFinalizado();

        $this->Dados['pg'] = $this->PageId;

        $carregarView = new ConfigView("adms/Views/atendimento/funcionario/atendimentoPendente", $this->Dados);
        $carregarView->renderizar();
    }


}