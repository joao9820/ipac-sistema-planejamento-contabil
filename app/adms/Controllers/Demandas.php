<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 13:39
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Demandas
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;
        //echo "Pagina {$this->PageId} <br>";


        //Array botoes
        $botao = ['cad_demanda' => ['menu_controller' => 'cadastrar-demanda', 'menu_metodo' => 'cad-demanda'],
            'vis_demanda' => ['menu_controller' => 'ver-demanda', 'menu_metodo' => 'ver-demanda'],
            'edit_demanda' => ['menu_controller' => 'editar-demanda', 'menu_metodo' => 'edit-demanda'],
            'del_demanda' => ['menu_controller' => 'apagar-demanda', 'menu_metodo' => 'apagar-demanda']];
        //var_dump($botao);
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);


        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();


        $listarDemandas = new \App\adms\Models\AdmsListarDemandas();
        $this->Dados['listDemanda']= $listarDemandas->listarDemandas($this->PageId);
        $this->Dados['paginacao'] = $listarDemandas->getResultadoPg();


        $carregarView = new \Core\ConfigView('adms/Views/gerenciar/listarDemandas', $this->Dados);
        $carregarView->renderizar();
    }

}