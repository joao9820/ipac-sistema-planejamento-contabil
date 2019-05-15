<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:39
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarSitPg;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarSitPg
{

    private $Dados;

    public function cadSitPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSitPg'])) {
            unset($this->Dados['CadSitPg']);
            $cadSitPg = new AdmsCadastrarSitPg();
            $cadSitPg->cadSitPg($this->Dados);
            if ($cadSitPg->getResultado()) {
                $UrlDestino = URLADM . 'situacao-pg/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitPgViewPriv();
            }
        } else {
            $this->cadSitPgViewPriv();
        }
    }

    private function cadSitPgViewPriv()
    {
        $botao = ['list_sit' => ['menu_controller' => 'situacao-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/situacaoPg/cadSitPg", $this->Dados);
        $carregarView->renderizar();
    }

}