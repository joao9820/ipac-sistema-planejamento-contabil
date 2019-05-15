<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:23
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarSitUser;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class CadastrarSitUser
{

    private $Dados;

    public function cadSitUser()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSitUser'])) {
            unset($this->Dados['CadSitUser']);
            $cadSitUser = new AdmsCadastrarSitUser();
            $cadSitUser->cadSitUser($this->Dados);
            if ($cadSitUser->getResultado()) {
                $UrlDestino = URLADM . 'situacao-user/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitUserViewPriv();
            }
        } else {
            $this->cadSitUserViewPriv();
        }
    }

    private function cadSitUserViewPriv()
    {
        $listarSelect = new AdmsCadastrarSitUser();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_sit' => ['menu_controller' => 'situacao-user', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/situacaoUser/cadSitUser", $this->Dados);
        $carregarView->renderizar();
    }

}