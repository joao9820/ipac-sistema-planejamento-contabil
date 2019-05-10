<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 21:24
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarNivAc;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class NivelAcesso
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_nivac' => ['menu_controller' => 'cadastrar-niv-ac', 'menu_metodo' => 'cad-niv-ac'],
            'list_permi' => ['menu_controller' => 'permissoes', 'menu_metodo' => 'listar'],
            'vis_nivac' => ['menu_controller' => 'ver-niv-ac', 'menu_metodo' => 'ver-niv-ac'],
            'edit_nivac' => ['menu_controller' => 'editar-niv-ac', 'menu_metodo' => 'edit-niv-ac'],
            'del_nivac' => ['menu_controller' => 'apagar-niv-ac', 'menu_metodo' => 'apagar-niv-ac'],
            'ordem_nivac' => ['menu_controller' => 'alt-ordem-niv-ac', 'menu_metodo' => 'alt-ordem-niv-ac'],
            'sincro_permi' => ['menu_controller' => 'sincro-pg-niv-ac', 'menu_metodo' => 'sincro-pg-niv-ac']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarNivAc = new AdmsListarNivAc();
        $this->Dados['listNivAc'] = $listarNivAc->listarNivAc($this->PageId);
        $this->Dados['paginacao'] = $listarNivAc->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/nivAcesso/listarNicAc", $this->Dados);
        $carregarView->renderizar();
    }

}