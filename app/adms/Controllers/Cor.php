<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:46
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarCor;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Cor
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cor' => ['menu_controller' => 'cadastrar-cor', 'menu_metodo' => 'cad-cor'],
            'vis_cor' => ['menu_controller' => 'ver-cor', 'menu_metodo' => 'ver-cor'],
            'edit_cor' => ['menu_controller' => 'editar-cor', 'menu_metodo' => 'edit-cor'],
            'del_cor' => ['menu_controller' => 'apagar-cor', 'menu_metodo' => 'apagar-cor']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCor = new AdmsListarCor();
        $this->Dados['listCor'] = $listarCor->listarCor($this->PageId);
        $this->Dados['paginacao'] = $listarCor->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/cor/listarCor", $this->Dados);
        $carregarView->renderizar();
    }

}