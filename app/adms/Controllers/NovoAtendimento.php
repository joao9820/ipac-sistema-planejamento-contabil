<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 31/01/2019
 * Time: 14:43
 */

namespace App\adms\Controllers;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class NovoAtendimento
{

    private $Dados;

    public function novo()
    {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadAtendimento']))
        {

            unset($this->Dados['CadAtendimento']);
            //var_dump($this->Dados);

            $cadAtendimento = new \App\adms\Models\AdmsCadastrarAtendimento();
            $cadAtendimento->cadAtendimento($this->Dados);
            if ($cadAtendimento->getResultado())
            {

                $UrlDestino = URLADM .'atendimento/listar';
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;
                $this->cadAtendimentoViewPriv();

            }

        } else {

            $this->cadAtendimentoViewPriv();

        }

    }

    private function cadAtendimentoViewPriv()
    {
        // Listar demandas
        $listarDemandas = new \App\adms\Models\AdmsCadastrarAtendimento();
        $this->Dados['demandas'] = $listarDemandas->listarDemandas();
        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
            $this->Dados['empresas'] = $listarDemandas->listarEmpresas();
        }

        //Carregar e exibir o botão de acordo com o nível de acesso
        $botao = ['list_atendimento' => ['menu_controller' => 'atendimento', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        //Carregar Menu
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        //Carregar a view
        $carregarView = new \Core\ConfigView("adms/Views/atendimento/cadAtendimento", $this->Dados);
        $carregarView->renderizar();

    }
}

