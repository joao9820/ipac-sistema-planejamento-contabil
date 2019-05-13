<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarUsuario;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Usuarios
{
    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarUsario = new AdmsListarUsuario();
        $this->Dados['listUser'] = $listarUsario->listarUsuario($this->PageId);
        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/usuario/listarUsuario", $this->Dados);
        $carregarView->renderizar();
    }


}
