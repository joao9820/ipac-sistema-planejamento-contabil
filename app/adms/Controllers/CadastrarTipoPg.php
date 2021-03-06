<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:40
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarTipoPg;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarTipoPg
{

    private $Dados;

    public function cadTipoPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTipoPg'])) {
            unset($this->Dados['CadTipoPg']);
            $cadTipoPg = new AdmsCadastrarTipoPg();
            $cadTipoPg->cadTipoPg($this->Dados);
            if ($cadTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'tipo-pg/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTipoPgViewPriv();
            }
        } else {
            $this->cadTipoPgViewPriv();
        }
    }

    private function cadTipoPgViewPriv()
    {
        $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/tipoPg/cadTipoPg", $this->Dados);
        $carregarView->renderizar();
    }

}