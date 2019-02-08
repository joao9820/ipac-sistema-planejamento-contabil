<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:05
 */

namespace App\adms\Controllers;

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

            $verDemanda = new \App\adms\Models\AdmsVerDemanda();
            $this->Dados['dados_demanda'] = $verDemanda->verDemanda($this->DadosId);

            $botao = ['list_demanda' => ['menu_controller' => 'demandas', 'menu_metodo' => 'listar'],
                'edit_demanda' => ['menu_controller' => 'editar-demanda', 'menu_metodo' => 'edit-demanda'],
                'del_demanda' => ['menu_controller' => 'apagar-demanda', 'menu_metodo' => 'apagar-demanda']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);


            $botaoAtividade = ['list_atividade' => ['menu_controller' => 'atividades', 'menu_metodo' => 'listar'],
                'cad_atividade' => ['menu_controller' => 'cadastrar-atividade', 'menu_metodo' => 'cad-atividade'],
                'vis_atividade' => ['menu_controller' => 'ver-atividade', 'menu_metodo' => 'ver-atividade'],
                'edit_atividade' => ['menu_controller' => 'editar-atividade', 'menu_metodo' => 'edit-atividade'],
                'del_atividade' => ['menu_controller' => 'apagar-atividade', 'menu_metodo' => 'apagar-atividade']];
            $botaoAtividadeListar = new \App\adms\Models\AdmsBotao();
            $this->Dados['botaoAtividade'] = $botaoAtividadeListar->valBotao($botaoAtividade);


            $listarAtividade = new \App\adms\Models\AdmsVerAtividades();
            $this->Dados['atividades'] = $listarAtividade->verAtividade($this->DadosId);
            $this->Dados['totalHorasAtividades'] = $listarAtividade->getResultHoras();

            //$this->Dados['botaoDemanda'] = $this->DadosId;

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView('adms/Views/gerenciar/verDemanda', $this->Dados);
            $carregarView->renderizar();

        } else {

            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Nenhuma demanda encontrada!</div>';
            $UrlDestino = URLADM . 'demandas/listar';
            header("Location: $UrlDestino");

        }


    }

}