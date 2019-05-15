<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerAtividades;
use App\adms\Models\AdmsVerDemanda;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerDemanda
{

    private $Dados;
    private $DadosId;

    public function verDemanda($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        //echo $this->DadosId;
        if (!empty($this->DadosId)) {

            $verDemanda = new AdmsVerDemanda();
            $this->Dados['dados_demanda'] = $verDemanda->verDemanda($this->DadosId);

            $botao = ['list_demanda' => ['menu_controller' => 'demandas', 'menu_metodo' => 'listar'],
                'edit_demanda' => ['menu_controller' => 'editar-demanda', 'menu_metodo' => 'edit-demanda'],
                'del_demanda' => ['menu_controller' => 'apagar-demanda', 'menu_metodo' => 'apagar-demanda']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);


            $botaoAtividade = ['list_atividade' => ['menu_controller' => 'atividades', 'menu_metodo' => 'listar'],
                'cad_atividade' => ['menu_controller' => 'cadastrar-atividade', 'menu_metodo' => 'cad-atividade'],
                'vis_atividade' => ['menu_controller' => 'ver-atividade', 'menu_metodo' => 'ver-atividade'],
                'edit_atividade' => ['menu_controller' => 'editar-atividade', 'menu_metodo' => 'edit-atividade'],
                'del_atividade' => ['menu_controller' => 'apagar-atividade', 'menu_metodo' => 'apagar-atividade']];
            $botaoAtividadeListar = new AdmsBotao();
            $this->Dados['botaoAtividade'] = $botaoAtividadeListar->valBotao($botaoAtividade);


            $listarAtividade = new AdmsVerAtividades();
            $this->Dados['atividades'] = $listarAtividade->verAtividade($this->DadosId);
            $this->Dados['totalHorasAtividades'] = $listarAtividade->getResultHoras();

            //$this->Dados['botaoDemanda'] = $this->DadosId;

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView('adms/Views/gerenciar/verDemanda', $this->Dados);
            $carregarView->renderizar();

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nenhuma demanda encontrada!","danger");
            $UrlDestino = URLADM . 'demandas/listar';
            header("Location: $UrlDestino");

        }


    }

}