<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:24
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarGrupoPg;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class GrupoPg
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_grpg' => ['menu_controller' => 'cadastrar-grupo-pg', 'menu_metodo' => 'cad-grupo-pg'],
            'vis_grpg' => ['menu_controller' => 'ver-grupo-pg', 'menu_metodo' => 'ver-grupo-pg'],
            'edit_grpg' => ['menu_controller' => 'editar-grupo-pg', 'menu_metodo' => 'edit-grupo-pg'],
            'del_grpg' => ['menu_controller' => 'apagar-grupo-pg', 'menu_metodo' => 'apagar-grupo-pg'],
            'ordem_grpg' => ['menu_controller' => 'alt-ordem-grupo-pg', 'menu_metodo' => 'alt-ordem-grupo-pg']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarGrupoPg = new AdmsListarGrupoPg();
        $this->Dados['listGrupoPg'] = $listarGrupoPg->listarGrupoPg($this->PageId);
        $this->Dados['paginacao'] = $listarGrupoPg->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/grupoPg/listarGrupoPg", $this->Dados);
        $carregarView->renderizar();
    }

}