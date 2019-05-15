<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:09
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarCor;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarCor
{

    private $Dados;

    public function cadCor()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCor'])) {
            unset($this->Dados['CadCor']);
            $cadCor = new AdmsCadastrarCor();
            $cadCor->cadCor($this->Dados);
            if ($cadCor->getResultado()) {
                $UrlDestino = URLADM . 'cor/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCorViewPriv();
            }
        } else {
            $this->cadCorViewPriv();
        }
    }

    private function cadCorViewPriv()
    {
        $botao = ['list_cor' => ['menu_controller' => 'cor', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new ConfigView("adms/Views/cor/cadCor", $this->Dados);
        $carregarView->renderizar();
    }

}