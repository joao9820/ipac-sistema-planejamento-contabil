<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 28/01/2019
 * Time: 13:19
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarDemanda
{

    private $Dados;

    public function cadDemanda()
    {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadDemanda']))
        {

            unset($this->Dados['CadDemanda']);
            //var_dump($this->Dados);

            $cadDemanda = new \App\adms\Models\AdmsCadastrarDemanda();
            $cadDemanda->cadDemanda($this->Dados);
            if ($cadDemanda->getResultado())
            {

                $UrlDestino = URLADM .'demandas/listar';
                header("Location: $UrlDestino");

            }
            else {

                $this->Dados['form'] = $this->Dados;
                $this->cadDemandaViewPriv();

            }

        } else {

            $this->cadDemandaViewPriv();

        }

    }

    private function cadDemandaViewPriv()
    {
        //Carregar e exibir o botão de acordo com o nível de acesso
        $botao = ['list_demanda' => ['menu_controller' => 'demandas', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        //Carregar Menu
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        //Carregar a view
        $carregarView = new \Core\ConfigView("adms/Views/gerenciar/cadDemanda", $this->Dados);
        $carregarView->renderizar();

    }

}