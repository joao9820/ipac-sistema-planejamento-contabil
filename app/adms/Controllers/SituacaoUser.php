<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:17
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarSitUser;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class SituacaoUser
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-user', 'menu_metodo' => 'cad-sit-user'],
            'vis_sit' => ['menu_controller' => 'ver-sit-user', 'menu_metodo' => 'ver-sit-user'],
            'edit_sit' => ['menu_controller' => 'editar-sit-user', 'menu_metodo' => 'edit-sit-user'],
            'del_sit' => ['menu_controller' => 'apagar-sit-user', 'menu_metodo' => 'apagar-sit-user']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSitUser = new AdmsListarSitUser();
        $this->Dados['listSitUser'] = $listarSitUser->listarSitUser($this->PageId);
        $this->Dados['paginacao'] = $listarSitUser->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/situacaoUser/listarSitUser", $this->Dados);
        $carregarView->renderizar();
    }

}