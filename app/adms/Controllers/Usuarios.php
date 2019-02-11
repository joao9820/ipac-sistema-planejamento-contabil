<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Usuarios
{
    private $Dados;
    private $PageId;
    private $TipoResultado;
    private $PesqUsuario;

    public function listar($PageId = null)
    {

        $this->TipoResultado = filter_input(INPUT_GET, 'tiporesult');
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        if (!empty($this->TipoResultado) AND ( $this->TipoResultado == 1)) {
            $this->listarUsuariosPriv();
        } elseif (!empty($this->TipoResultado) AND ( $this->TipoResultado == 2)) {
            $this->PesqUsuario = filter_input(INPUT_POST, 'palavraPesq');
            //echo $this->PesqUsuario . "<br>";
            $this->pesqUsuariosPriv();
        } else {
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/usuario/carregarUsuarios", $this->Dados);
            $carregarView->renderizar();
        }

    }

    private function listarUsuariosPriv()
    {
        $listarUsario = new \App\adms\Models\AdmsListarUsuario();
        $this->Dados['listUser'] = $listarUsario->listarUsuario($this->PageId);
        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/usuario/listarUsuario", $this->Dados);
        $carregarView->renderizarListar();
    }

    private function pesqUsuariosPriv()
    {
        $listarUsario = new \App\adms\Models\AdmsPesqUsuario();
        $this->Dados['listUser'] = $listarUsario->pesqUsuario($this->PesqUsuario);

        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/usuario/listarUsuario", $this->Dados);
        $carregarView->renderizarListar();
    }


}
