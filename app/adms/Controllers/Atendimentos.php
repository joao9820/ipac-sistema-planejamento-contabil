<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 02/04/2019
 * Time: 13:55
 */

namespace App\adms\Controllers;

use Core\ConfigView;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsListarAtendimentoPendente;
use App\adms\Models\AdmsPlanejamento;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Atendimentos
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
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarAtendimento = new AdmsListarAtendimentoPendente();
        $this->Dados['jornadaDeTrabalho'] = $listarAtendimento->verCargaHoraria();
        $this->Dados['listarAtendimentos']= $listarAtendimento->listarAtendimento($this->PageId);
        $this->Dados['listarAtendimentosInterrompido'] = $listarAtendimento->atendimentoInterrompido();
        $this->Dados['paginacao'] = $listarAtendimento->getResultadoPg();


        $this->Dados['pg'] = $this->PageId;


        $verPlanejamento = new AdmsPlanejamento();
        $this->Dados['planejamento'] = $verPlanejamento->verPlanejamento();


        $carregarView = new ConfigView("adms/Views/atendimento/funcionario_view/funcionarioDemandas", $this->Dados);
        $carregarView->renderizar();

    }

}