<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/01/2019
 * Time: 11:47
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarAtividade;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsRead;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarAtividade
{

    private $Dados;
    private $DadosId;

    public function cadAtividade($DadosId = null)
    {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->Dados['CadAtividade']))
        {
            unset($this->Dados['CadAtividade']);

            $cadAtividade = new AdmsCadastrarAtividade();
            $cadAtividade->cadAtividade($this->Dados);
            if ($cadAtividade->getResultado())
            {

                $UrlDestino = URLADM .'ver-demanda/ver-demanda/' . $this->DadosId;
                header("Location: $UrlDestino");

            }
            else {

                $this->verDemandaId();
                $this->Dados['form'] = $this->Dados;
                $this->cadAtividadeViewPriv();

            }

        } else {

            $this->verDemandaId();

            $this->cadAtividadeViewPriv();

        }

    }

    private function cadAtividadeViewPriv()
    {
        //Carregar e exibir o botão de acordo com o nível de acesso
        $botao = ['list_demanda' => ['menu_controller' => 'demandas', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        //Carregar Menu
        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        //Carregar a view
        $carregarView = new ConfigView("adms/Views/gerenciar/cadAtividade", $this->Dados);
        $carregarView->renderizar();

    }

    private function verDemandaId()
    {
        $verDemanda = new AdmsRead();
        $verDemanda->fullRead("SELECT id 
                        FROM adms_demandas dmd 
                        WHERE id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        $this->Dados['form_demanda_id'] = $verDemanda->getResultado();
    }

}