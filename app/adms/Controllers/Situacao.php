<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:04
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarSit;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Situacao
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit', 'menu_metodo' => 'cad-sit'],
            'vis_sit' => ['menu_controller' => 'ver-sit', 'menu_metodo' => 'ver-sit'],
            'edit_sit' => ['menu_controller' => 'editar-sit', 'menu_metodo' => 'edit-sit'],
            'del_sit' => ['menu_controller' => 'apagar-sit', 'menu_metodo' => 'apagar-sit']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSit = new AdmsListarSit();
        $this->Dados['listSit'] = $listarSit->listarSit($this->PageId);
        $this->Dados['paginacao'] = $listarSit->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/situacao/listarSit", $this->Dados);
        $carregarView->renderizar();
    }

}