<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:34
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarSitPg;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class SituacaoPg
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-pg', 'menu_metodo' => 'cad-sit-pg'],
            'vis_sit' => ['menu_controller' => 'ver-sit-pg', 'menu_metodo' => 'ver-sit-pg'],
            'edit_sit' => ['menu_controller' => 'editar-sit-pg', 'menu_metodo' => 'edit-sit-pg'],
            'del_sit' => ['menu_controller' => 'apagar-sit-pg', 'menu_metodo' => 'apagar-sit-pg']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSitPg = new AdmsListarSitPg();
        $this->Dados['listSitPg'] = $listarSitPg->listarSitPg($this->PageId);
        $this->Dados['paginacao'] = $listarSitPg->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/situacaoPg/listarSitPg", $this->Dados);
        $carregarView->renderizar();
    }

}