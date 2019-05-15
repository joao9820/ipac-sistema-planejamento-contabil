<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 08/02/2019
 * Time: 22:22
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\CpAdmsPesqUsuario;
use Core\ConfigView;

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

        $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar'],
            'cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->DadosForm['PesqUsuario'])) {
            unset($this->DadosForm['PesqUsuario']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['nome'] = filter_input(INPUT_GET, 'nome', FILTER_DEFAULT);
            $this->DadosForm['email'] = filter_input(INPUT_GET, 'email', FILTER_DEFAULT);
        }

        $listarUsario = new CpAdmsPesqUsuario();
        $this->Dados['listUser'] = $listarUsario->pesquisarUsuarios($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/usuario/pesqUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}