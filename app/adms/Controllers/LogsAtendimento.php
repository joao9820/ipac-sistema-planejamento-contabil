<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 19/02/2019
 * Time: 17:07
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerLogsAtendimento;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class LogsAtendimento
{
    private $Dados;
    private $DadosId;
    private $PageId;

    public function listar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg",FILTER_SANITIZE_NUMBER_INT);

        if (!empty($this->DadosId))
        {
            $verLogsAtend = new AdmsVerLogsAtendimento();
            $this->Dados['logsAtendimento'] = $verLogsAtend->verLogsAtendimento($this->DadosId);


            $botao = ['vis_atendimento' => ['menu_controller' => 'atendimento-gerente', 'menu_metodo' => 'ver']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $this->Dados['pg'] = $this->PageId;

            $this->Dados['id_atendimento'] = $this->DadosId;

            $carregarView = new ConfigView("adms/Views/gerenciar/verLogsAtendimentos", $this->Dados);
            $carregarView->renderizar();

        } else {
            $UrlDestino = URLADM . 'gerenciar-atendimento/listar';
            header("Location: $UrlDestino");
        }



    }

}