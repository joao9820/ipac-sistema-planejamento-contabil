<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:29
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarGrupoPg;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarGrupoPg
{

    private $Dados;

    public function cadGrupoPg()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadGrupoPg'])) {
            unset($this->Dados['CadGrupoPg']);
            $cadGrupoPg = new AdmsCadastrarGrupoPg();
            $cadGrupoPg->cadGrupoPg($this->Dados);
            if ($cadGrupoPg->getResultado()) {
                $UrlDestino = URLADM . 'grupo-pg/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadGrupoPgViewPriv();
            }
        } else {
            $this->cadGrupoPgViewPriv();
        }
    }

    private function cadGrupoPgViewPriv()
    {
        $botao = ['list_grpg' => ['menu_controller' => 'grupo-pg', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/grupoPg/cadGrupoPg", $this->Dados);
        $carregarView->renderizar();
    }

}