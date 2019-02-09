<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 08/02/2019
 * Time: 22:22
 */

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class PesqUsuarios
{

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function listar($PageId = null)
    {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->DadosForm['PesqUsuario'])) {
            unset($this->DadosForm['PesqUsuario']);

            $listarUsario = new \App\adms\Models\CpAdmsListarUsuario();
            $this->Dados['listUser'] = $listarUsario->pesquisarUsuarios($this->PageId, $this->DadosForm);
            $this->Dados['paginacao'] = $listarUsario->getResultadoPg();
        }
        /* $listarUsario = new \App\adms\Models\AdmsListarUsuario();
          $this->Dados['listUser'] = $listarUsario->listarUsuario($this->PageId);
          $this->Dados['paginacao'] = $listarUsario->getResultadoPg(); */

        $carregarView = new \Core\ConfigView("adms/Views/usuario/pesqUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}