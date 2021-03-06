<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 00:40
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarMenu;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarMenu
{

    private $Dados;

    public function cadMenu()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadMenu'])) {
            unset($this->Dados['CadMenu']);
            $cadMenu = new AdmsCadastrarMenu();
            $cadMenu->cadMenu($this->Dados);
            if ($cadMenu->getResultado()) {
                $UrlDestino = URLADM . 'menu/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadMenuViewPriv();
            }
        } else {
            $this->cadMenuViewPriv();
        }
    }

    private function cadMenuViewPriv()
    {
        $listarSelect = new AdmsCadastrarMenu();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_menu' => ['menu_controller' => 'menu', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new ConfigView("adms/Views/menu/cadMenu", $this->Dados);
        $carregarView->renderizar();
    }

}