<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 14/02/2019
 * Time: 12:07
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerAtendimentoFuncionario;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class FuncionarioVerAtendimento
{
    private $Dados;
    private $DadosId;
    private $PageId;

    public function ver($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);

        if (!empty($this->DadosId)) {

            $verAtendimento = new AdmsVerAtendimentoFuncionario();
            $this->Dados['verAtendimentoFuncionario'] = $verAtendimento->verAtendimento($this->DadosId);
            $this->Dados['total_horas_atendimento'] = $verAtendimento->verTotalHoras($this->Dados['verAtendimentoFuncionario'][0]['id_demanda']);

            $botao = ['edit_atendimento' => ['menu_controller' => 'atendimento-funcionario', 'menu_metodo' => 'editar'],
                'list_atendimento' => ['menu_controller' => 'atendimento-pendente', 'menu_metodo' => 'listar']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            if ($this->PageId){
                $this->Dados['pg'] = $this->PageId;
            } else {
                $this->Dados['pg'] = 1;
            }

            $carregarView = new ConfigView('adms/Views/atendimento/funcionario_view/verAtendimentoFuncionario', $this->Dados);
            $carregarView->renderizar();
        }
        else {
            $UrlDestino = URLADM . 'atendimentos/listar';
            header("Location: $UrlDestino");
        }

    }

}